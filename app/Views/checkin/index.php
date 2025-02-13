<?= $this->extend('layouts/main');
    helper('form');
    helper('html');
    $this->section('content'); 
?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    window.locais = <?= json_encode($locais); ?>;
    window.ocorrencias = <?= json_encode($ocorrencias); ?>;
    window.checkins = <?= json_encode($checkins); ?>;
    window.url_to = <?= url_to('checkin/save') ?>;
</script>

<div x-data="checkinHandler()" x-init="checkCurrentLocation(); checkEmptyEvents()">
    <div id="map" class="w-auto mx-4" style="height: 30vh; z-index: 0;"></div>
    <div x-show="verifyingLocation" class="flex items-center p-4 mb-4 text-sm text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300 dark:border-yellow-800" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Verificando localização...</span>
        <div>
            <span class="font-medium">Aguarde, verificando localização...</span>
        </div>
    </div>
    <div>
        <div class="w-auto mx-4">
            <span x-show="filteredOcorrencias.length !== 0">Selecione para qual evento deseja fazer checkin:</span>
            <form action="<?= url_to('checkin/save') ?>" method="post" @submit.prevent="handleCheckin">
                <input type="hidden" name="latitude" :value="coordenadas.latitude">
                <input type="hidden" name="longitude" :value="coordenadas.longitude">
                <div class="flex flex-col mt-3">
                    <select x-model="selectedOcorrencia" @change="adjustMapToEvent()" name="ocorrencia_id" id="ocorrencia_id" required :disabled="filteredOcorrencias.length === 0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">Selecione...</option>
                        <template x-for="(ocorrencia, index) in filteredOcorrencias" :key="index">
                            <option :value="ocorrencia.id" x-text="ocorrencia.titulo"></option>
                        </template>
                        <option x-show="filteredOcorrencias.length === 0" value="">Sem eventos disponíveis</option>
                    </select>
                </div>
                <div x-show="filteredOcorrencias.length !== 0" class="flex justify-end mx-4 mt-3">
                    <button type="submit" class="text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 shadow-lg shadow-teal-500/50 dark:shadow-lg dark:shadow-teal-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Check In</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= script_tag('js/checkin.js') ?>

<?php $this->endSection(); ?>