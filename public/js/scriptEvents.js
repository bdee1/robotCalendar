$(document).ready(function() {
	//initialize the calendar...
    if (jQuery().fullCalendar) {
	    $('.responsive-calendar').fullCalendar({
	        // put your options and callbacks here
	        editable: false,
			events: 'eventsjson.php',
			weekends: false
	    });
    }


    if (jQuery().datetimepicker) {
	    //initialize the datepickers
	    $('.datetimepicker').datetimepicker({
			format: 'L',
			viewMode: 'months',
		    widgetPositioning: {
			    horizontal: 'auto',
				vertical: 'top',
			}
	    });
	}
});
