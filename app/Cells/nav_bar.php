<nav class="bg-gradient-to-r to-color_3 via-color_2 from-color_1 shadow-color_1/20 dark:shadow-lg dark:shadow-color_1/80 fixed w-full z-20 top-0 left-0 border-b border-gray-200 dark:border-gray-600">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="/" class="flex items-center space-x-3">
            <img loading="lazy" decoding="async" src="<?= $theme['logo'] ?>" 
            class="h-12 sm:h-16" alt="Logo">
        </a>        
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-2" id="navbar-user">
            <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 md:space-x-8 bg-transparent rtl:space-x-reverse md:flex-row md:mt-0">
                <li>
                    <a href="/checkin" class="block py-2 px-3 text-gray-300 rounded hover:bg-gray-100 hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">
                        Check In
                    </a>
                </li>
                <li>
                    <a href="/agenda" class="block py-2 px-3 text-gray-300 rounded hover:bg-gray-100 hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">
                        Agenda
                    </a>
                </li>
                <li>
                    <a href="/norma/list" class="block py-2 px-3 text-gray-300 rounded hover:bg-gray-100 hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">
                        Normas do Dojo
                    </a>
                </li>
                <li>
                    <a href="/nafudakake" class="block py-2 px-3 text-gray-300 rounded hover:bg-gray-100 hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">
                        Nafudakake
                    </a>
                </li>
                <li>
                    <a href="/financeiro" class="block py-2 px-3 text-gray-300 rounded hover:bg-gray-100 hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">
                        Financeiro
                    </a>
                </li>
                <?php if ($user['tipo'] == 'admin' || $user['tipo'] == 'professor') : ?>
                <li>
                    <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar" class="flex items-center justify-between w-full py-2 px-3 text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-white md:dark:hover:text-blue-500 dark:focus:text-white dark:hover:bg-gray-700 md:dark:hover:bg-transparent">
                        Administrativo
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                    </button>
                    <div id="dropdownNavbar" class="z-10 hidden bg-gray-50 font-normal divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownLargeButton">
                            <li>
                                <a href="/treino" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                    Treinos
                                </a>
                            </li>
                            <li>
                                <a href="/evento" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                    Eventos
                                </a>
                            </li>
                            <li>
                                <a href="/norma" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                    Normas
                                </a>
                            </li>
                            <li>
                                <a href="/tecnica" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                    Técnicas
                                </a>
                            </li>
                            <li>
                                <a href="/graduacao" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                    Graduações
                                </a>
                            </li>
                            <li>
                                <a href="/local" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                    Locais
                                </a>
                            </li>
                            <li>
                                <a href="/theme" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                    Temas
                                </a>
                            </li>
                            <li>
                                <a href="/user" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                    Usuários
                                </a>
                            </li>
                            <li aria-labelledby="dropdownNavbarLink">
                                <button id="financeiroDropdownButton" data-dropdown-toggle="financeiroDropdown" data-dropdown-placement="right-start" type="button" class="flex items-center justify-between w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    Financeiro
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                </button>
                                <div id="financeiroDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="financeiroDropdownButton">
                                    <li>
                                        <a href="/tipo_pagamento" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                            Tipos de Pagamentos
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/pagamento" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                            Pagamentos
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/gerar_pagamento" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                            Gerar Pagamento Individual
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/gerar_pagamentos" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                            Gerar Pagamentos
                                        </a>
                                    </li>
                                    </ul>
                                </div>
                            </li>
                            <li aria-labelledby="dropdownNavbarLink">
                                <button id="doubleDropdownButton" data-dropdown-toggle="doubleDropdown" data-dropdown-placement="right-start" type="button" class="flex items-center justify-between w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    Relatórios
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                </button>
                                <div id="doubleDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="doubleDropdownButton">
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                            Frequência Mensal
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                            Por Aluno
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                            Financeiro
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                            Trajetória
                                        </a>
                                    </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="flex items-center space-x-3 md:space-x-0 md:order-1">
            <button type="button" class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                <span class="sr-only">Abrir menu</span>
                <img class="w-8 h-8 rounded-full" src="<?= '/images/users/'. $user['image_path'] ?>" alt="Foto">
            </button>
            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
                <div class="px-4 py-3">
                <span class="block text-sm text-gray-900 dark:text-white"><?= $user['nome'] ?></span>
                <span class="block text-sm  text-gray-500 truncate dark:text-gray-400"><?= $user['email'] ?></span>
                </div>
                <ul class="py-2" aria-labelledby="user-menu-button">
                <li>
                    <a href="/dash" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="/configuracoes" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                        Configurações
                    </a>
                </li>
                <li>
                    <a href="/trajetoria" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                        Trajetória
                    </a>
                </li>
                <li>
                    <a href="/estatuto" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                        Estatuto do ISMP
                    </a>
                </li>
                <li>
                    <a href="/logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                        Sair
                    </a>
                </li>
                </ul>
            </div>
            <button data-collapse-toggle="navbar-user" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-user" aria-expanded="false">
                <span class="sr-only">Abrir menu Admin</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>
        </div>
    </div>
</nav>