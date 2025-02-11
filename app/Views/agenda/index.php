<?= $this->extend('layouts/main'); ?>
<?php helper('form'); ?>
<?php $this->section('content'); ?>

<div class="bg-white p-4 sm:p-6 rounded-lg shadow-md flex flex-col space-y-4">
    <!-- Formulário -->
    <form action="<?= current_url() ?>" method="get" class="flex flex-wrap items-center space-y-2 sm:space-y-0 sm:space-x-4">
        <div class="flex items-center space-x-2 w-full sm:w-auto">
            <label for="mes" class="text-gray-700 font-medium whitespace-nowrap">Mês</label>
            <?= form_dropdown('mes', [
                '01' => 'Janeiro',
                '02' => 'Fevereiro',
                '03' => 'Março',
                '04' => 'Abril',
                '05' => 'Maio',
                '06' => 'Junho',
                '07' => 'Julho',
                '08' => 'Agosto',
                '09' => 'Setembro',
                '10' => 'Outubro',
                '11' => 'Novembro',
                '12' => 'Dezembro'
            ], isset($mes) ? $mes : date('m'), ['id' => 'mes', 'class' => 'rounded border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 w-full sm:w-auto']); ?>
        </div>
        <div class="flex items-center space-x-2 w-full sm:w-auto">
            <label for="ano" class="text-gray-700 font-medium whitespace-nowrap">Ano</label>
            <?= form_input('ano', isset($ano) ? $ano : date('Y'), ['id' => 'ano', 'class' => 'w-full sm:w-24 rounded border-gray-300 focus:ring-indigo-500 focus:border-indigo-500'], 'number'); ?>
        </div>
        <button type="submit" class="bg-indigo-600 text-white font-semibold px-4 py-2 rounded-lg shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 w-full sm:w-auto">
            Pesquisar
        </button>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full table-fixed border-collapse border border-gray-300">
            <thead>
                <tr>
                    <th class="w-1/7 px-2 sm:px-6 py-2 sm:py-3 text-center text-xs sm:text-sm font-medium text-gray-500 uppercase border border-gray-300">Dom</th>
                    <th class="w-1/7 px-2 sm:px-6 py-2 sm:py-3 text-center text-xs sm:text-sm font-medium text-gray-500 uppercase border border-gray-300">Seg</th>
                    <th class="w-1/7 px-2 sm:px-6 py-2 sm:py-3 text-center text-xs sm:text-sm font-medium text-gray-500 uppercase border border-gray-300">Ter</th>
                    <th class="w-1/7 px-2 sm:px-6 py-2 sm:py-3 text-center text-xs sm:text-sm font-medium text-gray-500 uppercase border border-gray-300">Qua</th>
                    <th class="w-1/7 px-2 sm:px-6 py-2 sm:py-3 text-center text-xs sm:text-sm font-medium text-gray-500 uppercase border border-gray-300">Qui</th>
                    <th class="w-1/7 px-2 sm:px-6 py-2 sm:py-3 text-center text-xs sm:text-sm font-medium text-gray-500 uppercase border border-gray-300">Sex</th>
                    <th class="w-1/7 px-2 sm:px-6 py-2 sm:py-3 text-center text-xs sm:text-sm font-medium text-gray-500 uppercase border border-gray-300">Sáb</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $firstDayOfMonth = date('w', strtotime($ano . '-' . $mes . '-01'));
                $daysInMonth = date('t', strtotime($ano . '-' . $mes . '-01'));
                $currentDay = 1;

                for ($week = 0; $week < ceil(($daysInMonth + $firstDayOfMonth) / 7); $week++):
                ?>
                    <tr>
                        <?php for ($day = 0; $day < 7; $day++): ?>
                            <td class="w-1/7 px-2 sm:px-4 py-2 sm:py-4 h-20 min-h-[5rem] whitespace-normal break-words border border-gray-300 text-center align-top overflow-y-auto">
                                <?php if ($week === 0 && $day < $firstDayOfMonth || $currentDay > $daysInMonth): ?>
                                    <!-- Célula vazia -->
                                <?php else: ?>
                                    <?php if (date('Y-m-d') == $ano . '-' . $mes . '-' . str_pad($currentDay, 2, '0', STR_PAD_LEFT)): ?>
                                        <span class="inline-flex items-center justify-center px-2 py-1 text-[10px] sm:text-xs font-bold leading-none text-white bg-indigo-600 rounded-full"><?= $currentDay ?></span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center justify-center px-2 py-1 text-[10px] sm:text-xs font-bold leading-none text-gray-900"><?= $currentDay ?></span>
                                    <?php endif; ?>
                                    <div class="mt-2">
                                        <?php foreach ($ocorrencias as $ocorrencia): ?>
                                            <?php if (date('Y-m-d', strtotime($ocorrencia['inicio'])) == $ano . '-' . $mes . '-' . str_pad($currentDay, 2, '0', STR_PAD_LEFT)): ?>
                                                <div x-data="{ truncatedTitle: '<?= $ocorrencia['titulo'] ?>', isTruncated: true, showModal: false, modalData: {} }"
                                                    @touchstart="showModal = true; modalData = <?= htmlspecialchars(json_encode($ocorrencia), ENT_QUOTES, 'UTF-8') ?>"
                                                    @touchend="showModal = false"
                                                    @click="showModal = true; modalData = <?= htmlspecialchars(json_encode($ocorrencia), ENT_QUOTES, 'UTF-8') ?>"
                                                    class="cursor-pointer">
                                                    <div x-text="isTruncated ? truncatedTitle.split(' ')[0] : truncatedTitle" class="sm:text-[0.3rem] text-xs font-semibold text-indigo-600 break-words"></div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php $currentDay++; ?>
                                <?php endif; ?>
                            </td>
                        <?php endfor; ?>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>
</div>

<div x-data="{ showModal: false, modalData: {} }"
     x-show="showModal"
     @touchstart.away="showModal = false"
     class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-11/12 sm:w-96">
        <h2 class="text-xl font-semibold text-indigo-600" x-text="modalData.titulo"></h2>
        <p class="text-gray-700 mt-2" x-text="modalData.observacao"></p>
        <p class="text-gray-500 mt-2" x-text="'Início: ' + modalData.inicio"></p>
        <p class="text-gray-500 mt-2" x-text="'Término: ' + modalData.termino"></p>
        <button @click="showModal = false" class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 focus:outline-none">
            Fechar
        </button>
    </div>
</div>

<?php $this->endSection(); ?>
