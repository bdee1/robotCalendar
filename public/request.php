<!DOCTYPE html>
<?php
	require_once ("../includes/class_lib.php");
	$qryRobots = $utils->getRobotTypes();
	$message = "";
	$submitted = false;
	session_start();


	$name = "";
	$email = "";
	$district = "";
	$gradeLevel = "";
	$start_date = "";
	$end_date = "";
	$robotType = 0;

	if (isset($_POST['submit'])) {
		//form was submitted

		$name = $_POST["name"];
		$email = $_POST["email"];
		$district = $_POST["district"];
		$gradeLevel = $_POST["gradeLevel"];
		$start_date = $_POST["start_date"];
		$end_date = $_POST["end_date"];
		$robotType = $_POST["robot"];


		//validations
		$required_fields = array("name", "email", "district", "start_date");
		$utils->validate_required($required_fields);
		$utils->validate_honeypot('lname');

		if (empty($utils->errors)) {
			//process form
			$submitted = true;
			$utils->insertRobotRequest($_POST);
		}
	}
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Robot Reservation Request Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css" />
    <link href="css/style.css" rel="stylesheet">
  </head>
  <body>

    <div class="text-center">
	    <h1>Robot Reservation Request Form</h1>
    </div>
    <div class="container">
    	<?php
	      if (!$submitted) {
		?>
			<?php echo $message; ?>
			<?php echo $utils->form_errors($utils->errors); ?>
			<p>
				Fill out this form to request one of our robots for your district.
			</p>
			<form method="post">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="name">Your Name</label>
							<input type="text" class="form-control" name="name" id="name" placeholder="Enter your name" value="<?php echo $name; ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="name">Your Email</label>
							<input type="text" class="form-control" name="email" id="email" placeholder="Enter your Email Address" value="<?php echo $email; ?>">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="district">District</label>
							<input type="district" class="form-control" name="district" id="district" placeholder="Enter your school district" value="<?php echo $district; ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="gradeLevel">Grade Level</label>
							<select class="form-control" name="gradeLevel" id="gradeLevel">
								<option value="k" <?php echo $gradeLevel == 'k'?' selected="selected"':''; ?>>K</option>
								<?php
								for ($i = 1; $i<= 12; $i++) {
									?>
										<option value="<?php echo $i; ?>" <?php echo $gradeLevel == $i?' selected="selected"':''; ?>><?php echo $i; ?></option>
									<?php
								}
							?>
							</select>
						</div>
					</div>
				</div>



				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="start_date">Start Date</label>
							<input type="text" class="form-control datetimepicker" name="start_date" id="start_date" placeholder="mm/dd/yyyy" value="<?php echo $start_date; ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="end_date">End Date</label>
							<input type="text" class="form-control datetimepicker" name="end_date" id="end_date" placeholder="mm/dd/yyyy" value="<?php echo $end_date; ?>">
						</div>
					</div>
				</div>

				<div class="form-group">
					<label for="robot">Robot Type</label>
					<select class="form-control" name="robot[]" id="robot" multiple="multiple">
						<option value="">Choose a Robot</option>
						<?php
						//loop over the database values
						while ($row = mysqli_fetch_assoc($qryRobots)) {
						?>
							<option value="<?php echo $row["id"];?>" <?php echo $robotType == $row["id"]?' selected="selected"':''; ?>><?php echo $row["title"];?></option>
						<?php
						}
						?>
					</select>
				</div>

				<div class="form-group form-test">
					<label for="lname">Last Name</label>
					<input type="text" class="form-control" name="lname" id="lname" placeholder="Enter your last name" value="">
				</div>

				<button type="submit" name="submit" class="btn btn-primary">Submit Request</button>
			</form>
	    <?php
			} else {
		?>
			<h2>Success!</h2>
			<p>Your request has been submitted</p>
			<?php
		        //make sure the user is logged in
				if (isset($_SESSION['admin_id'])) {
				?>
					<a href="./admin/admin.php"><< Go Back to the Admin Dashboard</a>
				<?php
				} else {
					?>
						<a href="index.php"><< Go Back to the Calendar</a>
					<?php
				}
			?>


		<?php
			}
		?>
    </div>

    <script src="js/jquery.js"></script>
    <script src="js/fullCalendar/moment.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-datetimepicker.min.js"></script>
    <script src="js/script.js"></script>

  </body>
</html>
