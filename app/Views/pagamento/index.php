<?= $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>
    <div class="flex justify-end mx-4">
        <a href="/pagamento/create" class="text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 shadow-lg shadow-teal-500/50 dark:shadow-lg dark:shadow-teal-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
            Novo Pagamento
        </a>
    </div>
    <div class="w-auto mx-4">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Nome</th>
                    <th scope="col" class="px-6 py-3">Tipo</th>
                    <th scope="col" class="px-6 py-3 text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pagamentos as $pagamento) : ?>
                    <tr>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"><?= $pagamento['nome'] ?> </td>
                        <td class="px-6 py-4"><?= $tipos_pagamentos[$pagamento['tipo_pagamento_id']] ?></td>
                        <td class="px-6 py-4 text-center">
                            <a class="me-2 text-blue-900 hover:text-blue-600" href="pagamento/edit/<?= $pagamento['id'] ?>">Editar</a> | 
                            <a data-modal-target="popup-confirm" data-modal-toggle="popup-confirm" class="delete_button me-2 text-red-900 hover:text-red-600" href="/pagamento/delete/<?= $pagamento['id'] ?>">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php $this->endSection(); ?>