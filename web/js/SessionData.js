

var select = $('#tic_platformbundle_sessions_contract');
var selectAddress = $('#tic_platformbundle_sessions_address');
var dailyAmount = $('#tic_platformbundle_sessions_sessionDailyAmount');

select.on('change', function() {
    updateData();
});

$(document).ready(function() {
    if ($('#newEvent').length == 1) {
        updateData();
    }
});

function updateData() {
    var contractID = select.select2().val();
    if (contractID !== null) {
        $.ajax({
            url: Routing.generate('tic_platform_contract_get_addresses', {'contractID' : contractID}),
            type: 'GET',
            datatype: 'JSON',
            success: function (data) {
                selectAddress.select2("destroy");
                var html = "";
                for (var i = 0; i < data.addresses.length; i++) {
                    html += "<option value='" + data.addresses[i].id + "'>" + data.addresses[i].text + "</option>";
                }
                selectAddress.html(html);
                selectAddress.select2();
                dailyAmount.val(data.dailyAmount)
            }
        });
    }
}