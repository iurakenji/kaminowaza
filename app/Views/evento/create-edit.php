<?= $this->extend('layouts/main'); ?>
<?php helper('form'); ?>
<?php $this->section('content'); ?>
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
<div class="flex flex-col">
    <div class="w-full mx-auto container">
        <?= form_open('evento/save' . (isset($evento) ? "/$evento[id]" : '')) ?>
        <?php if (isset($evento['id'])): ?>
            <?= form_hidden('id', $evento['id']); ?>
        <?php endif; ?>
            <div class="flex flex-col">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="data">Título</label>
                <?= form_input('titulo', isset($evento) ? $evento['titulo'] : '', ['required' => 'required', 'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500']); ?>
            </div>
            <div class="flex flex-col mt-3">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="inicio">Início</label>
                <?= form_input('inicio', isset($evento) ? date('Y-m-d\TH:i', strtotime($evento['inicio'])) : '', ['required' => 'required', 'type' => 'datetime-local', 'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'], 'datetime-local'); ?>
            </div>
            <div class="flex flex-col mt-3">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="termino">Término</label>
                <?= form_input('termino', isset($evento) ? date('Y-m-d\TH:i', strtotime($evento['termino'])) : '', ['required' => 'required', 'type' => 'datetime-local', 'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'], 'datetime-local'); ?>
            </div>
            <div class="flex flex-col mt-3">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="tipo">Tipo</label>
                <?= form_dropdown('tipo',['' => 'Selecione...'] + ['seminario' => 'Seminário', 'koshukai' => 'Koshukai', 'bonenkai' => 'Bonenkai', 'samu' => 'Samu', 'treino' => 'Treino', 'outro' => 'Outro'], isset($evento) ? $evento['tipo'] : '', ['required' => 'required', 'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500']); ?>
            </div>
            <div class="flex flex-col mt-3">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="local_id">Local</label>
                <?= form_dropdown('local_id',['' => 'Selecione...'] + $locais, isset($evento) ? $evento['local_id'] : '', ['required' => 'required', 'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500']); ?>
            </div>
            <div class="flex flex-col">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="data">Observações</label>
                <?= form_textarea('observacao', isset($evento) && $evento['observacao'] ? $evento['observacao'] : '', ['class' => 'block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500']); ?>
            </div>
            <div class="flex justify-end mt-3">
                <?= form_submit('submit', 'Salvar', ['class' => 'text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 shadow-lg shadow-teal-500/50 dark:shadow-lg dark:shadow-teal-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2']); ?>
            </div>
        </form>
    </div>
</div>


<?php $this->endSection(); ?>