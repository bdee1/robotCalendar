<?php
	require_once ("../../includes/class_lib.php");
	require_once ("../../includes/dBug.php");
	session_start();

	//make sure the user is logged in
	$utils->confirm_logged_in();

	$qryRequests = $utils->getRequests();


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
	    <h1>Manage Robot Requests</h1>
    </div>
    <div class="container">
		<div class="breadcrumb">
			<a href="admin.php">Admin Dashboard</a>
		</div>

		<a class="btn btn-primary" href="../request.php">Add New Request</a><br>
		<br>
		<div class="table-responsive">
			<form method="post">
				<table class="table">
				<tr>
					<th>Start Date</th>
					<th>End Date</th>
					<th>Requestor</th>
					<th>District</th>
					<th>Robot</th>
					<!--
					th>Grade Level</th>
					<th>Approved</th>
					-->
					<th>Controls</th>
				</tr>
				<?php
					//loop over the database values
					while ($row = mysqli_fetch_assoc($qryRequests)) {
						$start_date = date('m/d/Y', strtotime($row["start_date"]));
						if($row['end_date']!='0000-00-00 00:00:00'){
							$end_date = date('m/d/Y', strtotime($row["end_date"]));
						} else {
							$end_date = '';
						}
					?>

						<tr>
							<td><?php echo $start_date;?></td>
							<td><?php echo $end_date?></td>

							<td><?php echo $row["requestor"];?></td>
							<td><?php echo $row["district"];?></td>
							<td><?php echo $row["robot"];?></td>

							<!--
							<td><?php echo $row["gradeLevel"];?></td>
							<td>
								<div class="form-check">
								    <input class="bulk_approved" name="bulk_approved" id="approved_<?php echo urlencode($row["id"]);?>" type="checkbox" class="form-check-input" <?php echo $row["approved"] == 1?' checked="checked"':''; ?>>
								</div>

							</td>
							-->
							<td class="controls">
								<a href="edit_request.php?id=<?php echo urlencode($row["id"]);?>">Edit</a> | <a href="delete_request.php?id=<?php echo urlencode($row["id"]);?>" onclick="return confirm('Are you sure?');">Delete</a>
							</td>
						</tr>
					<?php
					}
				?>
				</table>
			</form>
		</div>
    </div>

    <script src="../js/jquery.js"></script>
    <script src="../js/fullCalendar/moment.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-datetimepicker.min.js"></script>
    <script src="../js/script.js"></script>

  </body>
</html>
