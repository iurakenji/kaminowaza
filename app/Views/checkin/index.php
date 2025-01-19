<?= $this->extend('layouts/main'); ?>
<?php helper('form'); ?>
<?php $this->section('content'); ?>
<div x-data="checkinHandler()">
    <div x-show="success" class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Sucesso</span>
        <div>
            <span class="font-medium">Localização verificada com sucesso!</span> Sua localização foi verificada e corresponde à localização do Dojo. Checkin permitido.
        </div>
    </div>
    <div class="w-auto mx-4">
        Selecione para qual evento deseja fazer checkin:
            <form action="<?= url_to('checkin/save') ?>" method="post">
                <div class="flex flex-col mt-3">
                    <select id="ocorrencia_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <?php if (empty($ocorrencias)) : ?>
                            <option value="" selected disabled>Sem eventos hoje.</option>
                        <?php else : ?>
                            <option value="" selected>Selecione...</option>
                            <?php foreach ($ocorrencias as $ocKey => $ocorrencia) : ?>
                                <option value="<?= $ocKey ?>"><?= $ocorrencia ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="flex justify-end mx-4 mt-3">
                    <button type="submit" class="text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 shadow-lg shadow-teal-500/50 dark:shadow-lg dark:shadow-teal-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Check In</button>
                </div>
            </form>
    </div>
</div>

<script>

document.addEventListener('DOMContentLoaded', () => {
    getCurrentLocationAndSend();
});

function getCurrentLocationAndSend() {
    console.log('Checando Localização...');
    if (navigator.geolocation) {
        console.log('...Geolocalização é suportada neste navegador... Prosseguindo...');
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                console.log(`Latitude: ${latitude}, Longitude: ${longitude}`);
                
                // fetch('/save-location', {
                //     method: 'POST',
                //     headers: {
                //         'Content-Type': 'application/json',
                //     },
                //     body: JSON.stringify({ latitude, longitude }),
                // }).then((response) => {
                //     console.log('Localização enviada com sucesso:', response);
                // });
            },
            (error) => {
                console.error('Erro ao obter localização:', error);
            }
        );
    } else {
        console.log('Geolocalização não é suportada neste navegador.');
    }
}

function checkinHandler() {
        return {
            requisitos: requisitos || [],
            success: true
        };
    }

</script>

<?php $this->endSection(); ?>