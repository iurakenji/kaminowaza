<?= $this->extend('layouts/main'); ?>
<?php helper('form'); ?>
<?php $this->section('content'); ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>


<div x-data="checkinHandler()" x-init="checkCurrentLocation()">
    <div id="map" class="w-auto mx-4" style="height: 30vh; z-index: 0;"></div>
    <div x-show="locationFailure" class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Check in não disponível</span>
        <div>
            <span class="font-medium">Check in não disponível:  Localização verificada fora do alcance de qualquer evento disponível. Checkin não disponível.</span>
        </div>
    </div>
    <div x-show="verifyingLocation" class="flex items-center p-4 mb-4 text-sm text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300 dark:border-yellow-800" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Verificando localização...</span>
        <div>
            <span class="font-medium">Aguarde, verificando localização...</span>
        </div>
    </div>
    <div x-show="locationSuccess">
        <div x-show="ocorrencias.length !== 0" class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Sucesso</span>
            <div>
                <span class="font-medium">Localização verificada com sucesso! Checkin permitido para as localizações abaixo:</span>
            </div>
        </div>
        <div class="w-auto mx-4">
            <span x-show="filteredOcorrencias.length !== 0">Selecione para qual evento deseja fazer checkin:</span>
                <form action="<?= url_to('checkin/save') ?>" method="post">
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

<script>

const locais = <?= json_encode($locais); ?>;
const ocorrencias = <?= json_encode($ocorrencias); ?>;

function checkinHandler() {
    return {
        filteredOcorrencias: {},
        selectedOcorrencia: null,
        coordenadas: { latitude: null, longitude: null },
        map: null,
        locationSuccess: false,
        locationFailure: false,
        verifyingLocation: true,
        allowedLocations: {},

        checkCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        this.coordenadas.latitude = position.coords.latitude;
                        this.coordenadas.longitude = position.coords.longitude;
                        this.allowedLocations = this.getAllowedLocations();
                        this.filterOcorrencias();
                        this.locationSuccess = Object.keys(this.allowedLocations).length > 0;
                        this.locationFailure = !this.locationSuccess;
                        this.verifyingLocation = false;
                        this.initMap();   
                    },
                    (error) => {
                        console.error('Erro ao obter localização:', error);
                        this.locationSuccess = false;
                        this.locationFailure = true;
                        this.verifyingLocation = false;
                    }
                );
            } else {
                console.error('Geolocalização não suportada.');
                this.locationFailure = true;
                this.verifyingLocation = false;
            }
        },

        getAllowedLocations() {
            const locaisDisponiveis = {};
            for (const key in locais) {
                const local = locais[key];
                const distance = this.getDistance(
                    local.latitude, local.longitude,
                    this.coordenadas.latitude, this.coordenadas.longitude
                );
                if (distance <= (local.raio / 1000)) {
                    locaisDisponiveis[key] = local;
                }
            }
            return locaisDisponiveis;
        },

        filterOcorrencias() {
            this.filteredOcorrencias = ocorrencias.filter(ocorrencia => {
                return this.allowedLocations[ocorrencia.local_id];
            }).map(ocorrencia => ({ id: ocorrencia.id, titulo: ocorrencia.titulo }));
        },

        initMap() {
            if (!this.map) {
                this.map = L.map('map').setView(
                    [this.coordenadas.latitude, this.coordenadas.longitude],
                    19
                );

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                }).addTo(this.map);

                L.marker([this.coordenadas.latitude, this.coordenadas.longitude]).addTo(this.map)
                    .bindPopup('Você está aqui.')
                    .openPopup();
            } else {
                this.map.setView(
                    [this.coordenadas.latitude, this.coordenadas.longitude],
                    19
                );
            }
        },

        addUserMarker() {
            L.marker([this.coordenadas.latitude, this.coordenadas.longitude])
                .addTo(this.map)
                .bindPopup('Você está aqui.')
                .openPopup();
        },

        adjustMapToEvent() {
            const ocorrencia = ocorrencias.find(ocorrencia => ocorrencia.id === this.selectedOcorrencia);
            const selectedLocal = locais[ocorrencia.local_id];
            if (selectedLocal) {
                this.map.setView([selectedLocal.latitude, selectedLocal.longitude], 13);
                L.marker([selectedLocal.latitude, selectedLocal.longitude], { icon: L.icon({iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png', iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41]}) })
                    .addTo(this.map)
                    .bindPopup(ocorrencia.titulo)
                    .openPopup();
            }
        },

        getDistance(lat1, lon1, lat2, lon2) {
            const R = 6371;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            const distance = R * c;
            return distance;
            },
    };
}



</script>

<?php $this->endSection(); ?>