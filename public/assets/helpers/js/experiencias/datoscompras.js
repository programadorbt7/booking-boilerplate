var totalOriginales                 = {};
var classNameFontAwesome            = "";
var classNameFontAwesomeWP          = "";
var classNameFontAwesomeClose       = "";
var classNameFontAwesomeNoneCoupon  = "";

function mostrarDivPorProcesosDePagos() {
    let procesoPago             = document.getElementById("procesoPago").value;
    let losTiposDeProcesosPagos = procesoPago.split(",");
    let anticipo                = parseInt(document.getElementById("anticipo").value);
    costosOriginales();
    crearSelected(document.getElementById("procesosPagos"));
    
    for(let i = 0; i < losTiposDeProcesosPagos.length; i++) {
        let valorDeCadaCheckbox = parseInt(losTiposDeProcesosPagos[i]);
        switch(valorDeCadaCheckbox){
        case 0:
            crearSeletedOptions(0,"Pago Completo");
            break;
        case 1:
            crearSeletedOptions(1,"Anticipo De Pago");
            break;
        case 2:
            crearSeletedOptions(2,"Contacto");
            break;
        default:
            console.log('No hay este tipo de pago ' + valorDeCadaCheckbox);
            break;
        }
    }

    // comprobarProcesoPagos(document.getElementById("procesoDePagoSeleccionado"));
};

function costosOriginales() {
    let total = $("#gtotal").val();
    let totalExperienciaFinal = $("#totalExperienciaFinal").val();
    totalOriginales = {
        totalOriginal: total,
        totalExperienciaValidCupon: totalExperienciaFinal, 
    };
    return totalOriginales;
};

function crearSeletedOptions(valor, nombre) {
    let selectProcesosPagos         = document.getElementById("procesoDePagoSeleccionado");
    let optionProcesosPagos         = document.createElement("option");
    optionProcesosPagos.value       = valor;
    optionProcesosPagos.id          = nombre.replaceAll(' ', '');
    optionProcesosPagos.name        = nombre.replaceAll(' ', '');
    optionProcesosPagos.innerText   = nombre;
    return selectProcesosPagos.append(optionProcesosPagos);
};

function comprobarProcesoPagos(element) {
    let valorInputProcesoPago       = parseInt(element.value);
    let gTotalTour                  = parseFloat(totalOriginales['totalOriginal']);
    let costosOriginalAntesDelCupon = parseFloat(totalOriginales['totalExperienciaValidCupon']);
    let anticipoPorcentaje;
    let totalTour;
    let tipoValor;

    cambiarStatusPropiedades(false);

    switch(valorInputProcesoPago) {
        case 0:
            agregarComprobarCupon();
            resetPreciosOriginales();
            totalTour = gTotalTour;
            deletetextDecoration(false);
            esconderContenedoresMetodosPagos(totalTour, valorInputProcesoPago);
            obtenerCupon();
            break;
        case 1:
            tipoValor                   = parseInt($("#tipoValor").val());
            anticipoPorcentaje          = parseInt(document.getElementById("anticipo").value);
            if(tipoValor == 1) {
                //El anticipo es por monto
                totalTourAnticipo       = anticipoPorcentaje;
                let currency            = $("#currency").val();
                createNewElement("textoAnticipo","p",`La cantidad del anticipo para este tour es de ${formatPriceValue(anticipoPorcentaje)} ${currency}.`,"procesosPagos", false, '');
            } else {
                //Es por porcentaje
                totalTourAnticipo       = (gTotalTour * (0.+anticipoPorcentaje))/100;
                totalTourAnticipo       = parseFloat(totalTourAnticipo).toFixed(2);
                let porcentajeAnticipo  = 0.+anticipoPorcentaje;
                createNewElement("textoAnticipo","p",`El porcentaje del anticipo para este tour es del ${porcentajeAnticipo}%.`,"procesosPagos", false, '');
            }
            totalTour                   = totalTourAnticipo;
            //Restante del anticipo
            // totalTour               = gTotalTour - totalTourAnticipo;
            addIconFontAwesome(1);
            crearTrTable("tfooterTable","precioTotalAnticipoTable","Anticipo",`${formatPriceValue(totalTour)} ${$("#currency").val()}`);
            createNewElement("precioOriginalTour","input",``,"td1precioTotalAnticipoTable", true, gTotalTour);
            createNewElement("cantidadAnticipo","input",``,"td1precioTotalAnticipoTable", true, totalTour);
            esconderContenedoresMetodosPagos(totalTour, valorInputProcesoPago);
            deletetextDecoration(true);
            $('#totalExperienciaFinal').val(totalTour);
            $('#totalPriceNew').remove();
            $('.containerTheMessageCuponResponse').css("display","none");
            $('#mensajeCupon').css("display","none");
            cambiarStatusPropiedades(true);
            crearMensajeNoPermitidoAplicarCupones();
            $('#checkCoupon').removeAttr('onclick');
            break;
        case 2:
            agregarComprobarCupon();
            resetPreciosOriginales();
            totalTour = gTotalTour;
            deletetextDecoration(false);
            esconderContenedoresMetodosPagos(totalTour, valorInputProcesoPago);
            obtenerCupon();
            contentButtonWhatsApp();
            addIconFontAwesome(2);
            break;
        default:
            agregarComprobarCupon();
            valueDefault();
            console.log("No hay este proceso de pago");
            break;
    }

    return totalTour;
};

