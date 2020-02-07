<?php
	require_once ("../../includes/class_lib.php");
	session_start();
	$username = "";
		
	if (isset($_POST['submit'])) {
		//process the form
		
		//validations
		$required_fields = array("username", "password");
		$utils->validate_required($required_fields);
		
		if (empty($utils->errors)) {
			//Attempt Login
			
			$username = $_POST["username"];
			$password = $_POST["password"];
			$found_admin = $utils->attempt_login($username, $password);
			
			if ($found_admin) {
				//Success
				//Mark User as logged in
				$_SESSION["admin_id"] = $found_admin["id"];
				$_SESSION["username"] = $found_admin["username"];
				$utils->redirect_to("admin.php");
				echo "logged in!";
			} else {
				//Failure
				$_SESSION["message"] = "username or password was not found";
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Robot Reservation Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-datetimepicker.min.css" />
    <link href="../css/style.css" rel="stylesheet">
  </head>
  <body>
    
    <div class="text-center">
	    <h1>Admin Login</h1>
    </div>
    <div class="container">
		<div class="breadcrumb">
			<a href="../index.php">View Calendar</a>
		</div>
		<p>
			Enter your username and password to enter the admin area.
		</p>
		<?php echo $utils->form_errors($utils->errors); ?>
		<form method="post">
			<div class="form-group">
				<label for="username">Username</label>
				<input type="text" class="form-control" name="username" id="username" placeholder="username" value="<?php echo htmlentities($username); ?>">
			</div>
			<div class="form-group">
				<label for="username">Username</label>
				<input type="password" class="form-control" name="password" id="password" placeholder="password" value="">
			</div>
			
			
			<button type="submit" name="submit" class="btn btn-primary">Submit Request</button>
		</form>
    </div>
    
    <script src="../js/jquery.js"></script>
    <script src="../js/fullCalendar/moment.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-datetimepicker.min.js"></script>
    <script src="../js/script.js"></script>
    
  </body>
</html>
