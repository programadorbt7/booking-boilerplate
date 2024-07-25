$(document).ready(function () {
    $("#currency").change(function () {
        moneda = $(this).val();
        changeCurrency(moneda);
    });
});

function cargaPrecios(
    tour,
    dias,
    fecha,
    generales,
    mostrarpromo,
    booking,
    travel,
    clase
) {

    $("#loadingPrices").removeClass("oculto");
    let dataFrm = {};
    dataFrm.tour = tour;
    dataFrm.dias = dias;
    dataFrm.fecha = fecha;
    dataFrm.clase = clase;

    dataFrm.generales = generales;
    dataFrm.mostrarpromo = mostrarpromo;
    dataFrm.booking = booking;
    dataFrm.travel = travel;

    var data = JSON.stringify(dataFrm);

    var formData = {
        _token: "{{csrf_token()}}",
        data: data,
    };

    $.ajax({
        mehod: "GET",
        url: "/getPrices",
        dataType: "html",
        data: formData,
    })
        .done(function (response) {
            console.log("Cargar precios normal");
            $("#loadingPrices").addClass("oculto");
            $("#contieneprecios").html(response);
            preciosSelect();
            calculaPrecios();
        })
        .fail(function () { });

    // var tipo_costo = $("#tipo_costo").val();
    // var cantidad_tipo_costo = $("#cantidad_tipo_costo").val();
    // // Cambios pedrito travel-cit
    // const adultos = document.querySelector("#adultos")
    // const menores = document.querySelector("#menores")
    // let adultosvalue = adultos.value;
    // let menoresvalue = menores.value;
    // if(tipo_costo == '1'){
    //         adultos.innerHTML = ""
    //         menores.innerHTML = ""
    //         adultosvalue = adultosvalue <= 1 ? adultosvalue : 1;
    //         menoresvalue = menoresvalue <= 2 ? menoresvalue : 2;

    //         adultos.add(new Option("0"))
    //         adultos.add(new Option(cantidad_tipo_costo))

    // }

    // adultos.value = adultosvalue;
    // menores.value = menoresvalue;
}

function cargaPreciosGrupal(
    tour,
    dias,
    fecha,
    generales,
    mostrarpromo,
    booking,
    travel,
    clase
) {


    $("#loadingPrices").removeClass("oculto");
    let dataFrm = {};
    dataFrm.tour = tour;
    dataFrm.dias = dias;
    dataFrm.fecha = fecha;
    dataFrm.clase = clase;

    dataFrm.generales = generales;
    dataFrm.mostrarpromo = mostrarpromo;
    dataFrm.booking = booking;
    dataFrm.travel = travel;

    var data = JSON.stringify(dataFrm);

    var formData = {
        _token: "{{csrf_token()}}",
        data: data,
    };

    $.ajax({
        mehod: "GET",
        url: "/getPrices",
        dataType: "html",
        data: formData,
    })
        .done(function (response) {
            console.log("Cargar precios grupal");
            $("#loadingPrices").addClass("oculto");
            $("#contieneprecios").html(response);
            preciosSelect();
            calculaPreciosGrupal();
        })
        .fail(function () { });


}