function crearSelected(idElementParent) {
    let nombreDelElemento               = "procesoDePagoSeleccionado";
    let seletedProcesosDePagos          = document.createElement("select");
    let labelProcesosPagos              = document.createElement("label");
    let optionDefault                   = document.createElement("option");
    seletedProcesosDePagos.id           = nombreDelElemento;
    seletedProcesosDePagos.name         = nombreDelElemento;
    seletedProcesosDePagos.className    = "form-control";
    seletedProcesosDePagos.required     = true;
    seletedProcesosDePagos.setAttribute("onchange", "comprobarProcesoPagos(this)");
    labelProcesosPagos.innerText        = "Procesos de pagos: ";
    labelProcesosPagos.setAttribute("for", nombreDelElemento);
    optionDefault.innerText             = "Seleccione una opción";
    seletedProcesosDePagos.appendChild(optionDefault);
    idElementParent.append(labelProcesosPagos);
    return idElementParent.append(seletedProcesosDePagos);
};

function contentButtonWhatsApp(){
    let contenedorWP    = document.createElement("div");
    let buttonWP        = document.createElement("button");
    let h5              = document.createElement("h5");
    let elementParent   = document.getElementById("procesosPagos");
    let p               = document.createElement("p");
    let aceptoTerminos  = document.getElementById("check-politicas").checked;
    let estatusTerminos = aceptoTerminos == true ? false : true; 
    let clase           = estatusTerminos ? "dissabled-btn" : ""; 
    buttonWP.id         = "buttonWP";
    buttonWP.innerText  = "WhatsApp";
    buttonWP.setAttribute("onclick", "agregarReservacion()");
    if(aceptoTerminos == false) {
        buttonWP.setAttribute("disabled", estatusTerminos);
    }
    buttonWP.className  = estatusTerminos ? "dissabled-btn" : "";
    h5.className        = "labelWP";
    h5.id               = "labelWPS";
    h5.innerText        = "Contacto mediante:";
    p.id                = "descripcionWP";
    p.innerText         = "Serás reendirigido a la aplicación de whatsApp, para que puedas enviar tu mensaje de reserva a la agencia.";
    contenedorWP.id     = "contendorWP";
    contenedorWP.appendChild(h5);
    contenedorWP.appendChild(buttonWP);
    contenedorWP.appendChild(p);
    return elementParent.appendChild(contenedorWP);
};

