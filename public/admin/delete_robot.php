<?php
	require_once ("../../includes/class_lib.php");
	session_start();
	
	//make sure the user is logged in
	$utils->confirm_logged_in();
	
	$result = $utils->deleteRobot($_GET["id"]);
	
	if ($result > 0) {
	    // Success
	    //$_SESSION["message"] = "Admin deleted.";
	    $utils->redirect_to("manage_robots.php");
	  } else {
	    // Failure
	    //$_SESSION["message"] = "Admin deletion failed.";
	    //redirect_to("manage_admins.php");
	    echo "error deleting robot";
	  }
	
	
?>
<!DOCTYPE html>