function mostrarPreciosCircuitos(select) {


    var id = $(select).val();
    var hoteleria = $("#hoteleria").val();
    let habSencilla = hoteleria == 0 ? "" : "HAB SENCILLA";
    let habDoble = hoteleria == 0 ? "" : "HAB DOBLE";
    let habTriple = hoteleria == 0 ? "" : "HAB TRIPLE";
    let habCuadruple = hoteleria == 0 ? "" : "HAB CUADRUPLE";
    let thTable =
        hoteleria == 0
            ? ""
            : '<th scope="col" style="background-color:#E3F2FD"></th>';
    let thTableHab =
        hoteleria == 0
            ? ""
            : '<th scope="col" style="background-color:#E3F2FD">' +
            habSencilla +
            "</th>";

    //Indicadores de promo
    var booking = parseInt($(select).find("option:selected").data("booking"));
    var travel = parseInt($(select).find("option:selected").data("travel"));
    
    var promo_nombre = $("#nombre_promo").val();
    var promo_descripcion = $("#descripcion").val();
    var paxes_promocion_cir = parseInt($("#paxes_promocion_cir").val()); //A partir de que numero de personas
    var travel_window_inicio = $("#travel_window_inicio").val();
    var travel_window_fin = $("#travel_window_fin").val();
    var tipo_descuento = parseInt($("#tipo_descuento_cir").val());
    var valor_promocion = parseInt($("#valor_promocion_cir").val()); //De cuanto es la promoción
    var aplica_descuento = parseInt($("#descuento_cir").val());

    var fecha_inicio = $("#fecha_inicio_" + id).val();
    var fecha_fin = $("#fecha_fin_" + id).val();
    var id_temporada = $("#id_temporada_" + id).val();
    var nombre_temporada = $("#nombre_temporada_" + id).val();
    var id_clase_servicio = $("#id_clase_servicio_" + id).val();
    var nombre_servicio = $("#nombre_servicio_" + id).val();

    $("#fechaInicioDeLaTemporada").val(fecha_inicio);
    $("#fechaFinDeLaTemporada").val(fecha_fin);

    var currency = $("#currency").val();

    //Precios sin promocion
    var adulto_sgl = parseFloat($("#adulto_sen_" + id).val()).toFixed(2);
    var adulto_dbl = parseFloat($("#adulto_dbl_" + id).val()).toFixed(2);
    var adulto_tpl = parseFloat($("#adulto_tpl_" + id).val()).toFixed(2);
    var adulto_cpl = parseFloat($("#adulto_cpl_" + id).val()).toFixed(2);

    var menor_sgl = parseFloat($("#menor_sen_" + id).val()).toFixed(2);
    var menor_dbl = parseFloat($("#menor_dbl_" + id).val()).toFixed(2);
    var menor_tpl = parseFloat($("#menor_tpl_" + id).val()).toFixed(2);
    var menor_cpl = parseFloat($("#menor_cpl_" + id).val()).toFixed(2);

    var infante_sgl = parseFloat($("#infante_sen_" + id).val()).toFixed(2);
    var infante_dbl = parseFloat($("#infante_dbl_" + id).val()).toFixed(2);
    var infante_tpl = parseFloat($("#infante_tpl_" + id).val()).toFixed(2);
    var infante_cpl = parseFloat($("#infante_cpl_" + id).val()).toFixed(2);

    //Precios con promocion
    if ((booking === 1 && travel === 1) && aplica_descuento === 1) {
        if (tipo_descuento === 2) {
            //Descuento por monto
            var adulto_sgl_promo = adulto_sgl - valor_promocion;
            var adulto_dbl_promo = adulto_dbl - valor_promocion;
            var adulto_tpl_promo = adulto_tpl - valor_promocion;
            var adulto_cpl_promo = adulto_cpl - valor_promocion;

            var menor_sgl_promo = menor_sgl - valor_promocion;
            var menor_dbl_promo = menor_dbl - valor_promocion;
            var menor_tpl_promo = menor_tpl - valor_promocion;
            var menor_cpl_promo = menor_cpl - valor_promocion;

            var infante_sgl_promo = infante_sgl - valor_promocion;
            var infante_dbl_promo = infante_dbl - valor_promocion;
            var infante_tpl_promo = infante_tpl - valor_promocion;
            var infante_cpl_promo = infante_cpl - valor_promocion;
        } else {
            //Descuento por porcentaje
            var adulto_sgl_promo =
                adulto_sgl - adulto_sgl * (valor_promocion / 100);
            var adulto_dbl_promo =
                adulto_dbl - adulto_dbl * (valor_promocion / 100);
            var adulto_tpl_promo =
                adulto_tpl - adulto_tpl * (valor_promocion / 100);
            var adulto_cpl_promo =
                adulto_cpl - adulto_cpl * (valor_promocion / 100);

            var menor_sgl_promo =
                menor_sgl - menor_sgl * (valor_promocion / 100);
            var menor_dbl_promo =
                menor_dbl - menor_dbl * (valor_promocion / 100);
            var menor_tpl_promo =
                menor_tpl - menor_tpl * (valor_promocion / 100);
            var menor_cpl_promo =
                menor_cpl - menor_cpl * (valor_promocion / 100);
            // console.log("pmenor: "+menor_sgl+" - promo: "+menor_sgl_promo);

            var infante_sgl_promo =
                infante_sgl - infante_sgl * (valor_promocion / 100);
            var infante_dbl_promo =
                infante_dbl - infante_dbl * (valor_promocion / 100);
            var infante_tpl_promo =
                infante_tpl - infante_tpl * (valor_promocion / 100);
            var infante_cpl_promo =
                infante_cpl - infante_cpl * (valor_promocion / 100);
        }

        if (booking == 1) {
            var promocion =
                "<tr>" +
                '<td colspan="4" style="background-color: white; color:black;">' +
                '<p class="text-center estilosPromoP">' +
                '<br>' +
                promo_nombre +
                '<br>'+
                promo_descripcion +
                "<br>" +
                "<b>" +
                "Promoción valida a partir de " +
                paxes_promocion_cir +
                " persona(s)" +
                "</b>" +
                "<br>";

            if (travel_window_inicio != null && travel_window_inicio != '') {
                promocion +=
                    '<span class="text-danger">' +
                    "Viajando entre las fechas del " +
                    travel_window_inicio +
                    " al " +
                    travel_window_fin +
                    "</span>" +
                    "</p>" +
                    "</td>" +
                    "</tr>";
            }


        } else {
            var promocion =
                "<tr>" +
                '<td colspan="3" style="background-color: white; color:black;">' +
                '<p class="text-center estilosPromoP">' +
                '<br>' +
                promo_nombre +
                '<br>'+
                promo_descripcion +
                "<br>" +
                "<b>" +
                "Promoción valida a partir de " +
                paxes_promocion_cir +
                " persona(s)" +
                "</b>" +
                "<br>";

            if (travel_window_inicio != null && travel_window_inicio != '') {
                promocion +=
                    '<span class="text-danger">' +
                    "Viajando entre las fechas del " +
                    travel_window_inicio +
                    " al " +
                    travel_window_fin +
                    "</span>" +
                    "</p>" +
                    "</td>" +
                    "</tr>";
            }
        }

    } else {
        var promocion = "";
    }

    var head =
        '<table class="table table-bordered text-center">' +
        "<thead>" +
        "<tr>" +
        thTable +
        '<th scope="col" style="background-color:#E3F2FD">ADULTOS</th>' +
        '<th scope="col" style="background-color:#E3F2FD">MENORES</th>' +
        '<th scope="col" style="background-color:#E3F2FD;">INFANTES</th>' +
        "</tr>" +
        "</thead>" +
        "<tbody>";

    if (adulto_sgl > 0) {
        if ((booking === 1 || travel === 1) && aplica_descuento === 1) {
            var sgl =
                "<tr>" +
                thTableHab +
                '<td style="background-color: white; color:black;">' +
                '<p class="text-center"><label>$ ' +
                adulto_sgl.toLocaleString("en-US") +
                "" +
                currency +
                "</label></p>" +
                '<input type="hidden" id="adulto_precio" value="' +
                adulto_sgl +
                '">' +
                "</td>" +
                '<td style="background-color: white; color:black;">' +
                '<p class="text-center"><label>$ ' +
                menor_sgl.toLocaleString("en-US") +
                "" +
                currency +
                "</label></p>" +
                '<input type="hidden" id="menor_precio" value="' +
                menor_sgl +
                '">' +
                "</td>" +
                '<td style="background-color: white; color:black;">' +
                '<p class="text-center"><label>$ ' +
                infante_sgl.toLocaleString("en-US") +
                "" +
                currency +
                "</label></p>" +
                '<input type="hidden" id="infante_precio" value="' +
                infante_sgl +
                '">' +
                "</td>" +
                "</tr>";
        } else {
            var sgl =
                "<tr>" +
                thTableHab +
                '<td style="background-color: white; color:black;">' +
                '<p class="text-center"><label>$ ' +
                adulto_sgl.toLocaleString("en-US") +
                "" +
                currency +
                "</label></p>" +
                '<input type="hidden" id="adulto_precio" value="' +
                adulto_sgl +
                '">' +
                "</td>" +
                '<td style="background-color: white; color:black;">' +
                '<p class="text-center"><label>$ ' +
                menor_sgl.toLocaleString("en-US") +
                "" +
                currency +
                "</label></p>" +
                '<input type="hidden" id="menor_precio" value="' +
                menor_sgl +
                '">' +
                "</td>" +
                '<td style="background-color: white; color:black;">' +
                '<p class="text-center"><label>$ ' +
                infante_sgl.toLocaleString("en-US") +
                "" +
                currency +
                "</label></p>" +
                '<input type="hidden" id="infante_precio" value="' +
                infante_sgl +
                '">' +
                "</td>" +
                "</tr>";
        }
    } else {
        var sgl = "";
    }

    if (adulto_dbl > 0) {
        if ((booking === 1 || travel === 1) && aplica_descuento === 1) {
            var dbl =
                "<tr>" +
                '<th scope="col" style="background-color:#E3F2FD">' +
                habDoble +
                "</th>" +
                '<td style="background-color: white; color:black;">' +
                '<p class="text-center"><label>$ ' +
                adulto_dbl.toLocaleString("en-US") +
                "" +
                currency +
                "</label></p>" +


                '<input type="hidden" id="adulto_precio" value="' +
                adulto_dbl +
                '">' +
                "</td>" +
                '<td style="background-color: white; color:black;">' +
                '<p class="text-center"><label>$ ' +
                menor_dbl.toLocaleString("en-US") +
                "" +
                currency +
                "</label></p>" +

                '<input type="hidden" id="menor_precio" value="' +
                menor_dbl +
                '">' +
                "</td>" +
                '<td style="background-color: white; color:black;">' +
                '<p class="text-center"><label>$ ' +
                infante_dbl.toLocaleString("en-US") +
                "" +
                currency +
                "</label></p>" +

                '<input type="hidden" id="infante_precio" value="' +
                infante_dbl +
                '">' +
                "</td>" +
                "</tr>";
        } else {
            var dbl =
                "<tr>" +
                '<th scope="col" style="background-color:#E3F2FD">' +
                habDoble +
                "</th>" +
                '<td style="background-color: white; color:black;">' +
                '<p class="text-center"><label>$ ' +
                adulto_dbl.toLocaleString("en-US") +
                "" +
                currency +
                "</label></p>" +
                '<input type="hidden" id="adulto_precio" value="' +
                adulto_dbl +
                '">' +
                "</td>" +
                '<td style="background-color: white; color:black;">' +
                '<p class="text-center"><label>$ ' +
                menor_dbl.toLocaleString("en-US") +
                "" +
                currency +
                "</label></p>" +
                '<input type="hidden" id="menor_precio" value="' +
                menor_dbl +
                '">' +
                "</td>" +
                '<td style="background-color: white; color:black;">' +
                '<p class="text-center"><label">$ ' +
                infante_dbl.toLocaleString("en-US") +
                "" +
                currency +
                "</label></p>" +
                '<input type="hidden" id="infante_precio" value="' +
                infante_dbl +
                '">' +
                "</td>" +
                "</tr>";
        }
    } else {
        var dbl = "";
    }

    if (adulto_tpl > 0) {
        if ((booking === 1 || travel === 1) && aplica_descuento === 1) {
            var tpl =
                "<tr>" +
                '<th scope="col" style="background-color:#E3F2FD">' +
                habTriple +
                "</th>" +
                '<td style="background-color: white; color:black;">' +
                '<p class="text-center"><label>$ ' +
                adulto_tpl.toLocaleString("en-US") +
                "" +
                currency +
                "</label></p>" +
                '<input type="hidden" id="adulto_precio" value="' +
                adulto_tpl +
                '">' +
                "</td>" +

                '<td style="background-color: white; color:black;">' +

                '<p class="text-center"><label>$ ' +
                menor_tpl.toLocaleString("en-US") +
                "" +
                currency +
                "</label></p>" +

                '<input type="hidden" id="menor_precio" value="' +
                menor_tpl +
                '">' +
                "</td>" +
                '<td style="background-color: white; color:black;">' +
                '<p class="text-center"><label>$ ' +
                infante_tpl.toLocaleString("en-US") +
                "" +
                currency +
                "</label></p>" +


                '<input type="hidden" id="infante_precio" value="' +
                infante_tpl +
                '">' +
                "</td>" +
                "</tr>";
        } else {
            var tpl =
                "<tr>" +
                '<th scope="col" style="background-color:#E3F2FD">' +
                habTriple +
                "</th>" +
                '<td style="background-color: white; color:black;">' +
                '<p class="text-center"><label>$ ' +
                adulto_tpl.toLocaleString("en-US") +
                "" +
                currency +
                "</label></p>" +
                '<input type="hidden" id="adulto_precio" value="' +
                adulto_tpl +
                '">' +
                "</td>" +
                '<td style="background-color: white; color:black;">' +
                '<p class="text-center"><label>$ ' +
                menor_tpl.toLocaleString("en-US") +
                "" +
                currency +
                "</label></p>" +
                '<input type="hidden" id="menor_precio" value="' +
                menor_tpl +
                '">' +
                "</td>" +
                '<td style="background-color: white; color:black;">' +
                '<p class="text-center"><label>$ ' +
                infante_tpl.toLocaleString("en-US") +
                "" +
                currency +
                "</label></p>" +
                '<input type="hidden" id="infante_precio" value="' +
                infante_tpl +
                '">' +
                "</td>" +
                "</tr>";
        }
    } else {
        var tpl = "";
    }

    if (adulto_cpl > 0) {
        if ((booking === 1 || travel === 1) && aplica_descuento === 1) {
            var cpl =
                "<tr>" +
                '<th scope="col" style="background-color:#E3F2FD">' +
                habCuadruple +
                "</th>" +
                '<td style="background-color: white; color:black;">' +

                '<p class="text-center"><label>$ ' +
                adulto_cpl.toLocaleString("en-US") +
                "" +
                currency +
                "</label></p>" +
                '<input type="hidden" id="adulto_precio" value="' +
                adulto_cpl +
                '">' +

                "</td>" +
                '<td style="background-color: white; color:black;">' +
                '<p class="text-center"><label>$ ' +
                menor_cpl.toLocaleString("en-US") +
                "" +
                currency +
                "</label></p>" +

                '<input type="hidden" id="menor_precio" value="' +
                menor_cpl +
                '">' +
                "</td>" +

                '<td style="background-color: white; color:black;">' +

                '<p class="text-center"><label>$ ' +
                infante_cpl.toLocaleString("en-US") +
                "" +
                currency +
                "</label></p>" +

                '<input type="hidden" id="infante_precio" value="' +
                infante_cpl +
                '">' +
                "</td>" +
                "</tr>";
        } else {
            var cpl =
                "<tr>" +
                '<th scope="col" style="background-color:#E3F2FD">' +
                habCuadruple +
                "</th>" +
                '<td style="background-color: white; color:black;">' +
                '<p class="text-center">$ <label>' +
                adulto_cpl.toLocaleString("en-US") +
                '' +
                currency +
                "</label></p>" +
                '<input type="hidden" id="adulto_precio" value="' +
                adulto_cpl +
                '">' +
                "</td>" +
                '<td style="background-color: white; color:black;">' +
                '<p class="text-center">$ <label>' +
                menor_cpl.toLocaleString("en-US") +
                '' +
                currency +
                "</label></p>" +
                '<input type="hidden" id="menor_precio" value="' +
                menor_cpl +
                '">' +
                "</td>" +
                '<td style="background-color: white; color:black;">' +
                '<p class="text-center">$ <label>' +
                infante_cpl.toLocaleString("en-US") +
                '' +
                currency +
                "</label></p>" +
                '<input type="hidden" id="infante_precio" value="' +
                infante_cpl +
                '">' +
                "</td>" +
                "</tr>";
        }
    } else {
        var cpl = "";
    }

    var foot = "</tbody>" + "</table>";

    var html = head + sgl + dbl + tpl + cpl + promocion + foot;
    $("#contieneprecios").html(html);
}

