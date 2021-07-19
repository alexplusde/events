document.addEventListener("DOMContentLoaded", function() {

var calendarEl = document.getElementById('fullcalendar');

var calendar = new FullCalendar.Calendar(calendarEl, {
  plugins: ['dayGrid', 'list', 'bootstrap'],
  locale: 'de',
  header: { center: 'dayGridMonth,timeGridWeek,listWeek' }, // buttons for switching between views

  events: '/?rex-api-call=fullcalendar'
});

calendar.render();
});
