$('.removeDocument').on('click', function () {
    var li = $(this).parents('li');
    $.ajax({
        url: Routing.generate('tic_platform_main_remove_file', {
            'trainerID' : $(this).attr('data-trainerID'), 'documentID' : $(this).attr('data-id'), 'documentType' : $(this).attr('data-documentType')
        }),
        type: 'POST',
        datatype: 'JSON',
        success: function (data) {
            li.remove();
        }
    })
});