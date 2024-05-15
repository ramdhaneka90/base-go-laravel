$(function () {
    // Set default jQuery Validate
    $.validator.setDefaults({
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });

    // Set custom message jQuery Validate
    $.extend(jQuery.validator.messages, {
        required: "Isian belum terisi.",
        remote: "Mohon betulan isian ini.",
        email: "Format email tidak valid.",
        url: "Format URL tidak valid.",
        date: "Format tanggal tidak valid.",
        dateISO: "Format tanggal tidak valid (ISO).",
        number: "Format nomor tidak valid.",
        digits: "Hanya bisa mengisikan angka.",
        creditcard: "Format kartu kredit tidak valid.",
        equalTo: "Isikan nilai yang sama lagi.",
        accept: "Isikan nilai dengan ekstensi yang valid.",
        maxlength: jQuery.validator.format("Isikan isian kurang dari {0} karakter."),
        minlength: jQuery.validator.format("Isikan isian lebih dari {0} karakter."),
        rangelength: jQuery.validator.format(
            "Isikan nilai antara {0} dan {1} karakter."),
        range: jQuery.validator.format("Isikan nilai antara {0} sampai {1}."),
        max: jQuery.validator.format("Isian tidak boleh lebih dari {0}."),
        min: jQuery.validator.format("Isian tidak boleh kurang dari {0}.")
    });
});