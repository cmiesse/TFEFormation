$('.resetCalendar').on('click', function () {
    var tr = $(this).parents('tr');
    $.ajax({
        url: Routing.generate('tic_platform_main_webmaster_calendar_reset', {'trainerID' : tr.find('.trainerID').text()}),
        type: 'POST',
        success: function (data) {
            console.log(data);
        }
    })
});