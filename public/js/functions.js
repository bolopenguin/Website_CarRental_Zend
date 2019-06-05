function doValidation(id, actionUrl, formName) {

    function showErrors(resp) {
        $("#" + id).parent().parent().find('.errors').html(' ');
        //azzera la colonna errore
        $("#" + id).parent().parent().find('.errors').html(getErrorHtml(resp[id]));
        //iniettiamo gli errori che provengono da getError
    }

    $.ajax({
        //chiamata post
        type: 'POST',
        url: actionUrl,
        data: $("#" + formName).serialize(),
        //gli passa il contenuto serializzato: la stringa coppie nome-valore
        dataType: 'json',
        success: showErrors
        //il dato ritornato dal server con gli errori eventuali attiverà l'action showErrors
    });
}

function getErrorHtml(formErrors) {
    if ((typeof (formErrors) === 'undefined') || (formErrors.length < 1))
        return;

    var out = '<ul>';
    for (errorKey in formErrors) {
        out += '<li>' + formErrors[errorKey] + '</li>';
    }
    out += '</ul>';
    return out;
}

