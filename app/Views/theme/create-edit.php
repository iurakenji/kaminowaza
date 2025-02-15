<?= $this->extend('layouts/main'); ?>
<?php helper('form'); ?>
<?php $this->section('content'); ?>
<div class="flex flex-col">
    <div class="w-full mt-3 mx-auto container">
        <?= form_open_multipart('theme/save' . (isset($theme) ? "/$theme[id]" : '')) ?>
        <?php if (isset($theme['id'])): ?>
            <?= form_hidden('id', $theme['id']); ?>
        <?php endif; ?>
            <div class="flex flex-col">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="data">Nome</label>
                <?= form_input('name', isset($theme) && $theme['name'] ? $theme['name'] : '', ['class' => 'block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500']); ?>
            </div>
            <div class="flex flex-col">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="color_1">Cor 1</label>
                <?= form_input("color_1", isset($theme["color_1"]) ? "{$theme["color_1"]}" : old("color_1", ''), ["class" => "form-control form-control-sm", "id" => "color_1"], 'color'); ?>
            </div>
            <div class="flex flex-col">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="color_2">Cor 2</label>
                <?= form_input("color_2", isset($theme["color_2"]) ? "{$theme["color_2"]}" : old("color_2", ''), ["class" => "form-control form-control-sm", "id" => "color_2"], 'color'); ?>
            </div>
            <div class="flex flex-col">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="color_3">Cor 3</label>
                <?= form_input("color_3", isset($theme["color_3"]) ? "{$theme["color_3"]}" : old("color_3", ''), ["class" => "form-control form-control-sm", "id" => "color_3"], 'color'); ?>
            </div>
            <div class="flex flex-col">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="background_color">Cor de Fundo</label>
                <?= form_input("background_color", isset($theme["background_color"]) ? "{$theme["background_color"]}" : old("background_color", ''), ["class" => "form-control form-control-sm", "id" => "background_color"], 'color'); ?>
            </div>
            <div class="flex flex-col">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="button_color">Cor dos Botões</label>
                <?= form_input("button_color", isset($theme["button_color"]) ? "{$theme["button_color"]}" : old("button_color", ''), ["class" => "form-control form-control-sm", "id" => "button_color"], 'color'); ?>
            </div>
            <div class="flex flex-col">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="font_color">Cor da Fonte</label>
                <?= form_input("font_color", isset($theme["font_color"]) ? "{$theme["font_color"]}" : old("font_color", ''), ["class" => "form-control form-control-sm", "id" => "font_color"], 'color'); ?>
            </div>

            <div class="flex flex-col mt-3" x-data="logoUploader">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Logotipo</label>

                <div class="border-2 border-dashed p-4 text-center cursor-pointer"
                    @dragover.prevent
                    @drop.prevent="handleDrop"
                    @paste="handlePaste">
                    <p class="text-gray-500">Arraste ou cole uma imagem aqui</p>
                    <template x-if="preview">
                        <img :src="preview" class="mt-2 w-32 object-contain mx-auto rounded">
                    </template>
                </div>

                <?= form_upload('logo', '', ['id' => 'logoUpload', 'class' => 'hidden', 'x-ref' => 'fileInput', '@change' => 'handleFile']); ?>

                <button type="button" class="mt-2 p-2 bg-gray-200 rounded text-sm" @click="$refs.fileInput.click()">Escolher Arquivo</button>
            </div>

            <div class="flex flex-col mt-3">
                <label for="icon" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ícone</label>
                <?= form_upload('icon', isset($theme['icon']) ? $theme['icon'] : '', ['id' => 'icon', 'class' => 'hidden', 'accept' => '.ico']); ?>
            </div>

            <div class="flex justify-end mt-3">
                <?= form_submit('submit', 'Salvar', ['class' => 'text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 shadow-lg shadow-teal-500/50 dark:shadow-lg dark:shadow-teal-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2']); ?>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('logoUploader', () => ({
        preview: "<?= isset($theme) && $theme['logo'] ? base_url('/images/themes/' . $theme['logo']) : '' ?>",
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
