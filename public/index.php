<!DOCTYPE html>
<?php
	require_once ("../includes/class_lib.php");
	require_once ("../includes/dBug.php");
	$qryRobots = $utils->getRobotTypes();
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
		<a href="request.php" class="btn btn-danger">Request a Robot for your district</a>
    </div>
    <div class="container calendar-container">
      <!-- Responsive calendar - START -->
    	<div class="responsive-calendar">
      </div>
      <!-- Responsive calendar - END -->
    </div>
    
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
    <script src="js/script.js"></script>
    
  </body>
</html>