function mostrarPreciosCircuitosGrupal(select) {

    var id = $(select).val();

    var acepta_extras = $('#acepta_extras').val();
    var pax_max_extra = $('#pax_max_extra').val();
    var adulto_precio_extra = $('#adulto_precio_extra_' + id).val(); 
    var hoteleria = 0;

    let thTable;
    let thTableHab;
    if (hoteleria == 1) {
        thTable =
            hoteleria == 0
                ? ""
                : '<th scope="col" style="background-color:#E3F2FD"></th>';
        thTableHab =
            hoteleria == 0
                ? ""
                : '<th scope="col" style="background-color:#E3F2FD">' +
                habSencilla +
                "</th>";
    } else {
        thTableHab = '';
        thTable = '';
    }

    //Indicadores de promo
    var booking = parseInt($(select).find("option:selected").data("booking"));
    var travel = parseInt($(select).find("option:selected").data("travel"));

    var promo_nombre = $("#nombre_promo").val();
    var promo_descripcion = $("#descripcion").val();
    var paxes_promocion_cir = parseInt($("#paxes_promocion_cir").val()); //A partir de que numero de personas
    var travel_window_inicio = $("#travel_window_inicio").val();
    var travel_window_fin = $("#travel_window_fin").val();
    var tipo_descuento = parseInt($("#tipo_descuento_cir").val());
    var valor_promocion = parseInt($("#valor_promocion_cir").val()); //De cuanto es la promoción
    var aplica_descuento = parseInt($("#descuento_cir").val());

    var fecha_inicio = $("#fecha_inicio_" + id).val();
    var fecha_fin = $("#fecha_fin_" + id).val();
    var id_temporada = $("#id_temporada_" + id).val();
    var nombre_temporada = $("#nombre_temporada_" + id).val();
    var id_clase_servicio = $("#id_clase_servicio_" + id).val();
    var nombre_servicio = $("#nombre_servicio_" + id).val();

    $("#fechaInicioDeLaTemporada").val(fecha_inicio);
    $("#fechaFinDeLaTemporada").val(fecha_fin);

    var currency = $("#currency").val();

    //Precios sin promocion
    var adulto_sgl = parseFloat($("#adulto_sen_" + id).val()).toFixed(2);
    var menor_sgl = parseFloat($("#menor_sen_" + id).val()).toFixed(2);
    var infante_sgl = parseFloat($("#infante_sen_" + id).val()).toFixed(2);

    var costo_grupal = adulto_sgl;
    var costo_grupal_promo;

    if ((booking === 1 && travel === 1) && aplica_descuento === 1) {
        if (tipo_descuento === 2) {
            //Descuento por monto
            costo_grupal_promo = costo_grupal - valor_promocion;
        } else {
            //Descuento por porcentaje
            costo_grupal_promo =
                costo_grupal - costo_grupal * (valor_promocion / 100);
        }
    }

    var head =
        '<table class="table table-bordered text-center" style="margin-top: 15px;">' +
        "<thead>" +
        "<tr>" +
        thTable +
        '<th scope="col" style="background-color:#E3F2FD">COSTO GRUPAL</th>' +
        "</tr>" +
        "</thead>" +
        "<tbody>";

    if ((booking === 1 || travel === 1) && aplica_descuento === 1) {
        if (acepta_extras == 1) {

            var sgl =
                "<tr>" +
                thTableHab +
                '<td style="background-color: white; color:black;">' +
                '<p class="text-center"><label>$ ' +
                adulto_sgl.toLocaleString("en-US") +
                "" +
                currency +
                "</label></p>" +
                '<p class="text-center;" style="color:green"><label>' +
                'Costo por Persona Extra' +
                " " +
                "$" + adulto_precio_extra.toLocaleString("en-US") +
                "" +
                currency +
                "</label></p>" +
                '<input type="hidden" id="adulto_precio" value="' +
                adulto_sgl +
                '">' +
                "</td>" +
                "</tr>";


        } else {
            var sgl =
                "<tr>" +
                thTableHab +
                '<td style="background-color: white; color:black;">' +
                '<p class="text-center"><label class="text-decoration-line-through text-danger">$ ' +
                adulto_sgl.toLocaleString("en-US") +
                "" +
                currency +
                "</label></p>" +
                '<p class="text-center"><label>$ ' +
                costo_grupal_promo.toLocaleString("en-US") +
                "" +
                currency +
                "</label></p>" +
                '<input type="hidden" id="adulto_precio" value="' +
                adulto_sgl +
                '">' +
                "</td>" +
                "</tr>";
        }


        var promocion =
            "<tr>" +
            thTableHab +
            '<td style="background-color: white; color:black;">' +
            '<p class="text-center estilosPromoP">' +
            promo_nombre +
            '<br>' +
            promo_descripcion +
            "<br>" +
            "<b>" +
            "Promoción valida a partir de " +
            paxes_promocion_cir +
            " persona(s)" +
            "</b>" +
            "<br>";

        if (travel_window_inicio != null && travel_window_inicio != '') {
            '<span class="text-danger">' +
                "Viajando entre las fechas del " +
                travel_window_inicio +
                " al " +
                travel_window_fin +
                "</span>" +
                "</p>" +
                "</td>" +
                "</tr>";
        }
        
    } else {
        if (acepta_extras == 1) {
            var sgl =
                "<tr>" +
                thTableHab +
                '<td style="background-color: white; color:black;">' +
                '<p class="text-center"><label>$ ' +
                adulto_sgl.toLocaleString("en-US") +
                "" +
                currency +
                "</label></p>" +
                '<p class="text-center;" style="color:green"><label>' +
                'Costo por Persona Extra' +
                " " +
                "$" + adulto_precio_extra.toLocaleString("en-US") +
                "" +
                currency +
                "</label></p>" +
                '<input type="hidden" id="adulto_precio" value="' +
                adulto_sgl +
                '">' +
                "</td>" +
                "</tr>";
        } else {
            var sgl =
                "<tr>" +
                thTableHab +
                '<td style="background-color: white; color:black;">' +
                '<p class="text-center"><label>$ ' +
                adulto_sgl.toLocaleString("en-US") +
                "" +
                currency +
                "</td>" +
                "</tr>";
        }

        var promocion = "";
    }


    var foot = "</tbody>" + "</table>";

    var html = head + sgl + promocion + foot;
    console.log("Estoy en cargaPreciosCircuitos");
    $("#contieneprecios").html(html);
}

function preciosSelect() {
    var pAdulto = $("#adulto_precio").val();
    var pMenor = $("#menor_precio").val();
    var pInfante = $("#infante_precio").val();

    var aceptaInfantes = $("#aceptaInfantes").val();
    var aceptaMenores = $("#aceptaMenores").val();

    $("#priceAdulto").html("$" + pAdulto);
    $("#adultos").removeAttr("disabled");

    $("#priceMenor").html("$" + pMenor);
    if (parseInt(aceptaMenores) === 1) {
        $("#menores").removeAttr("disabled");
    }

    $("#priceInfante").html("$" + pInfante);
    if (parseInt(aceptaInfantes) === 1) {
        $("#infantes").removeAttr("disabled");
    }
}

function calculaPrecios() {
    console.log("Entraste a calculaPrecios")

    var currency = $("#currency").val();
    // var promo = 1;
    var mostrarpromo = $("#mostrarpromo").val();
    var fecha = $("#fecha_viaje_input").val();
    var total = 0;

    if (document.getElementById("paxes_promocion_cir")) {
        var paxes_min_promo = $("#paxes_promocion_cir").val();
    } else if(document.getElementById("paxes_promocion")){
        var paxes_min_promo = $("#paxes_promocion").val();
    }

    $("#resumenCompra").removeClass("d-none");
    var adultos = $("#adultos").val() > 0 ? $("#adultos").val() : 0;
    var menores = $("#menores").val() > 0 ? $("#menores").val() : 0;
    var infantes = $("#infantes").val() > 0 ? $("#infantes").val() : 0;

    var pAdulto = $("#adulto_precio").val();
    var pMenor = $("#menor_precio").val();
    var pInfante = $("#infante_precio").val();

    var ppAdulto = $("#adulto_precio_promo").val();
    var ppMenor = $("#menor_precio_promo").val();
    var ppInfante = $("#infante_precio_promo").val();

    var total_general_promo;

    var tAdultos = adultos * pAdulto;
    var tMenores = menores * pMenor;
    var tInfantes = infantes * pInfante;

    var tpAdultos = adultos * ppAdulto;
    var tpMenores = menores * ppMenor;
    var tpInfantes = infantes * ppInfante;

    var paxtotal = adultos;
    if (tMenores > 0) {
        paxtotal = parseInt(adultos) + parseInt(menores);
    }

    if (tInfantes > 0) {
        paxtotal = parseInt(adultos) + parseInt(menores) + parseInt(infantes);
    }

    if (fecha === "") {
        $("#total").html("Seleccione una fecha");
    } else {
        var total =
            parseFloat(tAdultos) + parseFloat(tMenores) + parseFloat(tInfantes);
        var totalFormat = total.toLocaleString("es-MX");

        var promototal =
            parseFloat(tpAdultos) +
            parseFloat(tpMenores) +
            parseFloat(tpInfantes);
        var promototalFormat = promototal.toLocaleString("es-MX");

        if (mostrarpromo == 1 && paxtotal >= paxes_min_promo) {
            var paxminimo = $("#paxes_promocion").val();
            paxtotal = parseInt(paxtotal);
            paxminimo = parseInt(paxminimo);
            if (paxtotal >= paxminimo) {
                console.log("PaxTotal es mayor o igual al maxMinimo");
                //Si se cumplen las condiciones
                var tipo_descuento = $("#tipo_descuento").val(); //1 Porcentaje, 2 Monto
                var valor_promocion = $("#valor_promocion").val();
                var totalPromo = total;

                if (tipo_descuento == 1) {
                    //Por porcentaje
                    var porcentajeDesc = (valor_promocion * total) / 100;
                    totalPromo = totalPromo - porcentajeDesc;
                    $(".subtotalAdulto").html(tAdultos.toLocaleString("es-MX"));
                    $(".subtotalMenor").html(tMenores.toLocaleString("es-MX"));
                    $(".subtotalInfante").html(
                        tInfantes.toLocaleString("es-MX")
                    );

                    $("#total").val(formatiarPrecioGrupal(totalPromo));
                    $("#resumenDescuentos").addClass("d-none");
                    $("#totalDummy").removeClass("d-none");
                    $("#aplicapromo").val(1);
                } else {
                    //Por monto
                    totalPromo = totalPromo - valor_promocion;
                    $(".subtotalAdulto").html(tAdultos.toLocaleString("es-MX"));
                    $(".subtotalMenor").html(tMenores.toLocaleString("es-MX"));
                    $(".subtotalInfante").html(
                        tInfantes.toLocaleString("es-MX")
                    );

                    $("#total").val(formatiarPrecioGrupal(totalPromo));
                    $("#resumenDescuentos").addClass("d-none");
                    $("#totalDummy").removeClass("d-none");
                    $("#aplicapromo").val(1);
                }
            } else {
                $(".subtotalAdulto").html(tAdultos.toLocaleString("es-MX"));
                $(".subtotalMenor").html(tMenores.toLocaleString("es-MX"));
                $(".subtotalInfante").html(tInfantes.toLocaleString("es-MX"));

                $("#total").val(totalFormat);
                $("#resumenDescuentos").addClass("d-none");
                $("#aplicapromo").val(1);
            }
        } else {
            $(".subtotalAdulto").html(tAdultos.toLocaleString("es-MX"));
            $(".subtotalMenor").html(tMenores.toLocaleString("es-MX"));
            $(".subtotalInfante").html(tInfantes.toLocaleString("es-MX"));
            $("#total").val(totalFormat);
            $("#resumenDescuentos").addClass("d-none");
            $("#totalDummy").addClass("d-none");
            $("#aplicapromo").val(0);
        }
    }

    //Resumen de compra
    // $("#txtAdultos").html(adultos);
    // $("#txtMenores").html(menores);
    // $("#txtInfantes").html(infantes);



    //Llenamos el formulario
    $("#cadultos").val(adultos);
    $("#cmenores").val(menores);
    $("#cinfantes").val(infantes);
    $("#padulto").val(pAdulto);
    $("#pmenor").val(pMenor);
    $("#pinfante").val(pInfante);
    $("#gtotal").val(total);
    $("#gtotalPromo").val(totalPromo);
    $("#totalDummy").val("$" + total + currency);
}

