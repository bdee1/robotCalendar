$(document).ready(function() {
	//initialize the calendar...
    if (jQuery().fullCalendar) {
	    $('.responsive-calendar').fullCalendar({
	        // put your options and callbacks here
	        editable: false,
	        events: 'eventsjson.php',
	    });
    }


    if (jQuery().datetimepicker) {
	    //initialize the datepickers
	    $('.datetimepicker').datetimepicker({
		    format: 'L',
		    widgetPositioning: {
			    horizontal: 'auto',
			    vertical: 'top'
		    }
	    });
	}
});
