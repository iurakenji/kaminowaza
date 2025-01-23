<?= $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>

<div class="mx-auto w-full p-4">
    <div class="flex flex-wrap gap-6 justify-center">
        <?php foreach ($nafudakake as $key => $value) : ?>
            <div class="flex flex-col items-center  w-full sm:w-1/3 md:w-1/4 lg:w-1/6 bg-white shadow-md rounded-lg border border-gray-200 p-4">
                <h5 style="writing-mode: vertical-rl; text-orientation: upright;" class="mb-3 lg:text-xl md:text-md sm:text-sm font-bold text-center text-gray-900 dark:text-white border-b">
                    <?= $value['graduacao']['nome_japones'] ?>
                </h5>
                <h6 class="text-sm font-bold text-center text-gray-900 dark:text-white border-b pb-2 mb-4">
                    <?= $value['graduacao']['nome'] . ' (Faixa ' . $value['graduacao']['cor_faixa'] . ')' ?>
                </h6>
                <ul style="writing-mode: vertical-rl; text-orientation: upright;"  class="flex flex-col gap-2 w-full">
                    <?php foreach ($value['alunos'] as $nome) : ?>
                        <li class="text-gray-800 dark:text-gray-200 bg-gray-50 dark:bg-gray-700 p-2 rounded-lg shadow">
                            <?= $nome ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php $this->endSection(); ?>