function agregarReservacion(){
    event.preventDefault();
    if(validacionFormulario()){
        const tokenFormulario = $("input[name*='_token']").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': tokenFormulario
            }
        });
        $.ajax({
            method: "POST",
            url: "/guardar-openpay",
            data: $("#frmCompra").serialize(),
            dataType: "json",
            beforeSend: function () {
                $("#buttonWP").text("Espere un momento...");
            },
        })
        .done(function( response ) {
            $("#buttonWP").text("Redireccionando...");
            // console.log(response);
            // console.log(response.responseText);
            let mensaje             = mensajeWhatsApp();
            let mensajeCodificado   = encodeURIComponent(mensaje);
            let numeroAgencia       = obtenerNumeroDeTelefono();
            window.open("https://wa.me/"+numeroAgencia+"?text="+mensajeCodificado, "whatsapp_message");
            window.location.href    = "/gracias";
        })
        .fail(function( error ) {
            // console.log(error);
            // console.log(error.responseJSON);
            console.log('no se pudo registrar la reserva');
        });
    } else {
        return;
    }
};

function esconderContenedoresMetodosPagos(totalTour, valorInputProcesoPago) {
    document.getElementById("gtotal").value                 = totalTour;
    let statusPromo = parseInt(document.getElementById("aplicapromo").value);

    if(statusPromo == 0) {
        document.getElementById("totalExperienciaFinal").value  = totalTour;
    }

    switch(valorInputProcesoPago) {
        case 0:
            document.getElementById("contenedorTerminales").style.display = "block";
            removerElement("textoAnticipo");
            removerElement("precioTotalAnticipoTable");
            removerElement("contendorWP");
            removerElement("mensajeNoAplicarCupones");
            break;
        case 1:
            document.getElementById("contenedorTerminales").style.display = "block";
            removerElement("contendorWP");
            break;
        case 2:
            document.getElementById("contenedorTerminales").style.display = "none";
            removerElement("textoAnticipo");
            removerElement("precioTotalAnticipoTable");
            removerElement("mensajeNoAplicarCupones");
            break;
        default: 
            return;
            break;
    }

    return;
};

function validacionFormulario() {
    if(($("#nombreTitular").val() != '') && ($("#apellidoTitular").val() != '') && ($("#telefonoTitular").val() != '') && ($("#sexoTitular").val() != '') && ($("#dianacTitular").val() != '') && ($("#mesnacTitular").val() != '') && ($("yearTitular").val() != '')){
        return true;
    } else {
        alert("Debes rellenar la información faltante del formulario, por favor");
        return false;
    }
};

function mensajeWhatsApp() {
    let gTotal      = $("#gtotal").val();
    let textTotal   = "$ "+ gTotal + " " + $("#currency").val();
    let informacionReserva = { 
        nombre_del_titular : $("#nombreTitular").val(),
        apellido_del_titular: $("#apellidoTitular").val(),
        nombre_del_tour: $("#nombretour").val(),
        fecha_de_viaje: $("#fecha_viaje_input").val(),
        adultos: $("#adultos").val(),
        menores: $("#menores").val(),
        infantes: $("#infantes").val(),
        total: textTotal,
    };

    let texto = "Reserva realizada mediante contacto, \nDatos de la reserva: ";
    for(propiedad in informacionReserva) {
        texto += `${propiedad.replaceAll("_", " ")}: ${informacionReserva[propiedad]}, \n`;
    }

    return texto;
};

function valueDefault() {
    $("#gtotal").val(parseFloat(totalOriginales['totalOriginal']));
    removerElement("textoAnticipo");
    removerElement("precioTotalAnticipoTable");
    removerElement("mensajeNoAplicarCupones");
    removerElement("contendorWP");
    $("#total").css("text-decoration","none");
    $('#totalExperienciaFinal').val(totalOriginales['totalExperienciaValidCupon']);
    return obtenerCupon();
}

