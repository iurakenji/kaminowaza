<?= $this->extend('layouts/main'); ?>
<?php helper('form'); ?>
<?php $this->section('content'); ?>
<div class="flex flex-col">
    <div class="w-full mt-3 mx-auto container">
        <?= form_open_multipart('user/save' . (isset($user) ? "/$user[id]" : '')) ?>
            <div class="flex flex-col">
                <label for="nome">Nome</label>
                <?= form_input('nome', isset($user) ? $user['nome'] : '', ['required' => 'required']); ?>
            </div>
            <div class="flex flex-col mt-3">
                <label for="login">Login</label>
                <?= form_input('username', isset($user) ? $user['username'] : '', ['required' => 'required']); ?>
            </div>
            <div class="flex flex-col mt-3">
                <label for="tipo">Tipo</label>
                <?= form_dropdown('tipo', [
                    '' => 'Selecione',
                    'aluno' => 'Aluno',
                    'professor' => 'Professor',
                    'admin' => 'Admin'
                ], isset($user) ? $user['tipo'] : '', ['required' => 'required']); ?>
            </div>
            <div class="flex flex-col mt-3">
                <label for="email">Email</label>
                <?= form_input('email', isset($user) ? $user['email'] : ''); ?>
            </div>
            <?php if (!isset($user)): ?>
            <div class="flex flex-col mt-3">
                <label for="senha">Senha</label>
                <?= form_password('password', '', ['required' => 'required']); ?>
            </div>
            <?php endif; ?>
            <?php if (isset($user)): ?>
            <div class="flex flex-col mt-3">
                <?=form_checkbox('active', 1, isset($user) ? $user['active'] : 1);?><label for="active" class="ml-2">Ativo</label>
            </div>
            <?php endif; ?>
            <div class="flex flex-col mt-3">
                <label for="dn">Data de Nascimento</label>
                <?= form_input('dn', isset($user) ? $user['dn'] : '', ['required' => 'required'], 'date'); ?>
            </div>
            <div class="flex flex-col mt-3">
                <label for="sexo">Sexo</label>
                <?= form_dropdown('sexo', [
                    '' => 'Selecione',
                    'M' => 'Masculino',
                    'F' => 'Feminino'
                ], isset($user) ? $user['sexo'] : '', ['required' => 'required']); ?>
            </div>
            <div class="flex flex-col mt-3">
                <label for="telefone">Telefone</label>
                <?= form_input('telefone', isset($user) ? $user['telefone'] : '', ['required' => 'required']); ?>
            </div>
            <div class="flex flex-col mt-3">
                <label for="graduacao">Graduação</label>
                <?= form_dropdown('graduacao', array_merge(['' => 'Selecione'], GRADUACOES), isset($user) ? $user['graduacao'] : '', ['required' => 'required']); ?>
            </div>
            <div class="flex flex-col mt-3">
                <label for="inicio_treinos">Início dos Treinos</label>
                <?= form_input('inicio_treinos', isset($user) ? $user['inicio_treinos'] : '', ['required' => 'required'], 'date'); ?>
            </div>
            <div class="flex flex-col">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="data">Imagem</label>
                <?= form_upload('image_path', isset($user) && $user['image_path'] ? $user['image_path'] : '', ['class' => 'block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500']); ?>
            </div>
            <div class="flex justify-end mt-3">
                <?= form_submit('submit', 'Salvar', ['class' => 'font-bold bg-stone-400 text-slate-100 p-4 rounded']); ?>
            </div>
        </form>
    </div>
</div>
<?php $this->endSection(); ?>