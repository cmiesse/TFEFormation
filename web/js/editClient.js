var clientID = $('#clientID').text();
var commonRouteObj = new Object();
commonRouteObj["id"] = clientID;

$('#addAddress').on('click', function () {
    $('#addressID').text(-1);
    loadAddress();
});

$('.editAddress').on('click', function () {
    $('#addressID').text($(this).parents('tr').find('.clientAddressID').text());
    loadAddress();
});

function loadAddress() {
    $.ajax({
        url: Routing.generate('tic_platform_clients_address', {'idAddress': $('#addressID').text(), 'id' : clientID}),
        type: 'GET',
        success: function(data){
            $('#addressData').html(data);
            $('#modalAddress').modal('show');
            verifyField('tic_platformbundle_clientaddresses');
        }
    })
}

$('#SaveAddress').on('click', function () {
    if (!document.querySelector('form[name="tic_platformbundle_clientaddresses"]').checkValidity()) {
        validForm("tic_platformbundle_clientaddresses");
        return;
    }
    var form = $('form[name="tic_platformbundle_clientaddresses"]');
    var modalAddress = $('#modalAddress');
    modalAddress.modal("hide");
    $.ajax({
        url: Routing.generate('tic_platform_clients_address', {'idAddress': $('#addressID').text(), 'id' : clientID}),
        type: 'POST',
        data: form.serialize(),
        success: function(data) {
            if (data.status !== undefined && data.status !== null) {
                if (data.status == "Success") {
                    window.location.reload();
                } else {
                    modalAddress.modal("show");
                }
            }
        },
        error: function () {
            modalAddress.modal("show");
        }
    })
});

$('#addContact').on('click', function () {
    $('#contactID').text(-1);
    loadContact();
});

$('.editContact').on('click', function () {
    $('#contactID').text($(this).parents('tr').find('.clientContactID').text());
    loadContact();
});

modalRemove("deleteAddress", "modalDeleteAddress", "messageModalAddress", "tic_platform_clients_delete_address", 1, "idAddress", "clientAddressID", commonRouteObj);
modalRemove("deleteContact", "modalDeleteContact", "messageModalContact", "tic_platform_clients_delete_contact", 1, "idContact", "clientContactID", commonRouteObj);

function loadContact() {
    $.ajax({
        url: Routing.generate('tic_platform_clients_contact', {'idContact': $('#contactID').text(), 'id' : clientID}),
        type: 'GET',
        success: function(data){
            $('#contactData').html(data);
            $('#modalContact').modal('show');
            verifyField("tic_platformbundle_contactpeople");
        }
    })
}

$('#SaveContact').on('click', function () {
    if (!document.querySelector('form[name="tic_platformbundle_contactpeople"]').checkValidity()) {
        validForm('tic_platformbundle_contactpeople');
        return;
    }
    var modalContact = $('#modalContact');
    modalContact.modal("hide");
    $.ajax({
        url: Routing.generate('tic_platform_clients_contact', {'idContact': $('#contactID').text(), 'id' : clientID}),
        type: 'POST',
        data: $('form[name="tic_platformbundle_contactpeople"]').serialize(),
        success: function(data) {
            if (data.status !== undefined && data.status !== null) {
                if (data.status == "Success") {
                    window.location.reload();
                } else {
                    modalContact.modal("show");
                }
            }
        },
        error: function () {
            modalContact.modal("show");
        }
    })
});