function calculaPreciosGrupal() {
    
    var currency = $("#currency").val();
    var promo = $("#mostrarpromo").val();
    var fecha = $("#fecha_viaje_input").val();
    var costoGrupal = parseInt(0);
    let costoMenorDefault = 0;
    var acepta_extras = $("#acepta_extras").val();
    var tipo_ind_comb = $("#tipo_ind_comb").val();
    var pax_max_extra = $("#pax_max_extra").val();
    var pax_limite = $("#cant_pax_max").val();

    $("#resumenCompra").removeClass("d-none");
    var adultos = $("#adultos").val() > 0 ? $("#adultos").val() : 0;
    var menores = $("#menores").val() > 0 ? $("#menores").val() : 0;
    var infantes = $("#infantes").val() > 0 ? $("#infantes").val() : 0;

    var pAdulto = parseInt($("#adulto_precio").val());

    //String*string problem
    var pMenor = parseInt($("#menor_precio").val());
    var pInfante = parseInt($("#infante_precio").val());
    if (isNaN(pMenor)) {
        pMenor = 0;
    }
    if (isNaN(pInfante)) {
        pInfante = 0;
    }

    costoGrupal = parseInt(pAdulto);
    let costoGrupalPromo;

    //Costos extras
    var pAdultoExtra = $('#adulto_precio_extra_' + id).val();
    var pMenorExtra = $("#menor_precio_extra").val();
    var pInfanteExtra = $("#infante_precio_extra").val();

    var precioTotalGrupal = 0;

    // Inicializar el total de pasajeros
    var totalPax = 0;

    // Verificar y sumar adultos
    if (adultos > 0) {
        totalPax += parseInt(adultos);
    }

    // Verificar y sumar menores
    if (menores > 0) {
        totalPax += parseInt(menores);

    }

    // Verificar y sumar infantes
    if (infantes > 0) {
        totalPax += parseInt(infantes);
    }

    // Calcular la cantidad de pasajeros extras
    var pasajerosExtras = totalPax - pax_limite;


    if (acepta_extras == 1) {
        if (totalPax > pax_limite) {
            precioTotalGrupal = parseInt(costoGrupal) + (parseInt(pAdultoExtra) * parseInt(pasajerosExtras));
            costoGrupal = parseInt(precioTotalGrupal);
        }
    }



    console.log("Total Pasajeros: " + totalPax);
    console.log("Total Pasajeros Extra: " + pasajerosExtras);
    console.log("Total Precio Grupal: " + precioTotalGrupal);

    if (fecha === "") {
        $("#total").html("Seleccione una fecha");
    } else {
        // var totalFormat = costoGrupal.toLocaleString('es-MX')

        // var promototal = parseFloat(precioTotalGrupal);
        // var promototalFormat = promototal.toLocaleString('es-MX')

        if (promo == 1) {
            costoGrupalPromo = costoGrupal;
            var paxminimo = $("#paxes_promocion").val();
            if (totalPax >= paxminimo) {
                var tipo_descuento = $("#tipo_descuento").val(); //1 Porcentaje, 2 Monto
                var valor_promocion = $("#valor_promocion").val();

                if (tipo_descuento == 1) {
                    // Si es por porcentaje
                    porcentajeDesc = (valor_promocion * costoGrupalPromo) / 100;
                    costoGrupalPromo = costoGrupalPromo - porcentajeDesc;
                    $(".subtotalAdulto").html(
                        formatiarPrecioGrupal(costoGrupalPromo)
                    );
                    $(".subtotalMenor").html(formatiarPrecioGrupal(0));
                    $(".subtotalInfante").html(formatiarPrecioGrupal(0));

                    $("#total").val(formatiarPrecioGrupal(costoGrupalPromo));
                    $("#resumenDescuentos").addClass("d-none");
                    $("#totalDummy").removeClass("d-none");
                    $("#aplicapromo").val(1);
                } else {
                    //Si es por monto
                    costoGrupalPromo = costoGrupalPromo - valor_promocion;
                    $(".subtotalAdulto").html(
                        formatiarPrecioGrupal(costoGrupalPromo)
                    );
                    $(".subtotalMenor").html(formatiarPrecioGrupal(0));
                    $(".subtotalInfante").html(formatiarPrecioGrupal(0));

                    $("#total").val(formatiarPrecioGrupal(costoGrupalPromo));
                    $("#resumenDescuentos").addClass("d-none");
                    $("#totalDummy").removeClass("d-none");
                    $("#aplicapromo").val(1);
                }
            } else {
                $("#totalDummy").addClass("d-none");
                $(".subtotalAdulto").html(
                    formatiarPrecioGrupal(costoGrupalPromo)
                );
                $(".subtotalMenor").html(formatiarPrecioGrupal(0));
                $(".subtotalInfante").html(formatiarPrecioGrupal(0));

                $("#total").val(formatiarPrecioGrupal(costoGrupal));
                $("#resumenDescuentos").addClass("d-none");
                $("#aplicapromo").val(0);
            }
        } else {
            $(".subtotalAdulto").html(formatiarPrecioGrupal(costoGrupal));
            $(".subtotalMenor").html(formatiarPrecioGrupal(0));
            $(".subtotalInfante").html(formatiarPrecioGrupal(0));

            $("#total").val(formatiarPrecioGrupal(costoGrupal));
            $("#resumenDescuentos").addClass("d-none");
            $("#aplicapromo").val(0);
        }
    }

    var totalDummy = '$' + costoGrupal + currency;
    //Llenamos el formulario
    $("#cadultos").val(adultos);
    $("#cmenores").val(menores);
    $("#cinfantes").val(infantes);
    $("#padulto").val(precioTotalGrupal);
    $("#pmenor").val(pMenor);
    $("#pinfante").val(pInfante);
    $("#gtotal").val(costoGrupal); //costoGrupal
    $("#gtotalPromo").val(costoGrupalPromo); //costoGrupalPromo
    $("#totalDummy").val(totalDummy);

}

function formatiarPrecioGrupal(precio) {
    let precioFormatiado = precio.toLocaleString("es-MX");
    return precioFormatiado;
}

