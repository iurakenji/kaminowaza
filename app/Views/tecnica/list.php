<?= $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>
    </div>
    <div class="w-auto mx-4 px-8">
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <?php foreach ($normas as $norma) : ?>
            <div class="max-w-sm bg-job border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <img class="rounded-t-md p-5" src="/images/normas/<?= $norma['image_path'] ?>" alt="" />
                <div class="p-5">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><?= $norma['nome'] ?></h5>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"><?= $norma['descricao'] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php $this->endSection(); ?>