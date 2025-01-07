<?= $this->extend('layouts/main'); ?>
<?php helper('form'); ?>
<?php $this->section('content'); ?>
    <div class="w-auto mx-4">
        Selecione para qual evento deseja fazer checkin:
            <form action="<?= url_to('checkin/save') ?>" method="post">
                    <div class="flex flex-col mt-3">
                        <?= form_dropdown('ocorrencia_id',['' => 'Selecione...'] + $ocorrencias, isset($ocorrencias) ? $ocorrencias : '', ['required' => 'required', 'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500']); ?>
                    </div>
                    <div class="flex justify-end mx-4 mt-3">
                        <button type="submit" class="text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 shadow-lg shadow-teal-500/50 dark:shadow-lg dark:shadow-teal-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Check In</button>
                    </div>
            </form>
    </div>
<?php $this->endSection(); ?>