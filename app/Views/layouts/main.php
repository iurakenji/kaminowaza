<?php
    $theme = \Config\Services::theme()->getTheme();
?>
<style>
    <?= $theme['theme_css']; ?>
</style>
<!doctype html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="X-CSRF-TOKEN" content="<?= csrf_hash() ?>">
        <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <title><?= $this->renderSection('title') ?></title>
        <link href="<?=base_url()?>css/output.css?v=1.0" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="shortcut icon" href="<?= base_url( 'images/themes/'.$theme['icon']) ?>" type="image/x-icon">
        <link href="https://fonts.googleapis.com/css2?family=RocknRoll+One&family=Shippori+Mincho+B1&display=swap" rel="stylesheet">
        <link href="<?=base_url()?>css/extra-styles.css" rel="stylesheet">
        <title>Kaminowaza Dojo</title>
    </head>

    <body class="bg-gray-400 rocknroll-one-regular w-screen min-h-screen flex flex-col">
        <header class="p-4 w-full bg-gray-200">
            <?= view_cell('NavBarCell') ?>
        </header>

        <main class="flex-grow mt-16" x-data="alerts()" x-on:show-alert.window="addAlert($event.detail.type, $event.detail.message)">

            <template x-for="(alert, index) in alerts" :key="index">
                <div x-show="alert.visible" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform translate-y-4" class="flex items-center p-4 mb-4" :class="{
                    'text-red-800 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800': alert.type === 'error',
                    'text-green-800 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800': alert.type === 'success',
                    'text-yellow-800 border-yellow-300 bg-yellow-50 dark:text-yellow-400 dark:bg-gray-800 dark:border-yellow-800': alert.type === 'info'
                }" role="alert">
                    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path x-show="alert.type === 'error'" d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        <path x-show="alert.type === 'success'" d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                        <path x-show="alert.type === 'info'" d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <div class="ms-3 text-sm font-medium" x-text="alert.message"></div>
                    <button type="button" @click="closeAlert(index)" class="ms-auto -mx-1.5 -my-1.5 rounded-lg focus:ring-2 p-1.5 inline-flex items-center justify-center h-8 w-8" :class="{
                        'bg-red-50 text-red-500 hover:bg-red-200 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700': alert.type === 'error',
                        'bg-green-50 text-green-500 hover:bg-green-200 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700': alert.type === 'success',
                        'bg-yellow-50 text-yellow-500 hover:bg-yellow-200 dark:bg-gray-800 dark:text-yellow-400 dark:hover:bg-gray-700': alert.type === 'info'
                    }" aria-label="Close">
                        <span class="sr-only">Fechar</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
            </template>

            <div x-data="{ isOpen: false, href: '', message: '' }" x-on:open-confirm-modal.window="isOpen = true; href = $event.detail.href; message = $event.detail.message">
                <div x-show="isOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                        <div class="text-center">
                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">ATENÇÃO!</h3>
                            <p class="mb-5 text-gray-500 dark:text-gray-400" x-text="message"></p>
                            <button @click="window.location.href = href; isOpen = false" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5">
                                Confirmar
                            </button>
                            <button @click="isOpen = false" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                Cancelar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="h-auto">
                <h1 class="mx-10 mt-2 mb-4 pb-3 text-4xl leading-none tracking-tight border-b-2 border-gray-400 text-font_color md:text-3xl lg:text-3xl"><?=isset($title) ? $title : ''?></h1>
                <div class="flex flex-col">
                    <?= $this->renderSection('content') ?>
                </div>
            </div>
        </main>

        <footer class="px-1 bg-gradient-to-r to-color_3 via-color_2 from-color_1 shadow-color_1/20 dark:shadow-lg dark:shadow-color_1/80 border-t border-gray-200 text-xs text-gray-200 dark:text-gray-400 text-center">
            <?php if (ENVIRONMENT === 'development') : ?>
                <div class="bg-stone-700 text-red-500 p-2">
                    <p>Página renderizada em {elapsed_time} segundos usando {memory_usage} MB de memória. - Ambiente: <?= ENVIRONMENT ?></p>
                </div>
            <?php endif; ?>    
            <div class="py-3">© <?= date('Y') ?> Desenvolvido Por Kendji Iura, em prol do Instituto Sérgio Murilo Pereira e Kaminowaza Dojo - Logado como: <strong><?= \Config\Services::auth()->user()['username'] ?></strong>. Todos os direitos reservados.</div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
        <script src="<?= base_url('js/main-page-scripts.js') ?>"></script>
        <script src="<?= base_url('js/global.js') ?>"></script>

        <?= $this->renderSection('scripts') ?>
    </body>
</html>

        <script>
            function alerts() {
                return {
                    alerts: [
                        <?php if (session()->has('errors')): ?>
                            <?php foreach (session('errors') as $error): ?>
                                { type: 'error', message: '<?= $error ?>', visible: true },
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <?php if (session()->has('success')): ?>
                            { type: 'success', message: '<?= session('success') ?>', visible: true },
                        <?php endif; ?>
                    ],
                    addAlert(type, message) {
                        this.alerts.push({ type, message, visible: true });
                        setTimeout(() => {
                            this.closeAlert(this.alerts.length - 1);
                        }, 5000);
                    },
                    closeAlert(index) {
                        this.alerts[index].visible = false;
                    },
                    init() {
                        // Fecha os alerts automaticamente após 5 segundos
                        this.alerts.forEach((alert, index) => {
                            setTimeout(() => {
                                this.closeAlert(index);
                            }, 5000);
                        });
                    }
                };
            }
        </script>
    </body>
</html>