function calculaPreciosCircuito() {
    console.log("Funcion calculaPreciosCircuito")


    var currency = $("#currency").val();
    var fecha = $("#fecha_viaje").val();
    var hab = $("#tip_habitacion_1").val();
    var tipo_reserva = $("#tipo_reserva_hotelera").val();

    // Cambios pedrito travel-cit
    const adultos = document.querySelector("#adultos");
    const menores = document.querySelector("#menores");
    let adultosvalue = adultos.value;
    let menoresvalue = menores.value;
    if (tipo_reserva == "0") {
        console.log("El tipo de reserva es individual");
        if (hab === "sen") {
            adultos.innerHTML = "";
            menores.innerHTML = "";
            adultosvalue = adultosvalue <= 1 ? adultosvalue : 1;
            menoresvalue = menoresvalue <= 2 ? menoresvalue : 2;

            adultos.add(new Option("0"));
            adultos.add(new Option("1"));
            menores.add(new Option("0"));
            menores.add(new Option("1"));
            menores.add(new Option("2"));
        }
        if (hab === "dbl") {
            adultos.innerHTML = "";
            menores.innerHTML = "";
            adultosvalue = adultosvalue <= 2 ? adultosvalue : 2;
            menoresvalue = menoresvalue <= 2 ? menoresvalue : 2;

            adultos.add(new Option("0"));
            adultos.add(new Option("2"));
            menores.add(new Option("0"));
            menores.add(new Option("1"));
            menores.add(new Option("2"));
        }
        if (hab === "tpl") {
            adultos.innerHTML = "";
            menores.innerHTML = "";
            adultosvalue = adultosvalue <= 3 ? adultosvalue : 3;
            menoresvalue = menoresvalue <= 1 ? menoresvalue : 1;

            adultos.add(new Option("0"));
            adultos.add(new Option("3"));
            menores.add(new Option("0"));
            menores.add(new Option("1"));
        }
        if (hab === "cpl") {
            adultos.innerHTML = "";
            menores.innerHTML = "";
            adultosvalue = adultosvalue <= 4 ? adultosvalue : 4;
            menoresvalue = menoresvalue <= 0 ? menoresvalue : 0;

            adultos.add(new Option("0"));
            adultos.add(new Option("4"));
            menores.add(new Option("0"));
        }
    } else if (tipo_reserva == "1") {
        if (hab === "sen") {
            adultos.innerHTML = "";
            menores.innerHTML = "";
            adultosvalue = adultosvalue <= 1 ? adultosvalue : 1;
            menoresvalue = menoresvalue <= 2 ? menoresvalue : 2;

            adultos.add(new Option("0"));
            adultos.add(new Option("1"));
            menores.add(new Option("0"));
            menores.add(new Option("1"));
            menores.add(new Option("2"));
        }
        if (hab === "dbl") {
            adultos.innerHTML = "";
            menores.innerHTML = "";
            adultosvalue = adultosvalue <= 2 ? adultosvalue : 2;
            menoresvalue = menoresvalue <= 2 ? menoresvalue : 2;

            adultos.add(new Option("0"));
            adultos.add(new Option("1"));
            adultos.add(new Option("2"));
            menores.add(new Option("0"));
            menores.add(new Option("1"));
            menores.add(new Option("2"));
        }
        if (hab === "tpl") {
            adultos.innerHTML = "";
            menores.innerHTML = "";
            adultosvalue = adultosvalue <= 3 ? adultosvalue : 3;
            menoresvalue = menoresvalue <= 1 ? menoresvalue : 1;

            adultos.add(new Option("0"));
            adultos.add(new Option("1"));
            adultos.add(new Option("2"));
            adultos.add(new Option("3"));
            menores.add(new Option("0"));
            menores.add(new Option("1"));
        }
        if (hab === "cpl") {
            adultos.innerHTML = "";
            menores.innerHTML = "";
            adultosvalue = adultosvalue <= 4 ? adultosvalue : 4;
            menoresvalue = menoresvalue <= 0 ? menoresvalue : 0;

            adultos.add(new Option("0"));
            adultos.add(new Option("1"));
            adultos.add(new Option("2"));
            adultos.add(new Option("3"));
            adultos.add(new Option("4"));
            menores.add(new Option("0"));
        }
    } else {
        return "";
    }
    adultos.value = adultosvalue;
    menores.value = menoresvalue;

    var hoteleria = $("#hoteleria").val();
    hab = hoteleria == 0 ? "sen" : hab;

    //Datos del servicio seleccionado
    var fecha_inicio = $("#fecha_inicio_" + fecha).val();
    var fecha_fin = $("#fecha_fin_" + fecha).val();
    var id_temporada = $("#id_temporada_" + fecha).val();
    var nombre_temporada = $("#nombre_temporada_" + fecha).val();
    var id_clase_servicio = $("#id_clase_servicio_" + fecha).val();
    var nombre_servicio = $("#nombre_servicio_" + fecha).val();
    var id_temporada_costo = $("#id_temporada_costo_" + fecha).val();

    var id = $("#fecha_viaje").val();

    //Indicadores de promo
    var booking = parseInt(
        $("#fecha_viaje").find("option:selected").data("booking")
    );
    var travel = parseInt(
        $("#fecha_viaje").find("option:selected").data("travel")
    );

    var tipo_descuento = parseInt($("#tipo_descuento_cir").val());
    var valor_promocion = parseInt($("#valor_promocion_cir").val());
    var aplica_descuento = parseInt($("#descuento_cir").val());
    var paxes_promocion_cir = parseInt($("#paxes_promocion_cir").val());

    var fecha_inicio = $("#fecha_inicio_" + id).val();
    var fecha_fin = $("#fecha_fin_" + id).val();
    var id_temporada = $("#id_temporada_" + id).val();
    var nombre_temporada = $("#nombre_temporada_" + id).val();
    var id_clase_servicio = $("#id_clase_servicio_" + id).val();
    var nombre_servicio = $("#nombre_servicio_" + id).val();

    //Precios sin promocion
    var adulto_sgl = parseFloat($("#adulto_sen_" + id).val()).toFixed(2);
    var adulto_dbl = parseFloat($("#adulto_dbl_" + id).val()).toFixed(2);
    var adulto_tpl = parseFloat($("#adulto_tpl_" + id).val()).toFixed(2);
    var adulto_cpl = parseFloat($("#adulto_cpl_" + id).val()).toFixed(2);

    var menor_sgl = parseFloat($("#menor_sen_" + id).val()).toFixed(2);
    var menor_dbl = parseFloat($("#menor_dbl_" + id).val()).toFixed(2);
    var menor_tpl = parseFloat($("#menor_tpl_" + id).val()).toFixed(2);
    var menor_cpl = parseFloat($("#menor_cpl_" + id).val()).toFixed(2);

    var infante_sgl = parseFloat($("#infante_sen_" + id).val()).toFixed(2);
    var infante_dbl = parseFloat($("#infante_dbl_" + id).val()).toFixed(2);
    var infante_tpl = parseFloat($("#infante_tpl_" + id).val()).toFixed(2);
    var infante_cpl = parseFloat($("#infante_cpl_" + id).val()).toFixed(2);

    //Precios con promocion
    if (tipo_descuento === 2) {
        //Descuento por monto
        var adulto_sen_promo = adulto_sgl - valor_promocion;
        var adulto_dbl_promo = adulto_dbl - valor_promocion;
        var adulto_tpl_promo = adulto_tpl - valor_promocion;
        var adulto_cpl_promo = adulto_cpl - valor_promocion;

        var menor_sen_promo = menor_sgl - valor_promocion;
        var menor_dbl_promo = menor_dbl - valor_promocion;
        var menor_tpl_promo = menor_tpl - valor_promocion;
        var menor_cpl_promo = menor_cpl - valor_promocion;

        var infante_sen_promo = infante_sgl - valor_promocion;
        var infante_dbl_promo = infante_dbl - valor_promocion;
        var infante_tpl_promo = infante_tpl - valor_promocion;
        var infante_cpl_promo = infante_cpl - valor_promocion;
    } else {
        //Descuento por porcentaje
        var adulto_sen_promo =
            adulto_sgl - adulto_sgl * (valor_promocion / 100);
        var adulto_dbl_promo =
            adulto_dbl - adulto_dbl * (valor_promocion / 100);
        var adulto_tpl_promo =
            adulto_tpl - adulto_tpl * (valor_promocion / 100);
        var adulto_cpl_promo =
            adulto_cpl - adulto_cpl * (valor_promocion / 100);

        var menor_sen_promo = menor_sgl - menor_sgl * (valor_promocion / 100);
        var menor_dbl_promo = menor_dbl - menor_dbl * (valor_promocion / 100);
        var menor_tpl_promo = menor_tpl - menor_tpl * (valor_promocion / 100);
        var menor_cpl_promo = menor_cpl - menor_cpl * (valor_promocion / 100);
        // console.log("pmenor: "+menor_sgl+" - promo: "+menor_sgl_promo);

        var infante_sen_promo =
            infante_sgl - infante_sgl * (valor_promocion / 100);
        var infante_dbl_promo =
            infante_dbl - infante_dbl * (valor_promocion / 100);
        var infante_tpl_promo =
            infante_tpl - infante_tpl * (valor_promocion / 100);
        var infante_cpl_promo =
            infante_cpl - infante_cpl * (valor_promocion / 100);
    }

    //Cantidad de paxs
    var cadultos = $("#adultos").val() > 0 ? parseInt($("#adultos").val()) : 0;
    var cmenores = $("#menores").val() > 0 ? parseInt($("#menores").val()) : 0;
    var cinfantes =
        $("#infantes").val() > 0 ? parseInt($("#infantes").val()) : 0;

    //Cantidad total de pax
    var paxs = cadultos + cmenores + cinfantes;

    if (
        (booking === 1 && travel === 1) &&
        aplica_descuento === 1 &&
        paxs >= paxes_promocion_cir
    ) {

        $("#totalDummy").removeClass("d-none");
        $("#aplicapromo").val(1);


        //Aplicamos precios promocion
        //Precios de cada pax
        var padulto = parseFloat(
            $("#adulto_" + hab + "_" + fecha).val()
        ).toFixed(2);
        var pmenor = parseFloat($("#menor_" + hab + "_" + fecha).val()).toFixed(
            2
        );
        var pinfante = parseFloat(
            $("#infante_" + hab + "_" + fecha).val()
        ).toFixed(2);

        var totalNoPromo = parseInt(padulto) + parseFloat(pmenor) + parseFloat(pinfante);

        $("#totalDummy").val("$" + totalNoPromo + currency);

        if (tipo_descuento === 2) {
            //Descuento por monto
            padulto = padulto - valor_promocion;
            pmenor = pmenor - valor_promocion;
            pinfante = pinfante - valor_promocion;
        } else {
            //Descuento por porcentaje
            padulto = padulto - padulto * (valor_promocion / 100);
            pmenor = pmenor - pmenor * (valor_promocion / 100);
            pinfante = pinfante - pinfante * (valor_promocion / 100);
        }

        //Totales por cada tipo de pax
        var tadultos = cadultos * padulto;
        var tmenores = cmenores * pmenor;
        var tinfantes = cinfantes * pinfante;

        var grantotal = tadultos + tmenores + tinfantes;

        var granTotalPromo = grantotal;
    } else {
        //Precios normales
        $("#totalDummy").addClass("d-none");
        $("#aplicapromo").val(0);

        //Precios de cada pax
        var padulto = parseFloat(
            $("#adulto_" + hab + "_" + fecha).val()
        ).toFixed(2);
        var pmenor = parseFloat($("#menor_" + hab + "_" + fecha).val()).toFixed(
            2
        );
        var pinfante = parseFloat(
            $("#infante_" + hab + "_" + fecha).val()
        ).toFixed(2);

        //Totales por cada tipo de pax
        var tadultos = cadultos * padulto;
        var tmenores = cmenores * pmenor;
        var tinfantes = cinfantes * pinfante;

        var grantotal = tadultos + tmenores + tinfantes;
    }

    $("#precio_adulto").html(padulto.toLocaleString("en-US"));
    $("#precio_menor").html(pmenor.toLocaleString("en-US"));
    $("#precio_infante").html(pinfante.toLocaleString("en-US"));

    //Se llena formulario para reservacion
    $("#id_temporada").val(id_temporada);
    $("#nombre_temporada").val(nombre_temporada);
    $("#id_clase_servicio").val(id_clase_servicio);
    $("#nombre_servicio").val(nombre_servicio);
    $("#fecha_inicio").val(fecha_inicio);
    $("#fecha_fin").val(fecha_fin);
    $("#id_paquete_fecha").val(fecha);
    $("#id_temporada_costo").val(id_temporada_costo);

    $("#cadultos").val(cadultos);
    $("#cmenores").val(cmenores);
    $("#cinfantes").val(cinfantes);
    $("#padulto").val(padulto);
    $("#pmenor").val(pmenor);
    $("#pinfante").val(pinfante);
    $("#gtotal").val(grantotal);
    $("#gtotalPromo").val(granTotalPromo);

    $("#adultos").removeAttr("disabled");

    if (parseInt($("#aceptaMenores").val()) === 1) {
        $("#menores").removeAttr("disabled");
    }

    if (parseInt($("#aceptaInfantes").val()) === 1) {
        $("#infantes").removeAttr("disabled");
    }

    tadultos = isNaN(tadultos) ? 0 : tadultos;
    tmenores = isNaN(tmenores) ? 0 : tmenores;
    tinfantes = isNaN(tinfantes) ? 0 : tinfantes;
    grantotal = isNaN(grantotal) ? 0 : grantotal;

    $(".subtotalAdulto").html(tadultos.toLocaleString("es-MX"));
    $(".subtotalMenor").html(tmenores.toLocaleString("es-MX"));
    $(".subtotalInfante").html(tinfantes.toLocaleString("es-MX"));
    $("#total").val(grantotal.toLocaleString("en-US"));
}

