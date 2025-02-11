<?= $this->extend('layouts/main'); ?>
<?php helper('form'); ?>
<?php $this->section('content'); ?>
<div class="flex flex-col">
    <div class="w-full mt-3 mx-auto container">
        <?= form_open_multipart('user/save' . (isset($user) ? "/$user[id]" : '')) ?>
            <div class="flex flex-col">
                <label for="nome">Nome</label>
                <?= form_input('nome', isset($user) ? $user['nome'] : '', ['required' => 'required']); ?>
            </div>
            <div class="flex flex-col mt-3">
                <label for="login">Login</label>
                <?= form_input('username', isset($user) ? $user['username'] : '', ['required' => 'required']); ?>
            </div>
            <div class="flex flex-col mt-3">
                <label for="tipo">Tipo</label>
                <?= form_dropdown('tipo', [
                    '' => 'Selecione',
                    'aluno' => 'Aluno',
                    'professor' => 'Professor',
                    'admin' => 'Admin'
                ], isset($user) ? $user['tipo'] : '', ['required' => 'required']); ?>
            </div>
            <div class="flex flex-col mt-3">
                <label for="email">Email</label>
                <?= form_input('email', isset($user) ? $user['email'] : ''); ?>
            </div>
            <?php if (!isset($user)): ?>
            <div class="flex flex-col mt-3">
                <label for="senha">Senha</label>
                <?= form_password('password', '', ['required' => 'required']); ?>
            </div>
            <?php endif; ?>
            <?php if (isset($user)): ?>
            <div class="flex flex-col mt-3">
                <?=form_checkbox('active', 1, isset($user) ? $user['active'] : 1);?><label for="active" class="ml-2">Ativo</label>
            </div>
            <?php endif; ?>
            <div class="flex flex-col mt-3">
                <label for="dn">Data de Nascimento</label>
                <?= form_input('dn', isset($user) ? $user['dn'] : '', ['required' => 'required'], 'date'); ?>
            </div>
            <div class="flex flex-col mt-3">
                <label for="sexo">Sexo</label>
                <?= form_dropdown('sexo', [
                    '' => 'Selecione',
                    'M' => 'Masculino',
                    'F' => 'Feminino'
                ], isset($user) ? $user['sexo'] : '', ['required' => 'required']); ?>
            </div>
            <div class="flex flex-col mt-3">
                <label for="telefone">Telefone</label>
                <?= form_input('telefone', isset($user) ? $user['telefone'] : '', ['required' => 'required']); ?>
            </div>
            <div class="flex flex-col mt-3">
                <label for="graduacao">Graduação</label>
                <?= form_dropdown('graduacao', ['' => 'Selecione'] + $graduacoes, isset($user) ? $user['graduacao'] : '', ['required' => 'required']); ?>
            </div>
            <div class="flex flex-col mt-3">
                <label for="inicio_treinos">Início dos Treinos</label>
                <?= form_input('inicio_treinos', isset($user) ? $user['inicio_treinos'] : '', ['required' => 'required'], 'date'); ?>
            </div>
            <div class="flex flex-col mt-3" x-data="imageUploader">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Imagem</label>

                <div class="border-2 border-dashed p-4 text-center cursor-pointer"
                    @dragover.prevent
                    @drop.prevent="handleDrop"
                    @paste="handlePaste">
                    <p class="text-gray-500">Arraste ou cole uma imagem aqui</p>
                    <template x-if="preview">
                        <img :src="preview" class="mt-2 w-32 h-32 object-cover mx-auto rounded">
                    </template>
                </div>

                <?= form_upload('image_path', '', ['id' => 'imageUpload', 'class' => 'hidden', 'x-ref' => 'fileInput', '@change' => 'handleFile']); ?>

                <button type="button" class="mt-2 p-2 bg-gray-200 rounded text-sm" @click="$refs.fileInput.click()">Escolher Arquivo</button>
            </div>

            <div class="flex justify-end mt-3">
                <?= form_submit('submit', 'Salvar', ['class' => 'font-bold bg-stone-400 text-slate-100 p-4 rounded']); ?>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('imageUploader', () => ({
        preview: "<?= isset($user) && $user['image_path'] ? base_url('/images/users/' . $user['image_path']) : '' ?>",
        handleFile(event) {
            const file = event.target.files[0];
            this.previewImage(file);
        },
        handleDrop(event) {
            event.preventDefault();
            const file = event.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                this.previewImage(file);
                this.setFileInput(file);
            }
        },
        handlePaste(event) {
            const items = (event.clipboardData || event.originalEvent.clipboardData).items;
            for (const item of items) {
                if (item.type.startsWith('image/')) {
                    const file = item.getAsFile();
                    this.previewImage(file);
                    this.setFileInput(file);
                    break;
                }
            }
        },
        previewImage(file) {
            const reader = new FileReader();
            reader.onload = e => this.preview = e.target.result;
            reader.readAsDataURL(file);
        },
        setFileInput(file) {
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            this.$refs.fileInput.files = dataTransfer.files;
        }
    }));
});
</script>
<?php $this->endSection(); ?>