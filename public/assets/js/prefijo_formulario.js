$(document).ready(function() {
    inputPrefijoHidden();
    $('#telefonoTitular').attr('type', 'text');
    var input = document.querySelector("#telefonoTitular");

    var pluginPrefijos = intlTelInput(input, {
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.8/build/js/utils.js",
        separateDialCode: true,

        hiddenInput: function(telInputName) {
            return {
              country: "isoNumber"
            };
          }
    });

    input.addEventListener("countrychange", function() {
        editType();
    });
});

function editType() {
    let codigoNumber = document.getElementsByClassName('iti__selected-dial-code')[0].textContent;
    codigoNumber = String(codigoNumber).slice(1);
    return $('#codigoNumber').val(codigoNumber);
}

function inputPrefijoHidden() {
    let input           = document.createElement('input');
    input.setAttribute('type', 'hidden');
    input.id            = "codigoNumber";
    input.name          = "codigoNumber";
    return $('input[name=_token]')[0].after(input);
}