function calculaPreciosIndividual() {


    //Limpiar completamente esta funcion, mucho codigo muerto
    var fecha = $("#fecha_viaje").val();
    var hab = $("#tip_habitacion_1").val();
    var tipo_reserva = $("#tipo_reserva_hotelera").val();

    // Cambios pedrito travel-cit
    const adultos = document.querySelector("#adultos");
    const menores = document.querySelector("#menores");
    let adultosvalue = adultos.value;
    let menoresvalue = menores.value;

    adultos.value = adultosvalue;
    menores.value = menoresvalue;

    //Datos del servicio seleccionado
    var fecha_inicio = $("#fecha_inicio_" + fecha).val();
    var fecha_fin = $("#fecha_fin_" + fecha).val();
    var id_temporada = $("#id_temporada_" + fecha).val();
    var nombre_temporada = $("#nombre_temporada_" + fecha).val();
    var id_clase_servicio = $("#id_clase_servicio_" + fecha).val();
    var nombre_servicio = $("#nombre_servicio_" + fecha).val();
    var id_temporada_costo = $("#id_temporada_costo_" + fecha).val();

    var id = $("#fecha_viaje").val();

    //Indicadores de promo
    var booking = parseInt(
        $("#fecha_viaje").find("option:selected").data("booking")
    );
    var travel = parseInt(
        $("#fecha_viaje").find("option:selected").data("travel")
    );

    var tipo_descuento = parseInt($("#tipo_descuento_cir").val());
    var valor_promocion = parseInt($("#valor_promocion_cir").val());
    var aplica_descuento = parseInt($("#descuento_cir").val());
    var paxes_promocion_cir = parseInt($("#paxes_promocion_cir").val());

    var fecha_inicio = $("#fecha_inicio_" + id).val();
    var fecha_fin = $("#fecha_fin_" + id).val();
    var id_temporada = $("#id_temporada_" + id).val();
    var nombre_temporada = $("#nombre_temporada_" + id).val();
    var id_clase_servicio = $("#id_clase_servicio_" + id).val();
    var nombre_servicio = $("#nombre_servicio_" + id).val();

    //Precios sin promocion
    var adulto_sgl = parseFloat($("#adulto_sen_" + id).val()).toFixed(2);
    var menor_sgl = parseFloat($("#menor_sen_" + id).val()).toFixed(2);
    var infante_sgl = parseFloat($("#infante_sen_" + id).val()).toFixed(2);

    var costo_total = adulto_sgl + menor_sgl + infante_sgl;
    costo_total = parseInt(costo_total);

    //Cantidad de paxs
    var cadultos = $("#adultos").val() > 0 ? parseInt($("#adultos").val()) : 0;
    var cmenores = $("#menores").val() > 0 ? parseInt($("#menores").val()) : 0;
    var cinfantes =
        $("#infantes").val() > 0 ? parseInt($("#infantes").val()) : 0;

    //Cantidad total de pax
    var paxs = cadultos + cmenores + cinfantes;

    //Precios de cada pax
    var padulto = adulto_sgl;
    var pmenor = menor_sgl;
    var pinfante = infante_sgl;

    //Totales por cada tipo de pax
    var tadultos = cadultos * padulto;
    var tmenores = cmenores * pmenor;
    var tinfantes = cinfantes * pinfante;

    var grantotal = tadultos + tmenores + tinfantes;

    if (
        (booking === 1 || travel === 1) &&
        aplica_descuento === 1 &&
        paxs >= paxes_promocion_cir
    ) {
        //Aplicamos precios promocion

        if (tipo_descuento === 2) {
            //Descuento por monto
            grantotal = grantotal - valor_promocion;
        } else {
            //Descuento por porcentaje
            porcentajeDesc = (valor_promocion * grantotal) / 100;
            grantotal = grantotal - porcentajeDesc;
        }

        $("#aplicapromo").val(1);
    } else {
        $("#aplicapromo").val(0);
    }

    $("#precio_adulto").html(padulto.toLocaleString("en-US"));
    $("#precio_menor").html(pmenor.toLocaleString("en-US"));
    $("#precio_infante").html(pinfante.toLocaleString("en-US"));

    //Se llena formulario para reservacion
    $("#id_temporada").val(id_temporada);
    $("#nombre_temporada").val(nombre_temporada);
    $("#id_clase_servicio").val(id_clase_servicio);
    $("#nombre_servicio").val(nombre_servicio);
    $("#fecha_inicio").val(fecha_inicio);
    $("#fecha_fin").val(fecha_fin);
    $("#id_paquete_fecha").val(fecha);
    $("#id_temporada_costo").val(id_temporada_costo);

    $("#cadultos").val(cadultos);
    $("#cmenores").val(cmenores);
    $("#cinfantes").val(cinfantes);
    $("#padulto").val(padulto);
    $("#pmenor").val(pmenor);
    $("#pinfante").val(pinfante);
    $("#gtotal").val(grantotal);

    $("#adultos").removeAttr("disabled");

    if (parseInt($("#aceptaMenores").val()) === 1) {
        $("#menores").removeAttr("disabled");
    }

    if (parseInt($("#aceptaInfantes").val()) === 1) {
        $("#infantes").removeAttr("disabled");
    }

    tadultos = isNaN(tadultos) ? 0 : tadultos;
    tmenores = isNaN(tmenores) ? 0 : tmenores;
    tinfantes = isNaN(tinfantes) ? 0 : tinfantes;
    grantotal = isNaN(grantotal) ? 0 : grantotal;

    $(".subtotalAdulto").html(tadultos.toLocaleString("es-MX"));
    $(".subtotalMenor").html(tmenores.toLocaleString("es-MX"));
    $(".subtotalInfante").html(tinfantes.toLocaleString("es-MX"));
    $("#total").val(grantotal.toLocaleString("en-US"));
    $("#gtotalPromo").val(grantotal);
}

function calculaPreciosCircuitoGrupal() {
    console.log("Estoy en calcula Precios Circuito Grupal");


    var fecha = $("#fecha_viaje").val();
    var hab = $("#tip_habitacion_1").val();
    var tipo_reserva = $("#tipo_reserva_hotelera").val();
    

    var acepta_extras = $("#acepta_extras").val();
    var tipo_ind_comb = $("#tipo_ind_comb").val();
    var pax_max_extra = $("#pax_max_extra").val();
    var pax_limite = $("#cant_pax_max").val();
    var pAdultoExtra = $('#adulto_precio_extra_' + fecha).val();

    // Cambios pedrito travel-cit
    const adultos = document.querySelector("#adultos");
    const menores = document.querySelector("#menores");
    let adultosvalue = adultos.value;
    let menoresvalue = menores.value;

    adultos.value = adultosvalue;
    menores.value = menoresvalue;

    var hoteleria = $("#hoteleria").val();
    hab = hoteleria == 0 ? "sen" : hab;

    //Datos del servicio seleccionado
    var fecha_inicio = $("#fecha_inicio_" + fecha).val();
    var fecha_fin = $("#fecha_fin_" + fecha).val();
    var id_temporada = $("#id_temporada_" + fecha).val();
    var nombre_temporada = $("#nombre_temporada_" + fecha).val();
    var id_clase_servicio = $("#id_clase_servicio_" + fecha).val();
    var nombre_servicio = $("#nombre_servicio_" + fecha).val();
    var id_temporada_costo = $("#id_temporada_costo_" + fecha).val();

    var id = $("#fecha_viaje").val();

    //Indicadores de promo
    var booking = parseInt(
        $("#fecha_viaje").find("option:selected").data("booking")
    );
    var travel = parseInt(
        $("#fecha_viaje").find("option:selected").data("travel")
    );

    var tipo_descuento = parseInt($("#tipo_descuento_cir").val());
    var valor_promocion = parseInt($("#valor_promocion_cir").val());
    var aplica_descuento = parseInt($("#descuento_cir").val());
    var paxes_promocion_cir = parseInt($("#paxes_promocion_cir").val());

    var fecha_inicio = $("#fecha_inicio_" + id).val();
    var fecha_fin = $("#fecha_fin_" + id).val();
    var id_temporada = $("#id_temporada_" + id).val();
    var nombre_temporada = $("#nombre_temporada_" + id).val();
    var id_clase_servicio = $("#id_clase_servicio_" + id).val();
    var nombre_servicio = $("#nombre_servicio_" + id).val();

    //Precios sin promocion
    var adulto_sgl = parseFloat($("#adulto_sen_" + id).val()).toFixed(2);
    var pmenor = parseFloat($("#menor_sen_" + id).val()).toFixed(2);
    var pinfante = parseFloat($("#infante_sen_" + id).val()).toFixed(2);
    var costo_grupal = adulto_sgl;

    var costo_grupal_promocion;

    //Cantidad de paxs
    var cadultos = $("#adultos").val() > 0 ? parseInt($("#adultos").val()) : 0;
    var cmenores = $("#menores").val() > 0 ? parseInt($("#menores").val()) : 0;
    var cinfantes =
        $("#infantes").val() > 0 ? parseInt($("#infantes").val()) : 0;

    //Cantidad total de pax
    var paxs = cadultos + cmenores + cinfantes;


    //En este bloque de código se necesita que llegue el costo adulto extra
    var pasajerosExtras = paxs - pax_limite;
    if (acepta_extras == 1) {
        if (paxs > pax_limite) {
            let precioTotalGrupal = parseInt(costo_grupal) + (parseInt(pAdultoExtra) * parseInt(pasajerosExtras));
            costo_grupal = parseInt(precioTotalGrupal);
        }
    }

    //Precios con promocion
    if (tipo_descuento === 2) {
        //Descuento por monto
        costo_grupal_promocion = costo_grupal - valor_promocion;
    } else {
        //Descuento por porcentaje
        porcentajeDesc = (valor_promocion * costo_grupal) / 100;
        costo_grupal_promocion = costo_grupal - porcentajeDesc;
    }

    if (
        (booking === 1 || travel === 1) &&
        aplica_descuento === 1 &&
        paxs >= paxes_promocion_cir
    ) {
        //Puede aplicarse promocion
        $("#gtotalPromo").val(costo_grupal_promocion);
        $("#total").val(costo_grupal_promocion.toLocaleString("en-US"));
    }else{
        $("#gtotal").val(costo_grupal);
        $("#total").val(costo_grupal.toLocaleString("en-US"));
        $("#gtotalPromo").val(null);
    }

    $("#precio_adulto").html(padulto.toLocaleString("en-US"));

    //Se llena formulario para reservacion
    $("#id_temporada").val(id_temporada);
    $("#nombre_temporada").val(nombre_temporada);
    $("#id_clase_servicio").val(id_clase_servicio);
    $("#nombre_servicio").val(nombre_servicio);
    $("#fecha_inicio").val(fecha_inicio);
    $("#fecha_fin").val(fecha_fin);
    $("#id_paquete_fecha").val(fecha);
    $("#id_temporada_costo").val(id_temporada_costo);

    $("#cadultos").val(cadultos);
    $("#cmenores").val(cmenores);
    $("#cinfantes").val(cinfantes);
    $("#padulto").val(costo_grupal);
    $("#pmenor").val(pmenor);
    $("#pinfante").val(pinfante);
    $("#aplicapromo").val(aplica_descuento);

    $("#adultos").removeAttr("disabled");

    if (parseInt($("#aceptaMenores").val()) === 1) {
        $("#menores").removeAttr("disabled");
    }

    if (parseInt($("#aceptaInfantes").val()) === 1) {
        $("#infantes").removeAttr("disabled");
    }

    $(".subtotalAdulto").html(costo_grupal.toLocaleString("es-MX"));
    // $(".subtotalMenor").html(tmenores.toLocaleString("es-MX"));
    // $(".subtotalInfante").html(tinfantes.toLocaleString("es-MX"));
}

function sendFormCompra() {
    $("#btnPagarSend").click();
}

function menoresEdades(menores) {
    for (i = 1; i <= 4; i++) {
        if (i <= menores) {
            $("#edad_" + i).show();
        } else {
            $("#edad_" + i).hide();
        }
    }
}

function menoresEdadesForm(menores) {
    e = 0;
    for (i = 1; i <= 30; i++) {
        if (i <= menores) {
            $("#edad_" + i).show();
        } else {
            $("#edad_" + i).hide();
            $("#edad_" + i + " select option[value='0']").attr(
                "selected",
                true
            );
        }
    }
}

function mostrarHospedaje(confirmacion) {
    if (parseInt(confirmacion) === 1) {
        $("#numeroHabs").show();
        var habs = $("#numeroHabitaciones").val();
        muestraHabs(habs);
    } else {
        $("#numeroHabs").hide();
        $(".habitaciones").hide();
    }
}

