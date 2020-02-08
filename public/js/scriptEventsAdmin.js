$(document).ready(function() {
	//initialize the calendar...
    if (jQuery().fullCalendar) {
	    $('.responsive-calendar').fullCalendar({
	        // put your options and callbacks here
	        editable: false,
			events: 'eventsjson.php',
			weekends: false,
	        eventClick: function(calEvent, jsEvent, view) {
		        calEvent.start = calEvent.start.format('MM/DD/YYYY');
		        if (calEvent.end) {
			        calEvent.end = calEvent.end.format('MM/DD/YYYY');
			    }
		        var dates = "";
		        if (calEvent.start == calEvent.end || !calEvent.end) {
			        dates = calEvent.start;
		        } else {
			        dates = calEvent.start + ' - ' + calEvent.end;
		        }
		    	$('#eventModal #modal-title').text(calEvent.title);
		    	$('#eventModal #eventModalDate').text(dates);
		    	$('#eventModal #eventModalRequestor').text(calEvent.requestor);
		    	$('#eventModal #eventModalDistrict').text(calEvent.district);
		    	$('#eventModal #eventModalGradeLevel').text(calEvent.gradeLevel);
		    	$('#eventModal #eventModalRobot').text(calEvent.robot);
		    	$('#eventModal #eventModalEdit').attr("href", "./admin/edit_request.php?id="+calEvent.eventid);
		    	$('#eventModal').modal('show');
				}
	    });
    }
});
