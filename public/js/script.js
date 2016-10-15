$(document).ready(function() {
	//initialize the calendar...
    if (jQuery().fullCalendar) {
	    $('.responsive-calendar').fullCalendar({
	        // put your options and callbacks here
	        editable: false,
	        events: 'eventsjson.php',
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
		    	//alert(calEvent.title);
	        }
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
	
	if (jQuery().colorpicker) {
		//initialize the colorpickers
		$('.colorpicker').colorpicker({
			format: 'hex',
			customClass: 'colorpicker-2x'
		})
	}
	
	//bulk approve ajax function for manage requests page
	$('.bulk_approved').change(function() {
		var approved = 0;
		var robotID = 0;
		
		if ( $(this).is(":checked") ) {
			approved = 1;
			//alert ('approved');
		}
		
		robotID = $(this).attr("id");
		robotID = robotID.split('_')[1];
		
		
		$.ajax({
			url: "bulk_approve.php",
			data: {
				approved: approved,
				robotID: robotID
			},
			type: "POST"
		})
		.done(function() {
			//alert('request complete');	
		});
	});
});