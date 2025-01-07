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
                    <th class="text-left" style="width: 50%;">Nome</th>
                    <th style="width: 35%;">Graduação</th>
                    <th style="width: 15%;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['users'] as $user) : ?>
                    <?php if ($user['nome'] === 'admin') {continue;} ?>
                    <tr>
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