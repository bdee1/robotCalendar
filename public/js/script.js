$(document).ready(function() {
	if (jQuery().datetimepicker) {
	    //initialize the datepickers
	    $('.datetimepicker').datetimepicker({
			format: 'L',
			viewMode: 'months',
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
			customClass: 'colorpicker-2x',
      sliders: {
          saturation: {
              maxLeft: 200,
              maxTop: 200
          },
          hue: {
              maxTop: 200
          },
          alpha: {
              maxTop: 200
          }
      }
		});
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
