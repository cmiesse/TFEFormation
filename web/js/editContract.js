var sumInput = $('#tic_platformbundle_contracts_contractTotalAmount');
var dailyInput = $('#tic_platformbundle_contracts_contractDailyAmount');
var nbDaysInput = $('#tic_platformbundle_contracts_contractDaysNumber');

dailyInput.on('input', function() {
    onInput($(this), nbDaysInput, sumInput);
});

nbDaysInput.on('input', function () {
    onInput($(this), dailyInput, sumInput);
});

function onInput(input, secondInput, resInput) {
    var inputVal = getFromInput(input);
    var secondInputVal = getFromInput(secondInput);
    if (!isNaN(inputVal) && !isNaN(secondInputVal)) {
        resInput.val(inputVal * secondInputVal);
    }
}

function getFromInput(input) {
    if (input.val() !== null && input.val() !== "") {
        return parseFloat(input.val().replace(',', '.'));
    } else {
        input.val(0);
        return 0;
    }
}