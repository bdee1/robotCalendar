<!DOCTYPE html>
<?php
	require_once ("../../includes/class_lib.php");
	session_start();
	
	//make sure the user is logged in
	$utils->confirm_logged_in();
	
	$submitted = false;
	$message = "";
	
	$qryRobots = $utils->getRobotTypes();
	
	//get the values from the database to populate the form
	$qryRequest = $utils->getRequests($_GET["id"]);
	if ($qryRequest){
		$request = mysqli_fetch_assoc($qryRequest);
		$request["start_date"] = date('m/d/Y', strtotime($request["start_date"]));
		if($request['end_date']!='0000-00-00 00:00:00'){
			$request["end_date"] = date('m/d/Y', strtotime($request["end_date"]));
		} else {
			$request["end_date"] = $request["start_date"];
		}
	} else {
		//if we did not find the record in the db, set defaults
		$request["requestor"] = "";
		$request["district"] = "";
		$request["gradeLevel"] = "";
		$request["start_date"] = "";
		$request["end_date"] = "";
		$request["robotID"] = "";
		$request["email"] = "";
		$request["approved"] = 0;
		$request["id"] = "";
	}
	
	if (isset($_POST['submit'])) {
	//form was submitted

		//set the request array to the submitted values instead of the db values
		$request["requestor"] = $_POST["name"];
		$request["district"] = $_POST["district"];
		$request["gradeLevel"] = $_POST["gradeLevel"];
		$request["start_date"] = $_POST["start_date"];
		$request["end_date"] = $_POST["end_date"];
		$request["robotID"] = $_POST["robot"];
		$request["email"] = $_POST["email"];
		$request["approved"] = $_POST["approved"];

		
		//validations
		$required_fields = array("name", "email", "district", "start_date", "robot");
		$utils->validate_required($required_fields);
		
		if (empty($utils->errors)) {
			//process form
			$submitted = true;
			$utils->updateRobotRequest($_POST);
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
	    <h1>Edit Request Form</h1>
    </div>
    <div class="container">
	    <div class="breadcrumb">
		    <a href="admin.php">Admin Dashboard</a> / <a href="manage_requests.php">Manage Requests</a>
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
		<form method="post">
			<input type="hidden" name="id" id="id" value="<?php echo $request["id"]; ?>">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="name">Your Name</label>
						<input type="text" class="form-control" name="name" id="name" placeholder="Enter your name" value="<?php echo $request["requestor"]; ?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="name">Your Email</label>
						<input type="text" class="form-control" name="email" id="email" placeholder="Enter your email address" value="<?php echo $request["email"]; ?>">
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="district">District</label>
						<input type="district" class="form-control" name="district" id="district" placeholder="Enter your school district" value="<?php echo $request["district"]; ?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="gradeLevel">Grade Level</label>
						<select class="form-control" name="gradeLevel" id="gradeLevel">
							<option value="k" <?php echo $request["gradeLevel"] == 'k'?' selected="selected"':''; ?>>K</option>
							<?php
								for ($i = 1; $i<= 12; $i++) {
									?>
										<option value="<?php echo $i; ?>" <?php echo $request["gradeLevel"] == $i?' selected="selected"':''; ?>><?php echo $i; ?></option>		
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
						<input type="text" class="form-control datetimepicker" name="start_date" id="start_date" placeholder="mm/dd/yyyy" value="<?php echo $request["start_date"]; ?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="end_date">End Date</label>
						<input type="text" class="form-control datetimepicker" name="end_date" id="end_date" placeholder="mm/dd/yyyy" value="<?php echo $request["end_date"]; ?>">
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label for="robot">Robot Type</label>
				<select class="form-control" name="robot" id="robot">
					<option value="">Choose a Robot</option>
					<?php 
					//loop over the database values 
					while ($row = mysqli_fetch_assoc($qryRobots)) {
					?>
						<option value="<?php echo $row["id"];?>" <?php echo $request["robotID"] == $row["id"]?' selected="selected"':''; ?>><?php echo $row["title"];?></option>	
					<?php
					}
					?>
				</select>
			</div>
			
			<fieldset class="form-group">
			    <legend>Approved</legend>
			    <div class="form-check">
			      <label class="form-check-label">
			        <input type="radio" class="form-check-input" name="approved" id="approved_yes" value="1" <?php echo $request["approved"] == 1?' checked="checked"':''; ?>>
			        Yes
			      </label>
			    </div>
			    <div class="form-check">
			    <label class="form-check-label">
			        <input type="radio" class="form-check-input" name="approved" id="approved_no" value="0" <?php echo $request["approved"] == 0?' checked="checked"':''; ?>>
			        No
			      </label>
			    </div>
			  </fieldset>
			
			<button type="submit" name="submit" class="btn btn-primary">Update Request</button>
		</form>
    </div>
    
    <script src="../js/jquery.js"></script>
    <script src="../js/fullCalendar/moment.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-colorpicker.min.js"></script>
    <script src="../js/script.js"></script>
    
  </body>
</html>
