var calendar;
var Calendar = FullCalendar.Calendar;
var events = [];

$(function() {

    //     if (!!scheds) {
    //     Object.keys(scheds).map(k => {
    //         var row = scheds[k];
    //         if (row.start_datetime && row.end_datetime) {
    //             events.push({ id: row.id, title: row.title, start: row.start_datetime, end: row.end_datetime, client_name: row.first_name + ' ' + row.last_name });
    //         }
    //     });
    // }

    // Function to check if a given time is in the range of 8 am to 5 pm
    function isTimeInRange(datetime) {
        var startOfDay = new Date(datetime);
        startOfDay.setHours(8, 0, 0, 0); // Set time to 8:00 AM

        var endOfDay = new Date(datetime);
        endOfDay.setHours(17, 0, 0, 0); // Set time to 5:00 PM

        return datetime >= startOfDay && datetime <= endOfDay;
    }

    if (!!scheds) {
        Object.keys(scheds).map(k => {
            var row = scheds[k];

            // Parse start and end datetime strings into Date objects
            var startDatetime = new Date(row.start_datetime);
            var endDatetime = new Date(row.end_datetime);

            // Check if the event is in the future and within the time range
            if (startDatetime > new Date() && isTimeInRange(startDatetime) && isTimeInRange(endDatetime)) {
                var formattedClientName = row.first_name + '-' + row.last_name;
                var caseNumber = row.case_number || 'NoCaseNumber'; // If case_number is undefined, use a default value
                

                events.push({
                    id: row.id,
                    title: row.title,
                    start: startDatetime,
                    end: endDatetime,
                    client_name: formattedClientName,
                    case_number: caseNumber,
                    backgroundColor: 'blue', // Default color for regular events
                });
            } else {
                console.warn('Invalid event date:', row);
            }
        });
    }

    // Fetch holidays and add them to the events array with special styling
    // You might fetch this list from the server or use a predefined list
    var holidays = [
        { title: 'New Year\'s Day', start: '2024-01-01', backgroundColor: 'red'},
        { title: 'Christmas Day', start: '2024-12-25', backgroundColor: 'red', note: 'Holiday' },
        { title: 'Maundy Thursday', start: '2024-03-28', backgroundColor: 'red', note: 'Holiday' },
        { title: 'Good Friday', start: '2024-03-29', backgroundColor: 'red', note: 'Holiday' },
        { title: 'Araw ng Kagitingan', start: '2024-04-09', backgroundColor: 'red', note: 'Holiday' },
        { title: 'Labor Day', start: '2024-05-01', backgroundColor: 'red', note: 'Holiday' },
        { title: 'Independence Day', start: '2024-06-12', backgroundColor: 'red', note: 'Holiday' },
        { title: 'National Heroes Day', start: '2024-08-26', backgroundColor: 'red', note: 'Holiday' },
        { title: 'Bonifacio Day', start: '2024-11-30', backgroundColor: 'red', note: 'Holiday' },
        { title: 'Rizal Day', start: '2024-12-30', backgroundColor: 'red', note: 'Holiday' },
        // Add more holidays as needed
    ];


    events = events.concat(holidays);
    // events = holidays;


    var date = new Date()
    var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear(),

    calendar = new Calendar(document.getElementById('calendar'), {
        headerToolbar: {
            left: 'prev,next today',
            right: 'dayGridMonth,dayGridWeek,list',
            center: 'title',
        },
        selectable: true,
        themeSystem: 'bootstrap',
        events: events,

        eventClick: function(info) {
            var details = $('#event-details-modal');
            var id = info.event.id;

            if (!!scheds[id]) {
                details.find('#title').text(scheds[id].title);
                details.find('#case').text(scheds[id].case_number);
                details.find('#description').text(scheds[id].description);
                details.find('#start').text(scheds[id].sdate);
                details.find('#end').text(scheds[id].edate);

                // Retrieve the note from the extendedProps
                var note = info.event.extendedProps.note;
                if (note) {
                    var noteElement = document.createElement('div');
                    noteElement.innerHTML = '<strong>' + note + '</strong>';
                    details.find('.modal-body').append(noteElement);
                }

                details.find('#edit,#delete').attr('data-id', id);
                details.modal('show');
            } else {
                alert("Event is undefined");
            }
        },
        
        eventDidMount: function(info) {
             // Customize the display of events
        if (info.event.backgroundColor === 'red') {
            // Set the note as an extended property of the event
            info.event.setExtendedProp('note', 'Holiday');
        }

        // Retrieve the note from the extendedProps
        var note = info.event.extendedProps.note;
        if (note) {
            // Add a noteElement to the modal body
            var noteElement = document.createElement('div');
            noteElement.innerHTML = '<strong>' + note + '</strong>';
            $(info.event.el).find('.fc-content').append(noteElement);
        }
    },
        editable: true
    });

    calendar.render();

    // Form reset listener
    $('#schedule-form').on('reset', function() {
        $(this).find('input:hidden').val('');
        $(this).find('input:visible').first().focus();
    });

    // Edit Button
    $('#edit').click(function() {
        var id = $(this).attr('data-id');

        if (!!scheds[id]) {
            var form = $('#schedule-form');

            console.log(String(scheds[id].start_datetime), String(scheds[id].start_datetime).replace(" ", "\\t"));
            form.find('[name="id"]').val(id);
            form.find('[name="title"]').val(scheds[id].title);
            form.find('[name="case_number"]').val(scheds[id].case_number);
            form.find('[name="description"]').val(scheds[id].description);
            form.find('[name="start_datetime"]').val(String(scheds[id].start_datetime).replace(" ", "T"));
            form.find('[name="end_datetime"]').val(String(scheds[id].end_datetime).replace(" ", "T"));
            $('#event-details-modal').modal('hide');
            form.find('[name="title"]').focus();
        } else {
            alert("Event is undefined");
        }
    });

    // Delete Button / Deleting an Event
    $('#delete').click(function() {
        var id = $(this).attr('data-id');

        if (!!scheds[id]) {
            var _conf = confirm("Are you sure to delete this scheduled event?");
            if (_conf === true) {
                location.href = "./delete_schedule.php?id=" + id;
            }
        } else {
            alert("Event is undefined");
        }
    });
});

