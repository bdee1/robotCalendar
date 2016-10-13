<!DOCTYPE html>
<?php
	require_once ("../../includes/class_lib.php");
	session_start();
	
	//make sure the user is logged in
	$utils->confirm_logged_in();
	
	$submitted = false;
	$message = "";

	$title = "";
	$description = "";
	$color = "";
	
	if (isset($_POST['submit'])) {
	//form was submitted
		
		//validations
		$required_fields = array("title", "color");
		$utils->validate_required($required_fields);
		
		$title = $_POST["title"];
		$description = $_POST["description"];
		$color = $_POST["color"];
		
		if (empty($utils->errors)) {
			//process form 
			$submitted = true;
			$utils->insertRobot($_POST);
		}
	}
	
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Edit Robot Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-colorpicker.min.css" />
    <link href="../css/style.css" rel="stylesheet">
  </head>
  <body>
    
    <div class="text-center">
	    <h1>Add Robot Form</h1>
    </div>
    <div class="container">
	    <div class="breadcrumb">
		    <a href="admin.php">Admin Dashboard</a> / <a href="manage_robots.php">Manage Robots</a>
	    </div>
		    
	    <?php echo $message; ?><br>
		<?php 
	      if (!$submitted) {
		?>
			<p>
				enter the new robot information using the form below.
			</p>
			<?php echo $utils->form_errors($utils->errors); ?>
			<form method="post">
				<div class="row">
					<div class="col-md-9">
						<div class="form-group">
							<label for="name">Robot Type</label>
							<input type="text" class="form-control" name="title" id="title" placeholder="Type of Robot (Nao, Cubelets, etc)" value="<?php echo $title; ?>">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="color">Color</label>
							<input type="text" class="form-control colorpicker" name="color" id="color" placeholder="color" value="<?php echo $color; ?>">
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label for="description">Description</label>
					<input type="text" class="form-control" name="description" id="description" placeholder="description" value="<?php echo $description; ?>">
				</div>
				
				<button type="submit" name="submit" class="btn btn-primary">Add Robot</button>
			</form>
		<?php
			} else {
		?>	
			<h2>Success!</h2>
			<p>The new record has been added!</p>
			
		<?php	
			}
		?>
    </div>
    
    <script src="../js/jquery.js"></script>
    <script src="../js/fullCalendar/moment.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-colorpicker.min.js"></script>
    <script src="../js/script.js"></script>
    
  </body>
</html>
