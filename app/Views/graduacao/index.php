<?= $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>
    <div class="flex justify-end mx-4">
        <a href="/graduacao/create" class="text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 shadow-lg shadow-teal-500/50 dark:shadow-lg dark:shadow-teal-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
            Nova Graduação
        </a>
    </div>
    <div class="w-auto mx-4">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 text-center">
                    <th scope="col" class="px-6 py-3 text-center">Nome</th>
                    <th scope="col" class="px-6 py-3 text-center">Cor da Faixa</th>
                    <th scope="col" class="px-6 py-3 text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($graduacoes as $graduacao) : ?>
                    <tr>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                            <svg class="w-20 h-20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 478.619 184.676" overflow="visible" enable-background="new 0 0 478.619 184.676" xml:space="preserve">
                                <g>
                                    <path fill="<?= $graduacao['cor'] ?>" stroke="#000000" stroke-width="4" d="M192.044,46.054c0,0-1.475,4.952,0.21,7.375      c1.686,2.423,24.86,1.791,24.86,1.791L205.845,45L192.044,46.054z"/>
                                    <path fill="<?= $graduacao['cor'] ?>" stroke="#000000" stroke-width="4" d="M9.831,23.198c0,0,119.181,32.087,233.779,32.087      c114.598,0,214.679-51.187,218.5-53.479c3.819-2.292,12.987,38.963,0.765,48.131c-12.225,9.168-80.983,48.896-216.208,48.896      c-135.226,0-233.015-21.392-239.892-29.032C-0.101,62.161-0.101,31.602,9.831,23.198z"/>
                                    <path fill="<?= $graduacao['cor'] ?>" stroke="#000000" stroke-width="4" d="M252.014,126.336c0,0-22.156-6.112-28.268-21.392      c-6.111-15.279,58.827-29.795,58.827-29.795l-6.112,31.324L252.014,126.336z"/>
                                    <path fill="<?= $graduacao['cor'] ?>" stroke="#000000" stroke-width="4" d="M195.479,102.652c0,0,30.56,21.392,35.143,19.1      c4.584-2.292,58.827-36.671,58.827-36.671L243.61,51.465l-50.423,38.2L195.479,102.652z"/>
                                    <path fill="<?= $graduacao['cor'] ?>" stroke="#000000" stroke-width="4" d="M22.818,152.312      c0,0,125.293-76.398,200.928-106.958c75.635-30.56,30.56,29.031,30.56,29.031s-78.69,38.199-110.778,57.299      s-81.746,50.424-87.858,51.188C49.558,183.635,22.818,152.312,22.818,152.312z"/>
                                    <path fill="<?= $graduacao['cor'] ?>" stroke="#000000" stroke-width="4" d="M255.967,27.303c0,0-5.29-1.851-14.146,8.46      c-8.857,10.312,15.07,8.197,15.07,8.197L255.967,27.303z"/>
                                    <path fill="<?= $graduacao['cor'] ?>" stroke="#000000" stroke-width="4" d="M232.15,28.546c0,0,94.734,49.659,127.586,60.355      c32.851,10.696,113.832,46.603,116.889,55.771s-27.503,30.559-27.503,30.559s-23.685-21.391-54.243-34.379      c-30.56-12.987-83.274-34.379-112.306-48.131c-29.031-13.751-89.387-47.367-89.387-47.367L232.15,28.546z"/>
                                    <path fill="<?= $graduacao['cor'] ?>" stroke="#000000" stroke-width="4" d="M255.834,27.782c0,0-2.292,92.442-4.584,97.026      c-2.293,4.584,42.783-12.987,43.546-18.335c0.765-5.349,6.877-50.423,2.293-55.007S260.417,25.49,255.834,27.782z"/>
                                </g>
                            </svg>
                        </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center"><?= $graduacao['nome'] ?> </td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center"><?= $graduacao['cor_faixa'] ?> </td>
                        <td class="px-6 py-4 text-center">
                            <a class="me-2 text-blue-900 hover:text-blue-600" href="graduacao/edit/<?= $graduacao['id'] ?>">Editar</a> | 
                            <a data-modal-target="popup-confirm" data-modal-toggle="popup-confirm" class="delete_button me-2 text-red-900 hover:text-red-600" href="/graduacao/delete/<?= $graduacao['id'] ?>">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php $this->endSection(); ?>