<!DOCTYPE html>
<?php
	require_once ("../includes/class_lib.php");
	require_once ("../includes/dBug.php");
	$qryRobots = $utils->getRobotTypes();
	session_start();

?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Robot Reservation Calendar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/fullCalendar/fullcalendar.css" rel="stylesheet">
  </head>
  <body>
    <div class="text-center cal-header">
	    <h1>Robots Reservation Calendar</h1>
		<a href="request.php" class="btn btn-danger">
			<i class="fa fa-user-plus" aria-hidden="true"></i>Request a Robot for your district
		</a>
    </div>
    <div class="container calendar-container">
      <!-- Responsive calendar - START -->
    	<div class="responsive-calendar">
      </div>
      <!-- Responsive calendar - END -->
    </div>
    <!-- bootstrap modal for clicked calendar events -->
    <div class="modal fade" id="eventModal" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="modal-title">Modal title</h4>
	      </div>
	      <div class="modal-body">
	        <p>
		        <span class="bold">Date: </span>
		        <span id="eventModalDate"></span>
	        </p>
	        <p>
		        <span class="bold">Requestor: </span>
		        <span id="eventModalRequestor"></span>
	        </p>
	        <p>
		        <span class="bold">District: </span>
		        <span id="eventModalDistrict"></span>
	        </p>
	        <p>
		        <span class="bold">Grade Level: </span>
		        <span id="eventModalGradeLevel"></span>
	        </p>
	        <p>
		        <span class="bold">Robot: </span>
		        <span id="eventModalRobot"></span>
	        </p>
	      </div>
	      <div class="modal-footer">
	        <?php
		        //make sure the user is logged in
				if (isset($_SESSION['admin_id'])) {
				?>
					<a id="eventModalEdit" class="btn btn-default" href="">Edit This Request</a>
				<?php
				}
			?>
			<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

    <h2 class="text-center key-heading">Key</h2>
    <div class="container key-container">
	    <div class="row key-row">
	    <?php
		//loop over the database values
			while ($row = mysqli_fetch_assoc($qryRobots)) {
			?>
				<div class="col-xs-1 key-color" style="background-color: <?php echo $row["color"];?>">
					&nbsp;
				</div>
				<div class="col-sm-2 col-xs-11 key-label">
					<?php echo $row["title"];?>
				</div>

			<?php
			}
		?>
	    </div>
    </div>
    <div class="text-center">
	    <br>
		<a href="admin/admin.php">Admin</a>
    </div>

    <script src="js/jquery.js"></script>
    <script src="js/fullCalendar/moment.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/fullCalendar/fullcalendar.min.js"></script>
    <script src="https://use.fontawesome.com/ee44f3c44e.js"></script>
    <script src="js/script.js"></script>

  </body>
</html>
