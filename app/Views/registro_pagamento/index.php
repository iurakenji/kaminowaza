<?= $this->extend('layouts/main'); ?>
<?php helper('form'); ?>
<?php $this->section('content'); ?>
<div class="my-8 mx-8">
    <div class="w-auto mx-4">
        <?= form_open('registro_pagamento/index', ['method' => 'GET']) ?>
        <h2>Selecione o pagamento a ser registrado</h2>
            <div class="flex items-center">
                <input type="radio" name="status" value="aberto" id="aberto" class="mr-2" <?php if (!isset($_GET['status']) || $_GET['status'] == 'aberto'): ?>checked<?php endif; ?>>
                <label for="aberto" class="text-sm font-medium text-gray-900 dark:text-gray-300">Pagamentos em Aberto</label>
            </div>
            <div class="flex items-center">
                <input type="radio" name="status" value="pago" id="pago" class="mr-2" <?php if (isset($_GET['status']) && $_GET['status'] == 'pago'): ?>checked<?php endif; ?>>
                <label for="pago" class="text-sm font-medium text-gray-900 dark:text-gray-300">Pagamentos Pagos</label>
            </div>
            <div class="flex justify-end mt-4">
                <button type="submit" class="text-white bg-blue-500 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Buscar</button>
            </div>
        <?= form_close() ?>
    </div>
</div>
<?php $this->endSection(); ?>