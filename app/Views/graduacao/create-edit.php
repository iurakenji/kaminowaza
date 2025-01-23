<?= $this->extend('layouts/main'); ?>
<?php helper('form'); ?>
<?php $this->section('content'); ?>
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
<div class="flex flex-col">
    <div class="w-full mx-auto container">
        <?= form_open_multipart('graduacao/save' . (isset($graduacao) ? "/$graduacao[id]" : ''), ['id' => 'form-graduacao']) ?>
        <?php if (isset($graduacao['id'])): ?>
            <?= form_hidden('id', $graduacao['id']); ?>
        <?php endif; ?>
        <input type="hidden" name="requisitos" id="campo-requisitos">
        <input type="hidden" name="graduacao_tecnicas" id="campo-graduacao-tecnicas">
            <div class="flex flex-col">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="data">Nome</label>
                <?= form_input('nome', isset($graduacao) ? $graduacao['nome'] : '', ['required' => 'required', 'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500']); ?>
            </div>
            <div class="flex flex-col">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="data">Nome em Japonês</label>
                <?= form_input('nome_japones', isset($graduacao) ? $graduacao['nome_japones'] : '', ['required' => 'required', 'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500']); ?>
            </div>
            <div class="flex flex-col">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="data">Cor da Faixa</label>
                <?= form_input('cor_faixa', !empty($graduacao['cor_faixa']) && $graduacao['cor_faixa'] ? $graduacao['cor_faixa'] : '', ['class' => 'block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500']); ?>
                <?= form_input("cor", isset($graduacao["cor"]) ? "{$graduacao["cor"]}" : old("cor", ''), ["class" => "form-control form-control-sm", "id" => "hex_color"], 'color'); ?>
            </div>
            <div class="flex flex-col">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="data">Taxa do Exame de Graduação</label>
                <input type="number" name="valor_exame" x-mask:dynamic="$money($input, ',')" value="<?= isset($graduacao) ? $graduacao['valor_exame'] : '' ?>" required min="0" step="any" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
            </div>
            <div class="flex justify-end mt-3">
                <?= form_submit('submit', 'Salvar', ['class' => 'text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 shadow-lg shadow-teal-500/50 dark:shadow-lg dark:shadow-teal-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2']); ?>
            </div>
        </form>
    </div>
    <div class="w-full mx-auto container">

        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-styled-tab" data-tabs-toggle="#default-styled-tab-content" data-tabs-active-classes="text-purple-600 hover:text-purple-600 dark:text-purple-500 dark:hover:text-purple-500 border-purple-600 dark:border-purple-500" data-tabs-inactive-classes="dark:border-transparent text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300" role="tablist">
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-styled-tab" data-tabs-target="#styled-profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
                        Requisitos
                    </button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="dashboard-styled-tab" data-tabs-target="#styled-dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="false">
                        Técnicas Avaliadas
                    </button>
                </li>
            </ul>
        </div>
        <div id="default-styled-tab-content">

            <div x-data="requisitoHandler()" class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-profile" role="tabpanel" aria-labelledby="profile-tab">
                <button type="button" @click="requisitosShow = true"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Adicionar Requisito
                </button>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Tipo</th>
                                <th scope="col" class="px-6 py-3 text-center">Valor</th>
                                <th scope="col" class="px-6 py-3 text-center">Quantidade / Unidade</th>
                                <th scope="col" class="px-6 py-3 text-center">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(requisito, index) in requisitos" :key="index">
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td x-text="tipos_requisitos[requisito.tipo]" class="px-6 py-4"></td>
                                    <td x-text="requisito.valor_minimo || 'N/A'" class="px-6 py-4 text-center"></td>
                                    <td x-text="(requisito.valor_unidade || 'N/A') + ' ' + ( requisito.unidade || 'N/A')" class="px-6 py-4 text-center"></td>
                                    <td class="px-6 py-4 text-center">
                                        <button x-on:click="removeRequisito(index)" class="font-medium text-red-600 dark:text-red-500 hover:underline ml-2">Remover</button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>

                    <div @click.away="requisitosShow = false" x-show="requisitosShow" id="novoRequisitoModal" tabindex="-1" 
                        class="fixed top-50 left-50 right-50 z-50 items-center justify-center w-auto p-4 overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative w-full max-w-2xl max-h-full">
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Novo Requisito</h3>
                                    <button @click="requisitosShow = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                        <span class="sr-only">Fechar modal</span>
                                    </button>
                                </div>
                                <div class="p-6 space-y-6">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="tipo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo</label>
                                            <select x-model="tipo" name="tipo" id="tipo" 
                                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                <option value="">Selecione</option>
                                                <option value="aulas_total">Total de aulas</option>
                                                <option value="tempo_total">Tempo total</option>
                                                <option value="aulas_grad">Aulas desde a última graduação</option>
                                                <option value="aulas_tempo">Aulas em um período</option>
                                                <option value="idade">Idade</option>
                                            </select>
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="valor_minimo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Quantidade Necessária</label>
                                            <input x-model="valor_minimo" type="number" name="valor_minimo" id="valor_minimo" 
                                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500">
                                        </div>
                                        <div x-show="tipo == 'aulas_tempo'" class="col-span-6 sm:col-span-3">
                                            <label for="valor_minimo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Quantidade / Unidade</label>
                                            <input x-model="valor_unidade" type="number" name="valor_unidadeo" id="valor_unidade" 
                                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500">
                                        </div>
                                        <div x-show="tipo == 'aulas_tempo'" class="col-span-6 sm:col-span-3">
                                            <label for="tipo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unidade</label>
                                            <select x-model="unidade" name="unidade" id="unidade" 
                                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                <option value="">Selecione</option>
                                                <option value="dia">Dias</option>
                                                <option value="mes">Meses</option>
                                                <option value="ano">Anos</option>
                                                <option value="treino">Treinos</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center p-6 space-x-3 border-t border-gray-200 rounded-b dark:border-gray-600">
                                    <button @click="addRequisito" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5">
                                        Adicionar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-dashboard" role="tabpanel" aria-labelledby="dashboard-tab">

                    <div x-data="tecnicaHandler()" class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <div class="flex items-center justify-between flex-column md:flex-row flex-wrap space-y-4 md:space-y-0 py-4 bg-white dark:bg-gray-900">
                            <label for="table-search" class="sr-only">Procurar</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input 
                                    @input="searchTecnicas($event.target.value)" 
                                    x-model="searchValue" 
                                    type="text" 
                                    id="table-search-users" 
                                    class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                    placeholder="Localizar">
                            </div>
                        </div>
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="p-4">
                                        <div class="flex items-center">
                                            <label for="checkbox-all-search" class="sr-only">Avaliado</label>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nome
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(tecnica, index) in tecnicas" :key="index">
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="w-4 p-4">
                                            <div class="flex items-center">
                                            <input 
                                                @change="addTecnica(tecnica.id)" 
                                                :checked="isChecked(tecnica.id)" 
                                                type="checkbox" 
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                            />
                                                <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                            </div>
                                        </td>
                                        <td class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                            <div x-text="tecnica.nome" class="font-semibold"></div>
                                        </td>
                                    </tr>      
                                </template>
                            </tbody>
                        </table>
                    </div>



            </div>
        </div>


    </div>

