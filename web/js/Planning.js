var sessionID = $('#sessionID').text();
var isSession = (sessionID != "-1");
var count = null;
var sessionNumberOfDays = $('#sessionNumberOfDays').text();
if (sessionNumberOfDays != "-1") {
    sessionNumberOfDays = parseFloat(sessionNumberOfDays);
} else {
    sessionNumberOfDays = null;
}

var divMaxError = $('#showMaxError');


var filters = {};
// Used for selection in event (Scheduler)
var trainers = [
    {key: -1, label: "None"}
];

$(document).ready(function () {
    var select = $('select[name="trainer"]');
    var options = select.find('option');
    for (var i = 0; i < options.length; i++) {
        filters[options[i]['value']] = options[i]['selected'];
        trainers.push({key: options[i]['value'], label: options[i]['text']});
    }
    $.ajax({
        url: Routing.generate('tic_platform_planning_info', {'sessionID': sessionID}),
        type: 'GET',
        datatype: 'JSON',
        success: function (data) {
            if (isSession) {
                count = parseFloat($('#countDays').text());
                if (sessionNumberOfDays !== null) {
                    if (count >= sessionNumberOfDays) {
                        toggleDivClass(divMaxError, false, "hidden");
                    } else {
                        toggleDivClass(divMaxError, true, "hidden");
                    }
                } else {
                    toggleDivClass(divMaxError, true, "hidden");
                }
            } else {
                toggleDivClass(divMaxError, true, "hidden");
            }
            initScheduler(data);
            select.on('change', function () {
                var options = select.find('option');
                for (var i = 0; i < options.length; i++) {
                    filters[options[i]['value']] = false;
                }
                var selectedItems = $(this).val();
                for (var i = 0; selectedItems !== null && i < selectedItems.length; i++) {
                    filters[selectedItems[i]] = true;
                }
                scheduler.updateView();
            })
        }
    })
});

function initScheduler(data) {
    // here we are using single function for all filters but we can have different logic for each view
    scheduler.filter_month = scheduler.filter_day = scheduler.filter_week = function (id, event) {
        // display event only if its type is set to true in filters obj
        // or it was not defined yet - for newly created event
        if (filters[event.TrainerID] || event.TrainerID == scheduler.undefined || event.TrainerID == [] || event.TrainerID == -1) {
            return true;
        }
        // default, do not display event
        return false;
    };

    scheduler.locale.labels.section_trainers = "Trainers";
    scheduler.config.lightbox.sections = [
        {name: "text", height: 130, map_to: "text", type: "textarea", focus: true},
        {name: "trainers", height: 23, options: trainers, map_to: "TrainerID", type: "select"},
        {name: "time", height: 72, map_to: "auto", type: "time"}
    ];

    scheduler.config.xml_date = "%Y-%m-%d %H:%i";
    scheduler.config.details_on_create = true;

    // scheduler.config.all_timed = true;

    scheduler.config.first_hour = 9;
    scheduler.config.event_duration = 480;
    scheduler.config.auto_end_date = false;

    scheduler.config.display_marked_timespans = true;
    scheduler.addMarkedTimespan({ // blocks each Sunday, Monday, Wednesday
        days: [0, 6],
        zones: "fullday",
        type: "dhx_time_block",
        css: "blue_section"
    });

    // Change the size of the square
    scheduler.xy.month_head_height = 120;

    scheduler.config.ajax_error = "alert";

    // Default value text
    var clientName = $('#clientName');
    var formationName = $('#formationName');
    var formationLanguage = $('#formationLanguage');

    if (clientName.length == 1 && formationName.length == 1 && formationLanguage.length == 1) {
        scheduler.locale.labels.new_event = clientName.text() + " - " + formationName.text() + " - " + formationLanguage.text();
    }

    scheduler.init('scheduler_here', new Date(), "month");
    scheduler.parse(data, "json");
    // scheduler.load(connectorScheduler);
    // scheduler.load(data, "json");
    var dp = new dataProcessor(Routing.generate('tic_platform_planning_update', {'sessionID': sessionID}));
    dp.init(scheduler);

    // var dp2 = new dataProcessor(dataScheduler);
    // dp2.init(scheduler);
    // dp2.setTransactionMode("POST", false);

    //scheduler.attachEvent("onEventAdded");

    scheduler.attachEvent("onEventSave", function (id, data, is_new) {
        if (is_new !== null && is_new !== undefined) {
            data.SessionID = sessionID;
            if (isSession) {
                var ms = data.end_date - data.start_date;
                var day = calculDays(ms);
                if (count + day > sessionNumberOfDays) {
                    console.log("Max number of days reached.");
                    scheduler.cancel_lightbox();
                    $('#modalError').modal('show');
                    return false;
                }
            }
        } else {
            if (isSession) {
                var time = count;
                var elem = scheduler.getEvent(id);
                var ms = elem.end_date - elem.start_date;
                var day = calculDays(ms); // Calcul old day
                time -= day;
                ms = data.end_date - data.start_date; // Calcul new day
                day = calculDays(ms);
                if (time + day > sessionNumberOfDays) {
                    console.log("Max number of days reached.");
                    scheduler.cancel_lightbox();
                    $('#modalError').modal('show');
                    return false;
                }
            }
        }
        return true;
    });

    scheduler.attachEvent("onBeforeEventChanged", function (id, data) {
        return true;
    });

    dp.attachEvent("onAfterUpdate", function (id, action, tid, rep) {
        count = rep["COUNT"];
        isSession = rep["SESSION"];
        if (isSession) {
            if (count >= sessionNumberOfDays) {
                toggleDivClass(divMaxError, false, "hidden");
            } else {
                toggleDivClass(divMaxError, true, "hidden");
            }
        }
        if (rep['color'] !== null && rep['textColor'] !== null) {
            var event = scheduler.getEvent(tid);
            event.color = rep['color'];
            event.textColor = rep['textColor'];
            scheduler.render_view_data();
        }
    });
}

function calculDays(ms) {
    var hour = ms / 1000 / 3600;
    var day = 0;
    if (hour <= 4) {
        day = 0.5;
    } else if (hour <= 8) {
        day = 1;
    } else {
        day = Math.ceil(hour / 24);
    }
    return day;
}