$(function () {
    $.ajaxSetup({
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
    });
    $(document)
        .ajaxStart(function () { })
        .ajaxComplete(function (event, xhr, settings) { })
        .ajaxError(function myErrorHandler(event, xhr, ajaxOptions, thrownError) {
            if (thrownError == "abort") {
                return;
            }
            if (xhr.status == 401) {
                location.href = "/login";
            } else if (xhr.status == 422) {
                var error = xhr.responseJSON.errors;
                var msg = "";
                for (var e in error) {
                    msg += error[e] + "<br/>";
                }
                $.alert ? $.alert(msg, "Terjadi kesalahan!") : alert(msg);
            } else if (xhr.status == 499 || xhr.status == 444) {
                // error request cancelled
            } else if (xhr.status == 500) {
                var error =
                    xhr.responseJSON?.message ||
                    xhr.responseJSON?.errors ||
                    xhr.responseJSON?.error ||
                    xhr.responseJSON ||
                    xhr.responseText;
                if (window.is_debug) {
                    $("#modal-error .modal-body").html(error);
                    $("#modal-error").modal("show");
                } else {
                    $.alert ? $.alert(error, "Terjadi kesalahan!") : alert(error);
                }
            } else {
                var error =
                    xhr.responseJSON?.message ||
                    xhr.responseJSON?.errors ||
                    xhr.responseJSON?.error;
                $.alert ? $.alert(error, "Terjadi kesalahan!") : alert(error);
            }
        });
    initControl();
});

function initControl() {
    $(".datepicker").each((i, item) => {
        $(item).datetimepicker({
            format: 'YYYY-MM-DD'
        });
    });
    $(".numeric").inputmask('decimal', {
        digits: 0,
        digitsOptional: true,
        radixPoint: '.',
        groupSeparator: ',',
        autoGroup: true,
        autoUnmask: true,
        removeMaskOnSubmit: true,
        allowPlus: true,
        allowMinus: true,
        unmaskAsNumber: true,
        greedy: false,
    });
    $(".numeric2").inputmask('decimal', {
        digits: 2,
        digitsOptional: true,
        radixPoint: '.',
        groupSeparator: ',',
        autoGroup: true,
        autoUnmask: true,
        removeMaskOnSubmit: true,
        allowPlus: true,
        allowMinus: true,
        unmaskAsNumber: true,
        greedy: false,
    });
}