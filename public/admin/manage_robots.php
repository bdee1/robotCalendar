<?php
	require_once ("../../includes/class_lib.php");
	require_once ("../../includes/dBug.php");
	session_start();
	
	//make sure the user is logged in
	$utils->confirm_logged_in();
	
	$qryRobots = $utils->getRobotTypes();

	
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Robot Reservation Request Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-datetimepicker.min.css" />
    <link href="../css/style.css" rel="stylesheet">
  </head>
  <body>
    
    <div class="text-center">
	    <h1>Manage Robots</h1>
    </div>
    <div class="container">
		<div class="breadcrumb">
			<a href="admin.php">Admin Dashboard</a>
		</div>
		<div class="text-left">
			<a class="btn btn-primary" href="add_robot.php">Add New Robot</a><br><br>
		</div>
		<div class="table-respnosive">
			<table class="table">
			<tr>
				<th>Robot Type</th>
				<th>Description</th>
				<th>Color</th>
				<th>Controls</th>
			</tr>
			<?php
				//loop over the database values 
				while ($row = mysqli_fetch_assoc($qryRobots)) {
				?>
					<tr>
						<td><?php echo $row["title"];?></td>
						<td><?php echo $row["description"];?></td>
						<td><span style="color:<?php echo $row["color"];?>"><?php echo $row["color"];?></span></td>
						<td class="controls">
							<a href="edit_robot.php?id=<?php echo urlencode($row["id"]);?>">Edit</a> | <a href="delete_robot.php?id=<?php echo urlencode($row["id"]);?>" onclick="return confirm('Are you sure?');">Delete</a>
						</td>
					</tr>
				<?php
				}
			?>
			</table>
		</div>
    </div>
    
    <script src="../js/jquery.js"></script>
    <script src="../js/fullCalendar/moment.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-datetimepicker.min.js"></script>
    <script src="../js/script.js"></script>
    
  </body>
</html>
