<?= $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>
<div class="flex flex-col">
    <div class="flex justify-end mx-4">
        <a href="/user/create" class="font-bold bg-stone-400 text-slate-100 p-4 rounded">Criar Novo Usuário</a>
    </div>
    <div class="w-full mx-4 mt-3">
        <table class="w-full">
            <thead>
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Imagem
                    </th>
                    <th class="text-left" style="width: 50%;">Nome</th>
                    <th style="width: 35%;">Graduação</th>
                    <th style="width: 15%;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['users'] as $user) : ?>
                    <?php if ($user['nome'] === 'admin') {continue;} ?>
                    <tr>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <img src="/images/users/<?= $user['image_path'] ?>" alt="" class="lg:w-20 lg:h-20 sm:w-8 sm:h-8 rounded-full">
                        </td>
                        <td style="width: 50%;"><?= $user['nome'] ?></td>
                        <td class="text-center" style="width: 35%;"><?= $user['graduacao'] ?></td>
                        <td class="text-center" style="width: 15%;">
                            <a href="/user/edit/<?= $user['id'] ?>">Editar</a>
                            <a href="/user/delete/<?= $user['id'] ?>">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>
<?php $this->endSection(); ?>