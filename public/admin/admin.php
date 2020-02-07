<?php 
	session_start(); 
	require_once ("../../includes/class_lib.php");
	
	//make sure the user is logged in
	$utils->confirm_logged_in();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
	<script src="https://use.fontawesome.com/ee44f3c44e.js"></script>
    <meta charset="utf-8">
    <title>Robot Reservation Admin dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-datetimepicker.min.css" />
    <link href="../css/style.css" rel="stylesheet">
  </head>
  <body>
    
    <div class="text-center">
	    <h1>Admin Dashboard</h1>
    </div>
    <div class="container">
		<p>
			Welcome to the admin area, <?php echo htmlentities($_SESSION["username"]); ?>
		</p>
		
		<h3>Actions</h3>
		<ul class="admin-nav">
			<li><i class="fa fa-files-o" aria-hidden="true"></i>  <a href="manage_requests.php">Manage Requests</a></li>
			<li><i class="fa fa-android" aria-hidden="false"></i>  <a href="manage_robots.php">Manage Robots</a></li>
			<li><i class="fa fa-calendar" aria-hidden="true"></i>  <a href="../index.php">View Calendar</a></li>
			<li><i class="fa fa-sign-out" aria-hidden="true"></i>  <a href="logout.php">Log Out</a></li>
		</ul>
	</div>
    
    <script src="../js/jquery.js"></script>
    <script src="../js/fullCalendar/moment.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-datetimepicker.min.js"></script>
    <script src="../js/script.js"></script>
    
  </body>
</html>
