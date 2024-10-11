$(function () {
    initControl();
});

function initControl() {
    $(".datepicker").each((i, item) => {
        $(item).datetimepicker({
            format: 'L'
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