<?= $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>
<div class="flex flex-col">
    <div class="flex flex-col justify-end mx-4">
        <div class="flex items-start mb-4">
            <input id="showArchived" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            <label for="showArchived" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Mostrar Não Vigentes</label>
        </div>        
        <div class="flex justify-end">
            <a href="/treino/create" class="text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 shadow-lg shadow-teal-500/50 dark:shadow-lg dark:shadow-teal-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Criar Novo Treino</a>
        </div>
    </div>
    <div class="w-auto mx-4">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Dia</th>
                    <th scope="col" class="px-6 py-3 text-center">Início</th>
                    <th scope="col" class="px-6 py-3 text-center">Término</th>
                    <th scope="col" class="px-6 py-3 text-center">Professor</th>
                    <th scope="col" class="px-6 py-3 text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($treinos as $treino) : ?>
                    <tr class="<?= date('Y-m-d', strtotime($treino['fim_vigencia'])) < date('Y-m-d') ? 'hidden' : '' ?>">
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"><?= WEEKDAYS[$treino['dia']] ?></td>
                        <td class="px-6 py-4 text-center"><?= date('H:i', strtotime($treino['inicio'])) ?></td>
                        <td class="px-6 py-4 text-center"><?= date('H:i', strtotime($treino['termino'])) ?></td>
                        <td class="px-6 py-4 text-center"><?= $professores[$treino['professor_id']] ?></td>
                        <td class="px-6 py-4 text-center">
                            <a class="me-2 text-blue-900 hover:text-blue-600" href="/treino/edit/<?= $treino['id'] ?>">Editar</a> | 
                            <a class="me-2 text-red-900 hover:text-red-600" href="/treino/delete/<?= $treino['id'] ?>">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.getElementById('showArchived').addEventListener('change', function() {
        const treinos = document.querySelectorAll('tbody tr');
        const currentDate = new Date().toISOString().split('T')[0];
        treinos.forEach(treino => {
            const fimVigencia = treino.querySelector('td:nth-child(3)');
            if (fimVigencia) {
                const isVigente = fimVigencia.textContent >= currentDate;
                if (this.checked) {
                    treino.classList.remove('hidden');
                } else {
                    if (!isVigente) {
                        treino.classList.add('hidden');
                    }
                }
            }
        });
    });
</script>
<?php $this->endSection(); ?>
