$(document).on("rex:ready", function(event, container) {
    // Zugriff auf die Elemente
    console.log('rex:ready');

    let checkbox = document.querySelector('#yform-data_edit-rex_event_date-all_day input[type="checkbox"]');
    if (!checkbox) return;
    let einlass = document.querySelector('#yform-data_edit-rex_event_date-doorTime input[type="time"]');
    let beginn = document.querySelector('#yform-data_edit-rex_event_date-startTime input[type="time"]');
    let ende = document.querySelector('#yform-data_edit-rex_event_date-endTime input[type="time"]');

    // Event-Listener hinzufügen
    checkbox.addEventListener('change', function() {
        if (this.checked) {
            // Wenn die Checkbox aktiviert ist
            einlass.value = '00:00:00';
            beginn.value = '00:00:00';
            ende.value = '00:00:00';

            einlass.readOnly = true;
            beginn.readOnly = true;
            ende.readOnly = true;
        } else {
            // Wenn die Checkbox deaktiviert ist
            einlass.readOnly = false;
            beginn.readOnly = false;
            ende.readOnly = false;
        }
    });
});
