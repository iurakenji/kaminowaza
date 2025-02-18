document.addEventListener('alpine:init', () => {
    Alpine.data('checkinHandler', () => ({
        validado: true,
        locais: window.locais || [],
        ocorrencias: window.ocorrencias || [],
        checkins: window.checkins || [],
        filteredOcorrencias: [],
        selectedOcorrencia: null,
        coordenadas: { latitude: null, longitude: null },
        map: null,
        userMarker: null,
        verifyingLocation: true,

        init() {
            this.filteredOcorrencias = this.ocorrencias;
            this.checkCurrentLocation();
            this.checkEmptyEvents();
        },

        checkCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        this.coordenadas.latitude = position.coords.latitude;
                        this.coordenadas.longitude = position.coords.longitude;
                        this.verifyingLocation = false;
                        this.initMap();
                        this.updateMarkers();
                    },
                    (error) => {
                        console.error('Erro ao obter localização:', error);
                        this.verifyingLocation = false;
                        this.initMap();
                    }
                );
            } else {
                console.error('Geolocalização não suportada.');
                this.verifyingLocation = false;
                this.initMap();
            }
        },

        checkEmptyEvents() {
            if (!this.filteredOcorrencias || this.filteredOcorrencias.length === 0) {
                this.$dispatch('show-alert', {
                    type: 'info',
                    message: 'Sem eventos disponíveis hoje.'
                });
            }
        },

        handleCheckin() {
            if (!this.selectedOcorrencia) {
                this.$dispatch('show-alert', {
                    type: 'error',
                    message: 'Selecione um evento antes de tentar fazer check-in.'
                });
                return;
            }

            const ocorrencia = this.ocorrencias.find(o => o.id == this.selectedOcorrencia);
            const local = this.locais[ocorrencia.local_id];

            if (!local) {
                this.$dispatch('show-alert', {
                    type: 'error',
                    message: 'Local não encontrado.'
                });
                return;
            }

            const distance = this.getDistance(
                local.latitude, local.longitude,
                this.coordenadas.latitude, this.coordenadas.longitude
            );

            if (distance <= local.raio) {
                this.$el.submit();
            } else {
                this.validado = false;
                this.$dispatch('open-confirm-modal', {
                    message: 'A sua localização não pode ser validada como estando dentro do máximo permitido para check-in. Sua presença será confirmada pelo Sensei responsável posteriormente. Deseja continuar?',
                    onConfirm: () => this.$el.submit()
                });
            }
        },

        initMap() {
            if (!this.map) {
                this.map = L.map('map').setView(
                    [this.coordenadas.latitude || -14.235, this.coordenadas.longitude || -51.925],
                    10
                );

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                }).addTo(this.map);
            }

            if (this.coordenadas.latitude && this.coordenadas.longitude) {
                this.addUserMarker();
            }
        },

        addUserMarker() {
            if (this.userMarker) {
                this.map.removeLayer(this.userMarker);
            }

            this.userMarker = L.marker(
                [this.coordenadas.latitude, this.coordenadas.longitude],
                { icon: L.icon({ iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-blue.png', iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41] }) }
            ).addTo(this.map)
                .bindPopup('Você está aqui.')
                .openPopup();
        },

        updateMarkers() {
            this.map.eachLayer(layer => {
                if (layer instanceof L.Marker && layer !== this.userMarker) {
                    this.map.removeLayer(layer);
                }
            });
        
            for (const ocorrencia of this.ocorrencias) {
                const local = this.locais[ocorrencia.local_id];
        
                if (local) {
                    const distance = this.getDistance(
                        local.latitude, 
                        local.longitude, 
                        this.coordenadas.latitude, 
                        this.coordenadas.longitude
                    );
        
                    const isCheckedIn = this.checkins.includes(ocorrencia.id);
        
                    let baseColor = isCheckedIn ? 'gold' : ((distance <= local.raio) ? 'green' : 'red');
        
                    const marker = L.marker(
                        [local.latitude, local.longitude],
                        {
                            icon: L.icon({
                                iconUrl: `https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-${baseColor}.png`,
                                iconSize: [25, 41],
                                iconAnchor: [12, 41],
                                popupAnchor: [1, -34],
                                shadowSize: [41, 41],
                            }),
                        }
                    );
        
                    const popupText = isCheckedIn 
                        ? `<b>${ocorrencia.titulo}</b> - Checkin já realizado`
                        : `<b>${ocorrencia.titulo}</b> - Distância: ${Math.round(distance * 10) / 10} metros`;
        
                    marker.bindPopup(popupText);
        
                    marker.on('click', () => {
                        if(isCheckedIn) {
                            this.$dispatch('show-alert', {
                                type: 'info',
                                message: 'Checkin já realizado para este evento.'
                            });
                            return;
                        }
        
                        this.selectedOcorrencia = ocorrencia.id;
        
                        marker.setIcon(L.icon({
                            iconUrl: `https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-yellow.png`,
                            iconSize: [25, 41],
                            iconAnchor: [12, 41],
                            popupAnchor: [1, -34],
                            shadowSize: [41, 41],
                        }));
        
                        this.map.eachLayer(layer => {
                            if (layer instanceof L.Marker && layer !== marker && layer !== this.userMarker) {
                                const resetColor = this.checkins.includes(ocorrencia.id)
                                    ? 'yellow'
                                    : ((distance <= local.raio) ? 'green' : 'red');
                                layer.setIcon(L.icon({
                                    iconUrl: `https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-${resetColor}.png`,
                                    iconSize: [25, 41],
                                    iconAnchor: [12, 41],
                                    popupAnchor: [1, -34],
                                    shadowSize: [41, 41],
                                }));
                            }
                        });
                    });
        
                    marker.addTo(this.map);
                } else {
                    console.warn(`Local com id ${ocorrencia.local_id} não encontrado para a ocorrência ${ocorrencia.nome}`);
                }
            }
        },        

        adjustMapToEvent() {
            if (!this.selectedOcorrencia) return;

            const eventoSelecionado = this.ocorrencias.find((e) => e.id == this.selectedOcorrencia);
            const local = this.locais[eventoSelecionado.local_id];

            if (local) {
                this.map.setView([local.latitude, local.longitude], 15);

                L.marker([local.latitude, local.longitude]).addTo(this.map)
                    .bindPopup(`<b>${eventoSelecionado.nome}</b>`)
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
            return distance * 1000;
        },
    }));
});