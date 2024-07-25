function openModal(id) {
    document.getElementById(id).classList.add('open');
    document.body.classList.add('jw-modal-open');
}


function closeModal() {
    document.querySelector('.jw-modal.open').classList.remove('open');
    document.body.classList.remove('jw-modal-open');
}


window.addEventListener('load', function() {
    document.addEventListener('click', event => {
        if (event.target.classList.contains('jw-modal')) {
            closeModal();
        }
    });
});

// ::::::::::::::::::::::: CREACION CHECK POLITICAS :::::::::::::::::::::::::::::::::::::::::::::
function crearTerminosYCondiciones() {
    let politicas = document.getElementById('politicas').value;
    let seccion_politicas = `
                    <div class="mt-1">
                        <div>
                            <input id="check-politicas" type="checkbox">
                            <a class="txt-check" onclick="openModal('modal-1')">Aceptar <span style="color:#2465ff">Términos y Condiciones</span></a>
                        </div>
                        <div id="modal-1" class="jw-modal">
                            <div class="jw-modal-body">

                                <div class="row titulo_terms" style="display:flex; align-items:flex-start; justify-content:space-between;">
                                    <div class="col-9 col-lg-10">
                                        <h2 class="word-wrap">Términos y Condiciones</h2>
                                    </div>

                                    <div class="col-2 col-lg-2">
                                        <a class="close-modal buttonCloseModal" aria-label="cerrar ventana emergente de términos y condiciones"
                                            onclick="closeModal()">
                                            <i aria-hidden="true" class="${classNameFontAwesomeClose}"></i>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="txt-politicas">
                                    ${politicas}
                                </div>
                            </div>
                        </div>
                    </div>`;
    $("#terminos-condiciones").append(seccion_politicas);
    return agregarClasesDisabled();
};

function agregarClasesDisabled() {
    $("#btnPagar").prop("disabled", true);
    $("#paypal-button-container").addClass("dissabled-btn");
};

$(document).ready(function() {
    crearTerminosYCondiciones();
    const checkbox_politicas = document.getElementById('check-politicas');
    
    checkbox_politicas.addEventListener('change', (event) => {
        if (event.currentTarget.checked) {
            $("#btnPagar").prop("disabled", false);
            $("#paypal-button-container").removeClass("dissabled-btn");
        } else {
            $("#btnPagar").prop("disabled", true);
            $("#paypal-button-container").addClass("dissabled-btn");
        }
    });
});