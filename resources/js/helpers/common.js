// Page Setup
function initPage() {
    if ($('select.select2').length) {
        $.each($('select.select2'), function () {
            var opt = {
                width: '100%',
                theme: "bootstrap4"
            };

            if (typeof $(this).data('search') != 'undefined' && $(this).data('search') == false) {
                opt = $.extend(true, opt, { minimumResultsForSearch: -1 });
            }
            $(this).select2(opt);
        });
    }

    $('[data-toggle="tooltip"]').tooltip();

    $('.cb-dynamic-label input[type=checkbox]').on('change', function () {
        cbCustomInput(this);
    });

    if ($('.cb-dynamic-label input[type=checkbox]').length > 0) {
        $.each($('.cb-dynamic-label input[type=checkbox]'), function () {
            cbCustomInput(this);
        });
    }
}

function cbCustomInput(e) {
    var textOn = $(e).data('text-on');
    var textOff = $(e).data('text-off');
    var name = $(e).attr('id');
    if (typeof name == 'undefined' || name == '') {
        name = $(e).attr('name');
    }

    var target = $('label[for=' + name + ']');
    if ($(e).is(":checked")) {
        target.html(textOn);
    } else {
        target.html(textOff);
    }
}

//REMOTE MODAL
function initModalAjax(selector) {
    var selector_triger = typeof selector !== 'undefined' ? selector : '[data-toggle="modal"]';
    $(selector_triger).on('click', function (e) {
        /* Parameters */
        var url = $(this).attr('href');
        let containerTarget = $(this).attr('data-target');
        let form = $(this).attr('data-form');
        let data = $(form).serialize();

        if (url.indexOf('#') == 0) {
            $(containerTarget).modal();
        } else {
            /* XHR */
            var loading = '<div class="text-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';

            $(containerTarget).modal();
            $('.modal-content', $(containerTarget)).html(loading).load(url, data, function () { });

        }
        return false;
    });
}

// DATA TABLES
function initDatatableAction(table_id, callback) {
    $('.btn-delete', table_id).on('click', function () {
        $(this).myAjax({
            success: function (data) {
                callback();
            }
        }).delete();

        return false;
    });

}

function initDatatableTools(table_id, oTable) {
    var header_id = $('[data-table="#' + $(table_id).attr('id') + '"]');
    var $form_filter = $(table_id).attr('data-table-filter');

    $($form_filter).on('submit', function (e) {
        e.preventDefault();
        oTable.reload();
    });

    $('.filter-select', $($form_filter)).on('change', function (event) {
        event.preventDefault();

        var $auto_filter = $(table_id).attr('data-auto-filter');
        if ($auto_filter == 'true') {
            oTable.reload();
        }
    });

    $('a[href="#btn-checked-all"], a[href="#btn-unchecked-all"]', table_id).on('click', function () {
        var id = $(this).attr('href');
        if (id == '#btn-checked-all') {
            $('.dt-checkbox', table_id).prop('checked', true);
        } else {
            $('.dt-checkbox', table_id).prop('checked', false);
        }
        return false;
    });

    $('.btn-delete-selected', table_id).on('click', function () {
        var id = [];

        $.each($('.dt-checkbox', table_id), function () {
            if ($(this).is(':checked')) {
                id.push($(this).val());
            }
        });

        if (id.length > 0) {
            $(this).myAjax({
                data: {
                    id: id
                },
                success: function (data) {
                    oTable.reload();
                }
            }).delete({ confirm: { text: __('helpers.common.multiple_delete', { total: id.length }) } });
        } else {
            command: toastr["warning"](__('helpers.common.nf_cb_selected'));
        }

        return false;
    });

    $('.auto_filter', header_id).on('switchChange.bootstrapSwitch', function (event, state) {
        $('table#main-table').attr('data-auto-filter', $(this).is(':checked') ? 'true' : 'false');
    });

    $('.reload-table', header_id).on('click', function () {
        oTable.reload();
        return false;
    });

    $('.reset-filter', header_id).on('click', function () {
        oTable.filterReset();
        return false;
    });
}

function dd_cascade(target, url, data, selected) {
    $(target).html('<option value="">Loading...</option>');

    $.get(url, data, function (out) {
        var options = '';
        $.each(out.data, function (idx, val) {
            options += '<option value="' + idx + '">' + val + '</option>';
        });

        var checked = typeof selected != 'undefined' ? selected : '';
        $(target).html(options);
        $(target).val(checked);
    }, 'json');
}

