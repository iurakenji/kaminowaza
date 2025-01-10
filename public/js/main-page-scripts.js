document.addEventListener("DOMContentLoaded", function() {

    const staticModal = document.getElementById('static-modal');
    const closeButton = staticModal.querySelector('button');
    const deleteButtons = document.querySelectorAll(".delete_button");
    const modal = document.getElementById("popup-confirm");
    const confirmButton = modal.querySelector("button.text-white.bg-red-600");
    let currentHref = null;

    const alerts = document.querySelectorAll('#alert-border-3, #alert-border-2');
    alerts.forEach((elemento) => {
        setTimeout(() => {
            if (elemento) {
                elemento.style.display = 'none';
            }
        }, 5000);   
    });

    deleteButtons.forEach(button => {
        button.addEventListener("click", function (event) {
            event.preventDefault();
            currentHref = this.href;
            modal.classList.remove("hidden");
        });
    });

    confirmButton.addEventListener("click", function () {
        if (currentHref) {
            window.location.href = currentHref;
        }
    });

    initCloseModalButtons();

});

function initCloseModalButtons() {
    document.addEventListener('click', (event) => {
        const closeButton = event.target.closest('.close-modal');
        if (closeButton) {
            const modalId = closeButton.dataset.modalId;
            const modal = document.getElementById(modalId);

            if (modal) {
                // modal.classList.add("hidden");
                 modal.style.display = 'none'; // Oculta a modal
                console.log(`Modal ${modalId} foi fechada.`);
            } else {
                console.warn(`Modal com ID ${modalId} não encontrada.`);
            }
        }
    });
}
