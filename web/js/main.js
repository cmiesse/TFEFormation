var runDataTable = function () {
    if ($.isFunction($.fn.DataTable)) {
        $('.dataTable').DataTable({
            search : {
                caseInsensitive: true
            }
        });
    }
};

var runSelect2 = function () {
    if ($.isFunction($.fn.select2)) {
        $('.search-select').select2({
            allowClear: true
        });
    }
};

var runDatepicker = function () {
    if ($.isFunction($.fn.datepicker)) {
        $('.date-picker').datepicker({
            autoclose: true
        });
    }
};

var runColorPicker = function () {
    if ($.isFunction($.fn.colorpicker)) {
        $('.color-picker').colorpicker({
            autoclose: true,
            format: 'hex'
        });
    }
};

function validFormat(e) {
    var pe = e.parents('div.form-group');
    var input = document.querySelector('#' + e.attr('id'));
    if (input === null || input === undefined) {
        return true;
    }
    if (!input.checkValidity()) {
        if (!pe.hasClass('has-error'))
            pe.addClass('has-error');
        return false;
    } else {
        if (pe.hasClass('has-error'))
            pe.removeClass('has-error');
    }
    return true;
}

function verifyField(i) {
    $.each($('form[name=' + i + '] input'), function () {
        //validFormat($(this));
        $(this).on("input", function () {
            validFormat($(this));
        });
        $(this).on("change", function () {
            validFormat($(this));
        });
    });
    $.each($('form[name=' + i + '] textarea'), function () {
        //validFormat($(this));
        $(this).on("input", function () {
            validFormat($(this));
        });
    });
}

function validForm(i) {
    $.each($('form[name=' + i + '] input'), function () {
        validFormat($(this));
    });
    $.each($('form[name=' + i + '] textarea'), function () {
        validFormat($(this));
    });
}

function toggleDivClass(div, state, classValue) {
    if (state) {
        if (!div.hasClass(classValue)) {
            div.addClass(classValue);
        }
    } else {
        if (div.hasClass(classValue)) {
            div.removeClass(classValue);
        }
    }
}

/**
 * @param btnClass The class of the button to attach the event
 * @param modalID The id of the modal with the content
 * @param messageID The id of the div for the message to display
 * @param route The route to redirect to
 * @param dataMessage The pos of the td to show
 * @param routeParamName The name of the param to give to the route
 * @param itemClass The class name of the item to use
 * @param routeParam If other param must be passed as param for the route
 */
function modalRemove(btnClass, modalID, messageID, route, dataMessage, routeParamName, itemClass, routeParam) {
    $('.' + btnClass).on('click', function() {
        var oTr = $(this).parents('tr');
        var modal = $('#' + modalID);
        $('#' + messageID).html(oTr.find('td').eq(dataMessage).text());

        if (routeParam === undefined) {
            routeParam = new Object();
        }
        routeParam[routeParamName] = oTr.find('.' + itemClass).text();

        modal.find(".modal-footer a").attr("href", Routing.generate(route, routeParam));
        modal.modal('show');
    });
}

$(document).ready(function () {
    runDataTable();
    runSelect2();
    runDatepicker();
    runColorPicker();
});