</div>


<script>
    let requisitos = <?= json_encode(isset($requisitos) ? $requisitos : []); ?>;
    const campoRequisitos = document.getElementById('campo-requisitos');
    const campoGraduacaoTecnicas = document.getElementById('campo-graduacao-tecnicas');
    const tipos_requisitos = <?= json_encode($tipos_requisitos); ?>;
    const tecnicas = <?= json_encode(isset($tecnicas ) ? $tecnicas : [] ); ?>;
    let graduacaoTecnicas = <?= json_encode(isset($graduacao_tecnicas) ? $graduacao_tecnicas : []); ?>;

    campoRequisitos.value = JSON.stringify(requisitos);
    campoGraduacaoTecnicas.value = JSON.stringify(graduacaoTecnicas);
    
    function requisitoHandler() {
        return {
            requisitos: requisitos || [],
            tipo: '',
            valor_minimo: '',
            valor_unidade: '',
            unidade: '',
            tecnicas: [],
            requisitosShow: false,

            addRequisito() {
                if (!this.tipo || !this.valor_minimo) {
                    alert('Preencha os campos obrigatórios!');
                    return;
                }

                const novoRequisito = {
                    tipo: this.tipo,
                    valor_minimo: this.valor_minimo,
                    valor_unidade: this.valor_unidade || null,
                    unidade: this.unidade || null,
                };

                this.requisitos.push(novoRequisito);

                this.tipo = '';
                this.valor_minimo = '';
                this.valor_unidade = '';
                this.unidade = '';

                campoRequisitos.value = JSON.stringify(this.requisitos);
            },

            removeRequisito(index) {
                this.requisitos.splice(index, 1);
                campoRequisitos.value = JSON.stringify(this.requisitos);
            },
        };
    }
    
    function tecnicaHandler() {
        return {
            tecnicas: tecnicas || [],
            originalTecnicas: tecnicas ? [...tecnicas] : [],
            searchValue: '',
            graduacaoTecnicas: graduacaoTecnicas || [],

            addTecnica(index) {
                if (!this.graduacaoTecnicas.includes(index)) {
                    this.graduacaoTecnicas.push(index);
                } else {
                    this.graduacaoTecnicas = this.graduacaoTecnicas.filter(i => i !== index);
                }
                campoGraduacaoTecnicas.value = JSON.stringify(this.graduacaoTecnicas);
            },

            isChecked(index) {
                return this.graduacaoTecnicas.includes(index);
            },

            searchTecnicas(value) {
                if (value.trim() === '') {
                    this.tecnicas = [...tecnicas];
                } else {
                    this.tecnicas = tecnicas.filter(tecnica =>
                        tecnica.nome.toLowerCase().includes(value.toLowerCase())
                    );
                }
            },
        };
    }




</script>




<?php $this->endSection(); ?>