function generate_code(selector, url) {
    var target = $(selector);

    if (typeof url == 'undefined') {
        url = $(selector).data('g-code');
    }

    if (url) {
        $.get(url, {}, function (out) {
            $(selector).val(out.data.code);
        }, 'json');
    } else {
        console.log('undefined url');
    }
}

function number_format(number) {

    var result = numeral(Number(number)).format('0,0.00');

    return result;
}

function convert_to_number(n) {
    if (typeof n != 'string')
        return 0;

    var s = n.split(',');
    var r = [];
    r.push(s[0].replace(/\./g, ''));
    if (typeof s[1] != 'undefined') {
        r.push(s[1]);
    }
    var x = r.join('.');
    // console.log('convert_to_number('+ n +');' + x);
    return x;
}

function do_export(form, url) {
    var data = $(form).serialize();

    window.open(url + '?' + data, '_blank');
}

function bytesToSize(bytes) {
    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    if (bytes == 0) return '0 Byte';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}

function stepwizard(id) {
    var navListItems = $('div.setup-panel div a'),
        allWells = $('.stepwizard-content');

    allWells.hide();
    $('#' + id).show();

    navListItems.removeClass('btn-success').addClass('btn-default');
    $('[data-wizard=' + id + ']').addClass('btn-success');

    navListItems.attr('disabled', 'disabled');
    var enable = $('[data-wizard=' + id + ']').data('wizard-enable');
    if (typeof enable != 'undefined') {
        $.each(enable.split(','), function (i, v) {
            $('[data-wizard=' + v + ']').removeAttr('disabled');
        });
    }
}

function each_tabledata(tabledata) {
    var i = 0;
    $.each(tabledata, function (i, context) {
        context.first = i == 0 ? true : false;
        append_tabledata(context);
        i++;
    });
}

function append_tabledata(context) {
    // context.idx = UUID.create().toString();
    context.idx = parseInt($('.rows').length) + 0;

    var source = $("#table-template").html();
    var template = Handlebars.compile(source);
    var html = template(context);

    $('#table-data tbody').append(html);
    $('.select2', $('#table-data #row-' + context.idx)).select2({
        width: '100%',
        theme: "bootstrap4"
    });

    $('.type', $('#table-data #row-' + context.idx)).val(typeof context.type != 'undefined' ?
        context.type : '').trigger('change');

    $('.index', $('#table-data #row-' + context.idx)).val(typeof context.index != 'undefined' ?
        context.index : '').trigger('change');

    $('.nullable', $('#table-data #row-' + context.idx)).prop('checked', typeof context.nullable != 'undefined' ?
        context.nullable : false);

}

function deleteColumn(idx) {
    $('#row-' + idx, $('#table-data')).remove();
}

function formSubmit(id, callback) {
    $(document).find(id).validate({
        rules: generateRules(id),
        errorPlacement: function (error, element) {
            let name = $(element).attr('name');
            if (!name)
                return;

            $('.invalid-feedback-' + name).html(error);
        },
        submitHandler: function (form) {
            callback(id);
        }
    });
}

function formValidation(id) {
    $(id).validate({
        rules: generateRules(id),
        errorPlacement: function (error, element) {
            let name = $(element).attr('name');
            if (!name)
                return;

            $('.invalid-feedback-' + name).html(error);
        },
    });
}

function generateRules(element) {
    let result = [];

    $(element).each(function () {
        let formInput = $(this).find(':input');
        $.each(formInput, function (index, value) {
            let nameInput = $(this).attr('name');
            let attrValidation = $(this).data('validation');
            if (!attrValidation)
                return;

            result[nameInput] = generateRuleItems(attrValidation);
        });
    });

    return result;
}

function generateRuleItems(attributes) {
    let result = {};

    let arrValidation = attributes.split('|');
    $.each(arrValidation, function (index, value) {
        let arrValue = value.split(':');
        let name = (typeof arrValue[0] !== 'undefined') ? arrValue[0] : null;
        let extra = (typeof arrValue[1] !== 'undefined') ? arrValue[1] : true;

        result[name] = extra;
    });

    return result;
}