function resetPreciosOriginales() {
    $('#totalExperienciaFinal').val(totalOriginales['totalExperienciaValidCupon']);
    $("#gtotal").val(parseFloat(totalOriginales['totalOriginal']));
};

function formatPriceValue(total) {
    const price = total;
    let USDollar = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2,
        maximumFractionDigits: 3,
    });

    return USDollar.format(price);
};

function obtenerNumeroDeTelefono() {
    let hrefWP              = $("[href*='https://wa.me/']")[0];
    let valor               = hrefWP.href;
    let posicionLetraMe     = valor.search("me/");
    let posicionLetraSigno  = valor.search("[?]");
    return valor.slice(posicionLetraMe + 3,posicionLetraSigno);
};

function removerElement(idElement) {
    if (document.getElementById(idElement))
        document.getElementById(idElement).remove();
    return;
};

function createNewElement(id,tipoElement,texto,parent, tipoValue = false, valorElement, position = 1) {
    let newElement         = document.createElement(tipoElement);
    newElement.id          = id;
    newElement.innerText   = texto;
    
    if(tipoValue == true) {
        newElement.value    = valorElement;
        // newElement.setAttribute('value', valorElement);
        newElement.setAttribute('hidden', true);
        newElement.name         = id;
        newElement.disabled     = false;
    }

    if(position == 0) {
        return document.getElementById(parent).insertAdjacentElement("beforeBegin",newElement);
    } else {
        return document.getElementById(parent).appendChild(newElement);
    }
};

function obtenerCupon() {
    let statusPromo = parseInt(document.getElementById("aplicapromo").value);
    if(isNaN(statusPromo)) {
        statusPromo = 0; 
    }
    if(statusPromo == 0) {
        if(document.getElementById("containerCounpon").style.cssText != 'display: none; width: 100%;') {
            if(document.getElementById("inputGetCoupon").value != '')
                return document.getElementById("checkCoupon").click();
            return document.getElementById("checkCoupon").click();
        }
        return;
    }
    return;
};

function removerNewPriceTours(idElement) {
    if(document.getElementById(idElement)){
        $("#"+idElement).remove();
    } else {
        return;
    }
};

function crearTrTable(table, id, textTr, textValue) {
    let tableId             = document.getElementById(table);
    let trElement           = document.createElement("tr");
    let tdElement           = document.createElement("td");
    let tdElement1          = document.createElement("td");
    let input               = document.createElement("input");
    let strongElement       = document.createElement("strong");
    trElement.className     = "total_row";
    trElement.id            = id;
    tdElement.id            = "td"+id;
    strongElement.id        = "strong"+id;
    strongElement.innerText = textTr;
    input.id                = "input"+id;
    input.name              = "totalAnticipo";
    input.value             = textValue;
    // input.setAttribute('value',textValue);
    input.disabled          = true;
    tdElement1.id           = "td1"+id;
    tdElement1.colSpan      = 2;
    tdElement1.appendChild(input);
    tdElement.appendChild(strongElement);
    trElement.appendChild(tdElement);
    trElement.appendChild(tdElement1);
    return tableId.appendChild(trElement);
};

function cambiarStatusPropiedades(estatus) {
    if(estatus) {
        $('.containerCupones > input:nth-child(1)').prop("disabled", true);
        $('.containerCupones > div button:nth-child(1)').prop("disabled", true);
        return $('.containerCupones > div button:nth-child(1)').css("cursor", 'not-allowed');
    } else {
        $('.containerCupones > input:nth-child(1)').prop("disabled", false);
        $('.containerCupones > div button:nth-child(1)').prop("disabled", false);
        return $('.containerCupones > div button:nth-child(1)').css("cursor", 'unset');
    }
};

