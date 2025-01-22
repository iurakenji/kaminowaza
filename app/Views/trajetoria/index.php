<?= $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>
    <div class="mx-auto w-auto">
        <div class="flex md:flex-col lg:flex-col sm:flex-row gap-4">
            <div class="p-4 bg-white rounded shadow-md dark:bg-gray-800">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Dados do Aluno</h2>
                <div class="mt-2">
                    <div class="w-16 h-16 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                        <img src="<?= '/images/users/'. $aluno['image_path'] ?? '' ?>" alt="Imagem" class="object-cover">
                    </div>
                    <p class="text-sm pb-4 text-gray-600 dark:text-gray-300">Nome: <?= $aluno['nome'] ?? 'Não informado' ?></p>
                    <p class="text-sm pb-4 text-gray-600 dark:text-gray-300">Idade: <?= $aluno['idade'] ?? 'Não informado' ?></p>
                    <p class="text-sm pb-4 text-gray-600 dark:text-gray-300">Graduação: <?= $aluno['graduacao'] ?? 'Não informado' ?></p>
                </div>
            </div>
            <ol class="relative m-4 p-4 text-gray-500 border-s border-gray-600 dark:border-gray-700 dark:text-gray-400">                  
                <li class="mb-10 ms-6">            
                    <span class="absolute flex items-center justify-center w-8 h-8 bg-green-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-green-900">
                        <svg class="w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                        </svg>
                    </span>
                    <h3 class="font-medium leading-tight">Início dos Treinos</h3>
                    <p class="text-sm"><?= date('d/m/Y', strtotime($aluno['inicio_treinos'])) ?></p>
                </li>
                <?php foreach ($trajetoria as $step) : ?>
                <li class="mb-10 ms-6">
                    <span class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                        <svg class="w-8 h-8" width="24" height="24">
                            <use xlink:href="images/trajetoria-sprites.svg#<?= $step['icon'] ?>"></use>
                        </svg>
                    </span>
                    <h3 class="font-medium leading-tight"><?= $step['title'] ?></h3>
                    <p class="text-sm"><?= $step['event'] ?></p>
                </li>
                <?php endforeach; ?>
            </ol>
        </div>

    </div>
<?php $this->endSection(); ?>