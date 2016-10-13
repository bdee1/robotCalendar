<!DOCTYPE html>
<?php
	require_once ("../../includes/class_lib.php");
	session_start();
	
	//make sure the user is logged in
	$utils->confirm_logged_in();
	
	$submitted = false;
	$message = "";
	
	//get the values from the database to populate the form
	$qryRobot = $utils->getRobotTypes($_GET["id"]);
	if ($qryRobot){
		$robot = mysqli_fetch_assoc($qryRobot);
	} else {
		$robot["title"] = "";
		$robot["description"] = "";
		$robot["color"] = "";
		$robot["id"] = "";
	}
	
	
	if (isset($_POST['submit'])) {
	//form was submitted
		
		//validations
		$required_fields = array("title", "color");
		$utils->validate_required($required_fields);
		
		$robot["title"] = $_POST["title"];
		$robot["description"] = $_POST["description"];
		$robot["color"] = $_POST["color"];
		
		if (empty($utils->errors)) {
			//process form 
			$submitted = true;
			$utils->updateRobot($_POST);
			$message = "Record has been updated!";
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
	    <h1>Edit Robot Form</h1>
    </div>
    <div class="container">
	    <div class="breadcrumb">
		    <a href="admin.php">Admin Dashboard</a> / <a href="manage_robots.php">Manage Robots</a>
	    </div>
	    <?php if ($message) {?>
	    	<div class="alert alert-success">
				<?php echo $message; ?><br>
			</div>
		<?php } ?>
		<?php echo $utils->form_errors($utils->errors); ?>
		<p>
			Make any necessary changes using the form below.
		</p>
		<form method="post" action="?id=<?php echo $_GET["id"]; ?>&t=<?php echo time(); ?>">
			<input type="hidden" name="id" value="<?php echo $robot["id"]; ?>">
			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label for="name">Robot Type</label>
						<input type="text" class="form-control" name="title" id="title" placeholder="Type of Robot (Nao, Cubelets, ext)" value="<?php echo $robot["title"]; ?>">
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="color">Color</label>
						<input type="text" class="form-control colorpicker" name="color" id="color" placeholder="color" value="<?php echo $robot["color"]; ?>">
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label for="description">Description</label>
				<input type="text" class="form-control" name="description" id="description" placeholder="description" value="<?php echo $robot["description"]; ?>">
			</div>			
			
			<button type="submit" name="submit" class="btn btn-primary">Update Robot</button>
		</form>
    </div>
    
    <script src="../js/jquery.js"></script>
    <script src="../js/fullCalendar/moment.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-colorpicker.min.js"></script>
    <script src="../js/script.js"></script>
    
  </body>
</html>
