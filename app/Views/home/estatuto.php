<?= $this->extend('layouts/main'); ?>

<?php $this->section('content'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

<div class="flex flex-col items-center p-4">
    
    <div class="mb-4 flex items-center space-x-2">
        <button id="prevPage" class="px-3 py-2 bg-gray-200 rounded hover:bg-gray-300">◀ Anterior</button>
        <span id="pageInfo" class="text-lg font-semibold">Página 1 / ?</span>
        <button id="nextPage" class="px-3 py-2 bg-gray-200 rounded hover:bg-gray-300">Próxima ▶</button>
        
        <button id="zoomOut" class="ml-4 px-3 py-2 bg-gray-200 rounded hover:bg-gray-300">➖ Zoom</button>
        <button id="zoomIn" class="px-3 py-2 bg-gray-200 rounded hover:bg-gray-300">➕ Zoom</button>
    </div>

    <div class="border rounded-lg shadow-lg p-2 bg-white">
        <canvas id="pdf-viewer" class="max-w-full"></canvas>
    </div>
</div>

<script>
const url = '/docs/estatuto.pdf';
let pdfDoc = null,
    pageNum = 1,
    scale = 1.5,
    canvas = document.getElementById('pdf-viewer'),
    ctx = canvas.getContext('2d');

function renderPage(num) {
    pdfDoc.getPage(num).then(page => {
        let viewport = page.getViewport({ scale: scale });
        canvas.width = viewport.width;
        canvas.height = viewport.height;

        let renderContext = { canvasContext: ctx, viewport: viewport };
        page.render(renderContext);

        // Atualiza o contador de páginas
        document.getElementById('pageInfo').textContent = `Página ${num} / ${pdfDoc.numPages}`;
    });
}

pdfjsLib.getDocument(url).promise.then(pdf => {
    pdfDoc = pdf;
    renderPage(pageNum);
});

document.getElementById('prevPage').addEventListener('click', () => {
    if (pageNum > 1) {
        pageNum--;
        renderPage(pageNum);
    }
});
document.getElementById('nextPage').addEventListener('click', () => {
    if (pageNum < pdfDoc.numPages) {
        pageNum++;
        renderPage(pageNum);
    }
});

document.getElementById('zoomIn').addEventListener('click', () => {
    scale += 0.2;
    renderPage(pageNum);
});
document.getElementById('zoomOut').addEventListener('click', () => {
    if (scale > 0.5) {
        scale -= 0.2;
        renderPage(pageNum);
    }
});
</script>

<?php $this->endSection(); ?>
