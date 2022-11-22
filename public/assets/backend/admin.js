function startSpinnerOne() {

    $('#loader_box_one').css({
        'display': 'block',
        'margin-left': '565px',
        'position': 'absolute'
    });
}

function stopSpinnerOne() {

    $('#loader_box_one').attr('style', 'display:none');

}


function startInvoiceSpinner() {

    $('#loader_box_two').css({
        'display': 'block',
        // 'margin-left': '565px',
        'position': 'absolute'
    });
}

function stopInvoiceSpinner() {

    $('#loader_box_two').attr('style', 'display:none');

}


function numberWithCommas(elem) {

    elem.val(function(index, value) {
        return value
            .replace(/\D/g, "")
            .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    });

}