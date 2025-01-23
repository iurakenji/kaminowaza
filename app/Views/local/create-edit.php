<?= $this->extend('layouts/main'); ?>
<?php helper('form'); ?>
<?php $this->section('content'); ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>

#map {
    height: 400px;
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 8px;
}

</style>

<div class="flex flex-col">
    <div class="w-full mx-auto container">
            <div id="map" style="height: 400px; margin-top: 20px; z-index: 0;"></div>
        <?= form_open('local/save' . (isset($local) ? "/$local[id]" : '')) ?>
        <?php if (isset($local['id'])): ?>
            <?= form_hidden('id', $local['id']); ?>
        <?php endif; ?>
            <div class="flex flex-col">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="data">Nome</label>
                <?= form_input('nome', isset($local) ? $local['nome'] : '', ['required' => 'required', 'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500']); ?>
            </div>
            <div class="flex flex-col">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="data">Latitude</label>
                <?= form_input('latitude', isset($local) && $local['latitude'] ? $local['latitude'] : '', ['class' => 'block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500']); ?>
            </div>
            <div class="flex flex-col">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="data">Latitude</label>
                <?= form_input('longitude', isset($local) && $local['longitude'] ? $local['longitude'] : '', ['class' => 'block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500']); ?>
            </div>
            <div class="flex flex-col">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="data">Raio Permitido (metros)</label>
                <?= form_input('raio_permitido', isset($local) && $local['raio_permitido'] ? $local['raio_permitido'] : '', ['required' => 'required', 'type' => 'number', 'min' => '1', 'step' => 'any', 'class' => 'block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'], 'number'); ?>
            </div>
            <div class="flex justify-end mt-3">
                <?= form_submit('submit', 'Salvar', ['class' => 'text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 shadow-lg shadow-teal-500/50 dark:shadow-lg dark:shadow-teal-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2']); ?>
            </div>
        </form>
    </div>
</div>

<script>

    const initialLat = <?= isset($local['latitude']) ? $local['latitude'] : '-27.5954'; ?>;
    const initialLng = <?= isset($local['longitude']) ? $local['longitude'] : '-48.548'; ?>;

document.addEventListener('DOMContentLoaded', () => {

    const map = L.map('map').setView([initialLat, initialLng], 18);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: 'Map data © <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
    }).addTo(map);

    let marker = L.marker([initialLat, initialLng], { draggable: true }).addTo(map);

    marker.on('dragend', function (e) {
        const latLng = marker.getLatLng();
        document.querySelector('input[name="latitude"]').value = latLng.lat;
        document.querySelector('input[name="longitude"]').value = latLng.lng;
    });

    map.on('click', function (e) {
        const { lat, lng } = e.latlng;

        marker.setLatLng(e.latlng);

        document.querySelector('input[name="latitude"]').value = lat;
        document.querySelector('input[name="longitude"]').value = lng;
    });
});
</script>


<?php $this->endSection(); ?>