function muestraHabs(habs) {
    e = 0;
    for (i = 1; i <= 30; i++) {
        if (i <= habs) {
            $("#hab_" + i).show();
        } else {
            $("#hab_" + i).hide();
            $("#hab_" + i + " select option[value='0']").attr("selected", true);
        }
    }
}

function mostrarDiv(id, valorConfirma, seleccion) {
    if (parseInt(seleccion) === parseInt(valorConfirma)) {
        $("#" + id).show();
    } else {
        $("#" + id).hide();
    }
}

function getLinkPay() {

    if (document.forms.frmCompra.checkValidity() == false) {
        document.forms.frmCompra.reportValidity();
        return;
    }
    $("#btnPagar")
        .val("Procesando, por favor espera...")
        .attr("disabled", "disabled");
    var id = $("#openpayID").val();
    var nombre = $("#nombreTitular").val();
    var apellido = $("#apellidoTitular").val();
    var telefono = $("#telefonoTitular").val();
    var descripcion = "Paquete de viaje a :" + $("#nombretour").val();
    var email = $("#email").val();
    var aplicapromo = $("#aplicapromo").val();

    if (parseInt(aplicapromo) === 1) {
        //Precio con promocion
        var total = $("#gtotalPromo").val();
    } else {
        var total = $("#gtotal").val();
    }

    if (nombre != "" && apellido != "" && telefono != "" && email != "") {
        if (id === "") {
            $.ajax({
                data: {
                    nombre: nombre,
                    apellido: apellido,
                    telefono: telefono,
                    descripcion: descripcion,
                    total: total,
                    email: email,
                },
                type: "GET",
                dataType: "json",
                url: "getLinkOpenpay",
            })
                .done(function (response) {
                    $("#openpayID").val(response.openpayID);
                    $("#openpayLINK").val(response.openpayLINK);
                    sendFormCompra(); //envio
                })
                .fail(function () { });
        } else {
            sendFormCompra();
        }
    } else {
        sendFormCompra();
    }
}

function getLinkPayCivitatis() {
    if (document.forms.frmCompra.checkValidity() == false) {
        document.forms.frmCompra.reportValidity();
        return;
    }
    $("#btnPagar")
        .val("Procesando, por favor espera...")
        .attr("disabled", "disabled");
    var id = $("#openpayID").val();
    var nombre = $("#nombreTitular").val();
    var apellido = $("#apellidoTitular").val();
    var telefono = $("#telefonoTitular").val();
    var descripcion = "Paquete de viaje a :" + $("#nombretour").val();
    var email = $("#email").val();
    var total = $("#gtotal").val();

    if (nombre != "" && apellido != "" && telefono != "" && email != "") {
        if (id === "") {
            $.ajax({
                data: {
                    nombre: nombre,
                    apellido: apellido,
                    telefono: telefono,
                    descripcion: descripcion,
                    total: total,
                    email: email,
                },
                type: "GET",
                dataType: "json",
                url: "getLinkOpenpayCivi",
            })
                .done(function (response) {
                    $("#openpayID").val(response.openpayID);
                    $("#openpayLINK").val(response.openpayLINK);
                    sendFormCompra(); //envio
                })
                .fail(function () { });
        } else {
            sendFormCompra();
        }
    } else {
        sendFormCompra();
    }
}

function getLinkPayHotel() {
    if (document.forms.frmCompra.checkValidity() == false) {
        document.forms.frmCompra.reportValidity();
        return;
    }
    $("#btnPagar")
        .val("Procesando, por favor espera...")
        .attr("disabled", "disabled");
    var id = $("#openpayID").val();
    var nombre = $("#nombreTitular").val();
    var apellido = $("#apellidoTitular").val();
    var telefono = $("#telefonoTitular").val();
    var descripcion = "Hospedaje en el hotel :" + $("#nombrehotel").val();
    var email = $("#email").val();
    var total = $("#gtotal").val();

    if (nombre != "" && apellido != "" && telefono != "" && email != "") {
        if (id === "") {
            $.ajax({
                data: {
                    nombre: nombre,
                    apellido: apellido,
                    telefono: telefono,
                    descripcion: descripcion,
                    total: total,
                    email: email,
                },
                type: "GET",
                dataType: "json",
                url: "getLinkOpenpayHotel",
            })
                .done(function (response) {
                    console.log("ohla");
                    $("#openpayID").val(response.openpayID);
                    $("#openpayLINK").val(response.openpayLINK);
                    sendFormCompra(); //envio
                })
                .fail(function () { });
        } else {
            sendFormCompra();
        }
    } else {
        sendFormCompra();
    }
}

function changeCurrency(monedaSeleccionada) {
    $.ajax({
        data: { moneda: monedaSeleccionada },
        type: "GET",
        dataType: "html",
        url: "/changeCurrency",
    })
        .done(function (response) {
            location.reload();
        })
        .fail(function () { });
}

function currencyFormatter({ currency, value }) {
    const formatter = new Intl.NumberFormat("en-US", {
        style: "currency",
        minimumFractionDigits: 2,
        currency,
    });
    return formatter.format(value);
}

function validaFecha(inicio, fin, fecha) {
    D1 = new Date(inicio);
    D2 = new Date(fin);
    D3 = new Date(fecha);

    if (D3.getTime() <= D2.getTime() && D3.getTime() >= D1.getTime()) {
        return 1;
    } else {
        return 0;
    }
}

function updateFecha(fecha) {
    fecha = fecha.replaceAll("-", "/");
    fecha = new Date(fecha).toISOString();
    fecha = moment(fecha).format("MM/DD/YYYY");
    return fecha;
}

function formatoFecha(fecha, formato) {
    const map = {
        dd: fecha.getDate(),
        mm: fecha.getMonth() + 1,
        yy: fecha.getFullYear().toString().slice(-2),
        yyyy: fecha.getFullYear(),
    };

    console.log("Map: " + map.yyyy);
    return formato.replace(/dd|mm|yyyy/gi, (matched) => map[matched]);
}

function mostrarWhats() {
    $("#whatsIcon").fadeIn("fast");
}
function muestraPrecios(tipoActividad) {
    $(".tipoCat").each(function () {
        var id_cat = $(this).data("id");
        var precio = $(`#precio_${tipoActividad}_${id_cat}`).val();

        $(`#tipoCat_${id_cat} option[value=precio]`).text(
            `$ ${formatearMoneda(precio)} ` + $("#currency").val()
        );
        $("#tipoCat_" + id_cat).data("precio", precio);
    });

    calculaPrecio();
}

function tarifaNetaAgenciasTours(tarifa) {
    precio = tarifa / 0.99;
    return precio;
}

function tarifaPublicaAgenciasTours(tarifa, markup) {
    //Tarifa que le dara la agencia al cliente final
    tarifaAgencia = tarifa / 0.99;
    precio = tarifaAgencia / (1 - markup / 100);
    return precio;
}

function poneCantidad(elem, id) {
    var cant = $("#tipoCat_" + id + " option:selected").attr("rel");
    $("#cantidad_" + id).val(cant);
}

function formatearMoneda(
    valor,
    options = {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    }
) {
    return Number(valor).toLocaleString("es-MX", options);
}

$(window).on("beforeunload", function () {
    // $(".pre-loader").show()
    // $("#loading").show("fast");
});

function cleanText() {
    const username = document.querySelector(".textInput").value;
    const img = document.querySelector(".img");

    if (username.lenght <= 0) document.body.classList.remove("active");
    else document.body.classList.add("active");

    img.addEventListener("click", () => {
        document.querySelector(".textInput").value = "";
        document.body.classList.remove("active");
        FiltrarResultados([]);
    });
}

// Cupones
//Second - ShowDi
const evaluarEmail = (emailValue) => {
    console.log(emailValue);
    const reLargo =
        /^(([^<>()\[\]\\.,;:\s@”]+(\.[^<>()\[\]\\.,;:\s@”]+)*)|(“.+”))@((\[[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}])|(([a-zA-Z\-0–9]+\.)+[a-zA-Z]{2,}))$/;

    if (reLargo.test(emailValue)) {
        // console.log('correo aceptado' + emailValue);
        mostrarInputCoupon();
    } else {
        // return console.log('correo no aceptado' + emailValue);
        return $("#containerCounpon").css("display", "none");
    }
};
//third - ShowDi
const mostrarInputCoupon = () => $("#containerCounpon").css("display", "block");

//first finally - buttonCouponVerif
const comprobarCoupon = (servicioId) => {
    event.preventDefault();
    $("#totalPriceNew").remove();
    $("#mensajeCuponAplicado").css("display", "none");
    let emailValue = $("#email").val();
    let tipoServicio = servicioId;
    let coupon = $("#inputGetCoupon").val();
    let total = $("#total").val();
    // let totalTourFinal  = $('#totalTourFinal').val();
    let getTotalFinal;

    switch (tipoServicio) {
        case 1:
            getTotalFinal = $("#totalCivitatisFinal").val();
            console.log("civitatis");
            break;
        case 2:
            getTotalFinal = $("#totalHoteleriaFinal").val();
            console.log("hoteleria");
            break;
        case 3:
            getTotalFinal  = $('#totalTransportacionFinal').val();
            // getTotalFinal = $("#total").val();
            console.log("transportacion");
            break;
        case 4:
            getTotalFinal = $("#totalVueloFinal").val();
            console.log("vuelos");
            break;
        case 5:
            getTotalFinal = $("#totalExperienciaFinal").val();
            console.log("experiencias");
            break;
        default:
            console.log("No tengo el servicio");
            break;
    }

    let telefonoTitular = $("#telefonoTitular").val();

    return couponResponse(
        tipoServicio,
        coupon,
        emailValue,
        getTotalFinal,
        telefonoTitular
    );
};
//third - buttonCouponVerif
const informactionCoupon = (responseData) => {
    console.log("adentro del response");
    // return console.log(responseData);
    let mensajeCupon = responseData.mensaje;
    let descuento = responseData.descuento;
    let total = responseData.total;

    if (responseData.estatus == "ok") {
        $("#mensajeCupon").css("display", "block");
        $("#iconMenssage")
            .removeClass("fa-circle-xmark")
            .addClass("fa-regular fa-circle-check");
        $("#containerValid")
            .removeClass("backgroundNotValid")
            .addClass("backgroundValid");

        if (descuento != "0") {
            $("#mensajeCuponAplicado").css("display", "flex");
            mensajeFrontEnd(mensajeCupon, true, total, descuento, true);
            $("#gtotal").val(total);

            console.log("response data estatus ok->con descuento");
        } else {
            console.log("response data estatus ok->sin descuento");
            mensajeFrontEnd(mensajeCupon, true, total, descuento, false);
        }
        console.log("response data estatus ok");
        $(".compra").prop("disabled", true);
        $(".selectProducts").css("display", "none");
        // $('select').prop('disabled', true);
    } else if (responseData.estatus == "error") {
        $("#mensajeCupon").css({ display: "flex" });
        mensajeFrontEnd(mensajeCupon, false, total, false);
        $("#gtotal").val(total);

        $("#iconMenssage")
            .removeClass("fa-circle-check")
            .addClass("fa-regular fa-circle-xmark");
        $("#containerValid")
            .removeClass("backgroundValid")
            .addClass("backgroundNotValid");
        console.log("response data estatus error");
        $(".compra").prop("disabled", false);
        $(".selectProducts").css("display", "initial");
        // $('select').prop('disabled', false);
    } else {
        return "";
    }
    $("#totalTourPrecioCupon").val(total);
};

