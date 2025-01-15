<?php

    use App\Services\AuthService;

    $theme = \Config\Services::theme()->getTheme();

?>
<!doctype html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <title><?= $this->renderSection('title') ?></title>
        <link href="<?=base_url()?>css/output.css?v=1.0" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="shortcut icon" href="<?=$theme['icon']?>" type="image/x-icon">
        <link href="https://fonts.googleapis.com/css2?family=RocknRoll+One&family=Shippori+Mincho+B1&display=swap" rel="stylesheet">
        <link href="<?=base_url()?>css/extra-styles.css" rel="stylesheet">
        <title>Kaminowaza Dojo</title>
    </head>

    <body class="bg-gray-100 rocknroll-one-regular w-screen min-h-screen flex flex-col">
        <header class="p-4 w-full bg-gray-200">
            <?= view_cell('NavBarCell') ?>
        </header>

        <main class="flex-grow mt-16">
            <?php if (session()->has('errors')): ?>
                <?php foreach (session('errors') as $error): ?>
                    <div id="alert-border-2" class="flex items-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800" role="alert">
                        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <div class="ms-3 text-sm font-medium">
                            <?= $error ?>
                        </div>
                        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"  data-dismiss-target="#alert-border-2" aria-label="Close">
                            <span class="sr-only">Fechar</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                        </button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (session()->has('success')): ?>
                    <div id="alert-border-3" class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800" role="alert">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                        </svg>
                        <div class="ms-3 text-sm font-medium">
                            <?= session('success') ?>
                        </div>
                        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"  data-dismiss-target="#alert-border-2" aria-label="Close">
                        <span class="sr-only">Fechar</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        </button>
                    </div>
            <?php endif; ?>

            <div id="popup-confirm" data-modal-target="popup-confirm" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-confirm">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <div class="p-4 md:p-5 text-center">
                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>ATENÇÃO!
                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Esta ação não poderá ser desfeita. Deseja mesmo prosseguir?</h3>
                            <button data-modal-hide="popup-confirm" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                Confirmar
                            </button>
                            <button data-modal-hide="popup-confirm" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php if (session()->has('conflitos')) : ?>
            <?php $conflitos = session('conflitos'); ?>
            <div id="static-modal" tabindex="-1" class="flex fixed inset-0 z-50 items-center justify-center w-full h-full bg-black bg-opacity-50">
                <div class="bg-white rounded-lg relative w-full max-h-full max-w-4xl shadow dark:bg-gray-800">
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Data
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Ocorrência Inserida
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Ocorrência em Conflito
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Ocorrência a ser mantida
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($conflitos as $conflito) : ?>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <?=$conflito['data']?>
                                </th>
                                <td class="px-6 py-4">
                                    <?=$conflito['inserida']?>
                                </td>
                                <td class="px-6 py-4">
                                    <?=$conflito['conflito']?>
                                </td>
                                <td class="px-6 py-4">
                                    <?=$conflito['inserida']?> | <?=$conflito['conflito']?> | Ambos
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                        <button type="button" class="hidden mt-4 text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Fechar
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?>

            <div class="h-auto">
                <h1 class="mx-10 mt-2 mb-4 pb-3 text-4xl leading-none tracking-tight border-b-2 border-gray-400 text-gray-900 md:text-3xl lg:text-3xl dark:text-white"><?=isset($title) ? $title : ''?></h1>
                <div class="flex flex-col">
                    <?= $this->renderSection('content') ?>
                </div>
            </div>   

    </main>

    <footer class="px-1 bg-gradient-to-r to-teal-400 via-teal-700 from-teal-800 shadow-teal-600/20 dark:shadow-lg dark:shadow-teal-800/80 border-t border-gray-200 text-xs text-gray-200 dark:text-gray-400 text-center">
        <?php if (ENVIRONMENT === 'development') : ?>
            <div class="bg-stone-700 text-red-500 p-2">
                <p>Página renderizada em {elapsed_time} segundos usando {memory_usage} MB de memória. - Ambiente: <?= ENVIRONMENT ?></p>
            </div>
        <?php endif; ?>    
        <div>© <?= date('Y') ?> Kaminowaza Dojo - Logado como: <strong><?= \Config\Services::auth()->user()['username'] ?></strong>. Todos os direitos reservados.</div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

    <script src="<?= base_url('js/main-page-scripts.js') ?>"></script>
    <script src="<?= base_url('js/global.js') ?>"></script>

    <script>
        <?php if (empty($conflitos)) : ?>                
            staticModal.classList.remove('hidden');
        <?php endif; ?>
    </script>

    <?= $this->renderSection('scripts') ?>
    </body>
</html>
