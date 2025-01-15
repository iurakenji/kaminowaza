<?= $this->extend('layouts/main'); ?>
<?php helper('form'); ?>
<?php $this->section('content'); ?>

            <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-center space-x-4">
                <form action="<?= current_url() ?>" method="get" class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
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
                        ], isset($mes) ? $mes : date('m'), ['id' => 'mes', 'class' => 'rounded border-gray-300 focus:ring-indigo-500 focus:border-indigo-500']); ?>
                    </div>
                    <div class="flex items-center space-x-2">
                        <label for="ano" class="text-gray-700 font-medium whitespace-nowrap">Ano</label>
                        <?= form_input('ano', isset($ano) ? $ano : date('Y'), ['id' => 'ano', 'class' => 'w-24 rounded border-gray-300 focus:ring-indigo-500 focus:border-indigo-500'], 'number'); ?>
                    </div>
                    <button type="submit" class="bg-indigo-600 text-white font-semibold px-4 py-2 rounded-lg shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">Pesquisar</button>
                </form>
            </div>

            <table class="w-full">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Dom</th>
                        <th class="px-6 py-3 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Seg</th>
                        <th class="px-6 py-3 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Ter</th>
                        <th class="px-6 py-3 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Qua</th>
                        <th class="px-6 py-3 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Qui</th>
                        <th class="px-6 py-3 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Sex</th>
                        <th class="px-6 py-3 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Sáb</th>
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
                                <td class="px-6 py-4 whitespace-no-wrap border-t border-gray-200 text-center">
                                    <?php if ($week === 0 && $day < $firstDayOfMonth || $currentDay > $daysInMonth): ?>
                                        <!-- Empty Cell -->
                                    <?php else: ?>
                                        <?php if (date('Y-m-d') == $ano . '-' . $mes . '-' . str_pad($currentDay, 2, '0', STR_PAD_LEFT)): ?>
                                            <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform bg-indigo-600 rounded-full"><?= $currentDay ?></span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-gray-900 transform"><?= $currentDay ?></span>
                                        <?php endif; ?>
                                        <div class="mt-2">
                                            <?php foreach ($ocorrencias as $ocorrencia): ?>
                                                <?php if (date('Y-m-d', strtotime($ocorrencia['inicio'])) == $ano . '-' . $mes . '-' . str_pad($currentDay, 2, '0', STR_PAD_LEFT)): ?>
                                                    <div class="lg:text-sm text-pretty font-semibold text-indigo-600 break-words sm:text-xs md:text-sm"><?= $ocorrencia['titulo'] ?></div>
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

<?php $this->endSection(); ?>