//Cuando se selecciona la fecha se ejecuta para incializar los valores de los options y pinta el 0

const crearOptionsExcursion = (
    cant_pax_max,
    cant_pax_min = 0,
    adultos = 0,
    menores = 0,
    infantes = 0,
    sumadeOptions = 0
) => {

    let cantidadMinOptions = parseInt(cant_pax_min);
    let cantidadMaxOptions = parseInt(cant_pax_max);
    let cantidadAdulto = parseInt(adultos);
    let cantidadMenores = parseInt(menores);
    let cantidadInfantes = parseInt(infantes);

    let sumaDelGrupo = cantidadAdulto + cantidadMenores + cantidadInfantes;

    var acepta_extras = parseInt($("#acepta_extras").val());
    var pax_max_extra = parseInt($("#pax_max_extra").val());

    if (acepta_extras == 1) {
        cantidadMaxOptions += pax_max_extra;
    }

    cantidadMaxOptions += 1;

    if (sumaDelGrupo <= cantidadMaxOptions) {
        //Inicializa los selects en 0
        crearOptions(cantidadMinOptions, cantidadMaxOptions, "adultos");
    }
};

const crearOptions = (cantidadMinOptions, cantidadMaxOptions, id) => {

    $("#" + id).empty();

    for (let $i = cantidadMinOptions; $i <= cantidadMaxOptions; $i++) {
        var adultos = document.getElementById(id);
        var option = document.createElement("option");
        if ($i == cantidadMinOptions) {
            //En la primer vuelta si i = 0, crea el primer option y se selecciona su valor, en este caso el 0
            $("#" + id).append(
                $("<option>", { value: `${$i}`, text: `${$i}`, selected: "1" })
            );
        } else {
            //Si el valor no es 0, se crean el resto de options
            option.text = $i;
            adultos.add(option);
        }
    }
};

//Esta función aparentemente no se está utilizando
const crearOptionsInfantes = (cantidadOptions) => {
    $("#infantes").empty();
    for (let $i = 0; $i <= cantidadOptions; $i++) {
        var adultos = document.getElementById("infantes");
        var option = document.createElement("option");
        option.text = $i;
        adultos.add(option);
    }
};

const obtenerValorInputsSelected = (cantidadTotalGroup) => {
    let valorSelectAdultos = parseInt($("#adultos option:selected").val());
    let valorSelectMenores = parseInt($("#menores option:selected").val());
    // let valorSelectInfantes = parseInt($("#infantes option:selected").val());
    let sumaDeOptions =
        parseInt(valorSelectAdultos) + parseInt(valorSelectMenores);
    // let cantMinPersonas = parseInt(cantidadMinGroup)
    sumarCantidadDePersonasSeleccionadas(cantidadTotalGroup, sumaDeOptions);
};

const sumarCantidadDePersonasSeleccionadas = (number, totalSeleccionado) => {
    let cantidadTotalPermitidoPorGorup = parseInt(number);
    let hoteleria = parseInt($("#hoteleria").val());

    //No aplicar reglas de limites al ser tour con hoteleria
    if (hoteleria === 0) {
        mostrarMensajesDelGrupo(cantidadTotalPermitidoPorGorup, totalSeleccionado);
    }
};

const mostrarMensajesDelGrupo = (numberTotalGroup, countPeoples) => {

    //Div con mensaje para el limite maximo de personas
    let mensajeContenedorCountPersonas = $("#mensajeLimiteContadorPersonas");
    //Variable que cuenta cuantas personas has seleccionado, cuando alcanzas el maximo y cuando lo sobrepasas
    let mensajeCountOfTheLimitGroup = `Has seleccionado ${countPeoples} personas`;
    //Div con mensaje cuando se cumple el minimo de Personas
    let mensajeMinimoCountPersonas = $("#mensajeMinimoContadorPersonas");
    //Variable donde se inyecta el mensaje cuando se alcanza el minimo de personas
    let mensajeMinimoCountMin = `Has completado el minimo de personas`;
    //Número minimo de personas para el grupo
    let cantMinPersonasGroup = parseInt($("#cant_pax_min").val());

    mensajeContenedorCountPersonas.empty();
    mensajeMinimoCountPersonas.empty();
    var tipo_costo = parseInt($("#tipo_costo").val());
    var acepta_extras = parseInt($("#acepta_extras").val());

    if (tipo_costo == 1) {
        if (acepta_extras == 1) {
            let pax_max_extra = parseInt($("#pax_max_extra").val());
            numberTotalGroup = parseInt(numberTotalGroup) + parseInt(pax_max_extra);
        }
    }

    //Representa el boton, cuando es falso == bloquear, cuando es true == permitir
    let status;
    let completed;
    let limit = false;

    //Nuevas condicionales
    if (
        countPeoples < numberTotalGroup &&
        countPeoples < cantMinPersonasGroup
    ) {
        mensajeMinimoCountMin = ``;
        status = false;
        completed = false;
        mostrarMensajes("oculto", "oculto", "oculto", "");
        ocultarMensajes("", "", "", "oculto");
    }

    if (
        countPeoples < numberTotalGroup &&
        countPeoples >= cantMinPersonasGroup
    ) {
        mostrarMensajes("oculto", "", "", "oculto");
        ocultarMensajes("", "oculto", "", "");
        status = true;
        completed = false; //Significa que no está dentro del rango
    }
    //Sino PERO countPeoples == numerTotalGroup, reestructurar esta condicional
    if (
        countPeoples === numberTotalGroup &&
        countPeoples >= cantMinPersonasGroup
    ) {
        mensajeCountOfTheLimitGroup = `Has completado el límite de personas`;
        mostrarMensajes("", "", "", "oculto");
        ocultarMensajes("oculto", "oculto", "", "oculto");

        status = true;
        completed = true;
    }

    if (countPeoples > numberTotalGroup) {
        mensajeCountOfTheLimitGroup = `Estas sobrepasando el límite de personas`;
        mostrarMensajes("", "", "", "");
        ocultarMensajes("oculto", "oculto", "oculto", "oculto");
        status = false;
        completed = false;
        limit = true;
    }

    mensajeContenedorCountPersonas.append(
        `<p id="messageGroupResponse"><i class="fa fa-people-arrows" style="margin-left: 2px;"></i>${mensajeCountOfTheLimitGroup}</p>`
    );
    mensajeMinimoCountPersonas.append(
        `<p id="messageGroupResponseMin"><i class="fa fa-people-arrows" style="margin-left: 2px;"></i>${mensajeMinimoCountMin}</p>`
    );
    styleResponse(status, completed, limit);
};

const mostrarMensajes = (
    mensajeLimiteGroup,
    contenedorMensajeMin,
    mensajecontenedorCountPersonas,
    mensajeMinimoContadorPersonas
) => {
    $("#mensajeLimiteGroup").removeClass(mensajeLimiteGroup); //Mostrar el limite de personas
    $("#contenedorMensajeMin").removeClass(contenedorMensajeMin);
    $("#mensajecontenedorCountPersonas").removeClass(
        mensajecontenedorCountPersonas
    );
    $("#mensajeMinimoContadorPersonas").removeClass(
        mensajeMinimoContadorPersonas
    );
};

const ocultarMensajes = (
    mensajeLimiteGroup,
    contenedorMensajeMin,
    mensajecontenedorCountPersonas,
    mensajeMinimoContadorPersonas
) => {
    $("#mensajeLimiteGroup").addClass(mensajeLimiteGroup); //Mostrar el limite de personas
    $("#contenedorMensajeMin").addClass(contenedorMensajeMin);
    $("#mensajecontenedorCountPersonas").addClass(
        mensajecontenedorCountPersonas
    );
    $("#mensajeMinimoContadorPersonas").addClass(mensajeMinimoContadorPersonas);
};

const styleResponse = (status, completed, limit) => {
    let contentResponse = $("#messageGroupResponse");
    let contentResponseMin = $("#messageGroupResponseMin");
    let buttonReservar = $("#btngetprices");

    if (!status && limit == false) {
        buttonReservar.prop("disabled", true);
        contentResponse.addClass("messageGroupAccept");
    } else if (status && completed) {
        //Sino, se habilita el btn
        buttonReservar.prop("disabled", false);
        contentResponseMin.addClass("messageGroupCompleted");
        contentResponse
            .removeClass("messageGroup messageGroupError")
            .addClass("messageGroupCompleted");

        // contentResponseMin.addClass("messageGroupCompleted");
    } else if (limit == false) {
        buttonReservar.prop("disabled", false);
        contentResponse
            .removeClass("messageGroupError")
            .addClass("messageGroupAccept");
        contentResponseMin.addClass("messageGroupCompleted");
    } else {
        contentResponse
            .removeClass("messageGroupAccept")
            .addClass("messageGroupError");
        buttonReservar.prop("disabled", true);
    }
};

const getNewDateOfTheUnicDay = (
    fechaInicioDeLaTemporada,
    fechaFinDeLaTemporada
) => {
    let miFecha = new Date(fechaInicioDeLaTemporada);
    var dia = miFecha.getDate() + 1;
    var mes = miFecha.getMonth();
    var yyy = miFecha.getFullYear();

    let miFechaFinal = new Date(fechaFinDeLaTemporada);
    var diaFinal = miFechaFinal.getDate() + 1;
    var mesFinal = miFechaFinal.getMonth();
    var yyyFinal = miFechaFinal.getFullYear();

    return {
        dia,
        mes,
        yyy,
        diaFinal,
        mesFinal,
        yyyFinal,
    };
};

const resetInformationAndElementsDOM = () => {
    $("#contenedorCalendario").empty();
    $("#contenedorCalendario").append(
        `<input required type="text" name="fecha"  id="datepickerCalendario" class="form-control" placeholder="Fecha" readonly>`
    );

    let x = document.getElementById("adultos").children[0];
    x.setAttribute("selected", "selected");

    let y = document.getElementById("menores").children[0];
    y.setAttribute("selected", "selected");

    $(".subtotalAdulto").html("0");
    $(".subtotalMenor").html("0");
    $(".subtotalInfante").html("0");
    $("#total").val("0");
};

function check_in_range(fecha_inicio, fecha_fin, fecha) {
    fecha_inicio = new Date(fecha_inicio).getTime();
    fecha_fin = new Date(fecha_fin).getTime();
    fecha = new Date(fecha).getTime();

    if (fecha >= fecha_inicio && fecha <= fecha_fin) {
        
        return 1;
    } else {

        return 0;
    }
}

