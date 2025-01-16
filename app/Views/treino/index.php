<?= $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>
<div class="flex flex-col">
    <div class="flex justify-end mx-4">
        <a href="/treino/create" class="text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 shadow-lg shadow-teal-500/50 dark:shadow-lg dark:shadow-teal-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Criar Novo Treino</a>
    </div>
    <div class="w-auto mx-4">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Dia</th>
                    <th scope="col" class="px-6 py-3 text-center">Início</th>
                    <th scope="col" class="px-6 py-3 text-center">Término</th>
                    <th scope="col" class="px-6 py-3 text-center">Professor</th>
                    <th scope="col" class="px-6 py-3 text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($treinos as $treino) : ?>
                    <tr>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"><?= WEEKDAYS[$treino['dia']] ?></td>
                        <td class="px-6 py-4 text-center"><?= date('H:i', strtotime($treino['inicio'])) ?></td>
                        <td class="px-6 py-4 text-center"><?= date('H:i', strtotime($treino['termino'])) ?></td>
                        <td class="px-6 py-4 text-center"><?= $professores[$treino['professor_id']] ?></td>
                        <td class="px-6 py-4 text-center">
                            <a class="me-2 text-blue-900 hover:text-blue-600" href="/treino/edit/<?= $treino['id'] ?>">Editar</a> | 
                            <a class="me-2 text-red-900 hover:text-red-600" href="/treino/delete/<?= $treino['id'] ?>">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>
<?php $this->endSection(); ?>