<?= $this->extend('layouts/main'); ?>
<?php helper('form'); ?>
<?php $this->section('content'); ?>
<button id="checkLocation">Checar Localização</button>

<script>

    const dojoLatitude = <?= $location[0] ?: '0'  ?>;
    const dojoLongitude = <?= $location[1] ?: '0'  ?>;

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('checkLocation').addEventListener('click', getCurrentLocationAndSend);
    //getCurrentLocationAndSend();
});

function getCurrentLocationAndSend() {
    console.log('Checando Localização...');
    if (navigator.geolocation) {
        console.log('...Geolocalização é suportada neste navegador... Prosseguindo...');
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                console.log('Coordenadas capturadas:');
                console.log(`Latitude: ${latitude}, Longitude: ${longitude}`);

                const alunoLatitude = position.coords.latitude;
                const alunoLongitude = position.coords.longitude;

                const distancia = getDistance(dojoLatitude, dojoLongitude, alunoLatitude, alunoLongitude);

                if (distancia <= 0.5) {
                    console.log('Aluno está no dojo. Check-in permitido.');
                    fetch('<?= url_to('checkin/save') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ latitude, longitude }),
                    }).then((response) => {
                        console.log('Localização enviada com sucesso:', response);
                    });
                } else {
                    console.log('Aluno não está no dojo. Check-in não permitido.');
                    alert('Não foi possível fazer login, a sua localização não corresponde ao dojo.');
                }
            },
            (error) => {
                console.error('Erro ao obter localização:', error);
            }
        );
    } else {
        console.log('Geolocalização não é suportada neste navegador.');
    }
}

function getDistance(lat1, lon1, lat2, lon2) {
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
}

</script>

<?php $this->endSection(); ?>