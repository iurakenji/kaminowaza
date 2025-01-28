<?= $this->extend('layouts/main'); ?>
<?php helper('form'); ?>
<?php $this->section('content'); ?>
<div class="flex flex-col">
    <div class="w-full mt-3 mx-auto container">
        <?= form_open('treino/save' . (isset($treino) ? "/$treino[id]" : '')) ?>
        <?php if (isset($treino['id'])): ?>
            <?= form_hidden('id', $treino['id']); ?>
        <?php endif; ?>
            <div class="flex flex-col">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="dia">Dia</label>
                <?= form_dropdown('dia', 
                ['' => 'Selecione...'] + WEEKDAYS, isset($treino) ? $treino['dia'] : '', ['required' => 'required', 'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500']); ?>
            </div>
            <div class="flex flex-col mt-3">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="inicio">Início</label>
                <?= form_dropdown('inicio', ['' => 'Selecione...'] + HORARIOS, isset($treino) ? $treino['inicio'] : '', ['required' => 'required', 'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500']); ?>
            </div>
            <div class="flex flex-col mt-3">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="termino">Término</label>
                <?= form_dropdown('termino', ['' => 'Selecione...'] + HORARIOS, isset($treino) ? $treino['termino'] : '', ['required' => 'required', 'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500']); ?>
            </div>
            <div class="flex flex-col mt-3">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="professor">Professor</label>
                <?= form_dropdown('professor_id',['' => 'Selecione...'] + $professores, isset($treino) ? $treino['professor_id'] : '', ['required' => 'required', 'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500']); ?>
            </div>
            <div class="flex flex-col mt-3">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="local_id">Local</label>
                <?= form_dropdown('local_id',['' => 'Selecione...'] + $locais, isset($treino) ? $treino['local_id'] : '', ['required' => 'required', 'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500']); ?>
            </div>
            <div class="flex flex-col mt-3">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="inicio_vigencia">Início Vigência</label>
                <?= form_input('inicio_vigencia', isset($treino) ? date('Y-m-d', strtotime($treino['inicio_vigencia'])) : '', ['required' => 'required', 'type' => 'date', 'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'], 'date'); ?>
            </div>
            <div class="flex flex-col mt-3">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="fim_vigencia">Término Vigência</label>
                <?= form_input('fim_vigencia', isset($treino) ? date('Y-m-d', strtotime($treino['fim_vigencia'])) : '', ['required' => 'required', 'type' => 'date', 'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'], 'date'); ?>
            </div>
            <div class="flex flex-col">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="data">Observações</label>
                <?= form_textarea('observacao', isset($treino) && $treino['observacao'] ? $treino['observacao'] : '', ['class' => 'block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500']); ?>
            </div>
            <div class="flex justify-end mt-3">
                <?= form_submit('submit', 'Salvar', ['class' => 'text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 shadow-lg shadow-teal-500/50 dark:shadow-lg dark:shadow-teal-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2']); ?>
            </div>
        </form>
    </div>
</div>
<?php $this->endSection(); ?>