function crearMensajeNoPermitidoAplicarCupones() {
    let contenedorMsgNot        = document.createElement('div');
    let icono                   = document.createElement('i');
    let span                    = document.createElement('span');
    contenedorMsgNot.id         = 'mensajeNoAplicarCupones';
    contenedorMsgNot.classList  = 'noAceptaCupones';
    icono.classList             = classNameFontAwesomeNoneCoupon;
    span.id                     = 'spanIcono';
    span.innerText              = 'No esta permitido aplicar cupón.';
    contenedorMsgNot.appendChild(icono);
    contenedorMsgNot.appendChild(span);
    return document.getElementsByClassName('containerCupones')[0].appendChild(contenedorMsgNot);
};

function agregarComprobarCupon() {
    return $('#checkCoupon').attr('onclick', 'comprobarCoupon(5)');
};

function deletetextDecoration(value) {
    if(value) {
        // $("#tfooterTable > tr:nth-child(1) > td > strong").css("text-decoration", "line-through");
        return $("#tfooterTable > tr:nth-child(1) td > input").css("text-decoration", "line-through");
    } else {
        // $("#tfooterTable > tr:nth-child(1) > td > strong").css("text-decoration", "none");
        return $("#tfooterTable > tr:nth-child(1) td > input").css("text-decoration", "none"); 
    }
};

function addIconFontAwesome(type) {
    switch(type) {
        case 1:
            $("#textoAnticipo").prepend(`<i class='${classNameFontAwesome}' style='margin-right: 5px;'></i>`);
            break;
        case 2:
            $("#buttonWP").prepend(`<i class='${classNameFontAwesomeWP}' style='margin-right: 5px;'></i>`);
            break;
        default:
            break;
    }
    
    return;
};

function seleccionarElPrimerElemento() {
    return document.getElementById("procesoDePagoSeleccionado")[0].seleted = true;
};

// ::::::::::::::::::::::: CREACION CHECK POLITICAS :::::::::::::::::::::::::::::::::::::::::::::
function crearTerminosYCondiciones() {
    let politicas = document.getElementById('politicas').value;
    let seccion_politicas = `
                    <div class="mt-3">
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

// ::::::::::::::::::::::: MODAL POLITICAS ::::::::::::::::::::::::::::::::::::::::::::
function openModal(id) {
    document.getElementById(id).classList.add('open');
    document.body.classList.add('jw-modal-open');
};

function closeModal() {
    document.querySelector('.jw-modal.open').classList.remove('open');
    document.body.classList.remove('jw-modal-open');
};

window.addEventListener('load', function() {
    document.addEventListener('click', event => {
        if (event.target.classList.contains('jw-modal')) {
            closeModal();
        }
    });
});

function agregarClasesDisabled() {
    $("#btnPagar").prop("disabled", true);
    $("#paypal-button-container").addClass("dissabled-btn");
    $(".btnOpenPay").addClass("dissabled-btn");
    // $("#buttonWP").prop("disabled", true);
    $("#buttonWP").addClass("dissabled-btn");
};

// $(document).ready(mostrarDivPorProcesosDePagos);
$(document).ready(function() {
    mostrarDivPorProcesosDePagos();
    // createNewElement("textAlternativoSeleccione","span","Seleccione una opción:","procesoDePagoSeleccionado", 0);
    // crearTerminosYCondiciones();

    const checkbox_politicas = document.getElementById('check-politicas');

    checkbox_politicas.addEventListener('change', (event) => {
        if (event.currentTarget.checked) {
            $("#btnPagar").prop("disabled", false);
            $("#paypal-button-container").removeClass("dissabled-btn");
            $(".btnOpenPay").removeClass("dissabled-btn");
            $("#buttonWP").prop("disabled", false);
            $("#buttonWP").removeClass("dissabled-btn");
            // $("#buttonWP").removeAttr("dissabled-btn");
        } else {
            $("#btnPagar").prop("disabled", true);
            $("#paypal-button-container").addClass("dissabled-btn");
            $(".btnOpenPay").addClass("dissabled-btn");
            $("#buttonWP").addClass("dissabled-btn");
            $("#buttonWP").prop("disabled", true);
        }
    });
});