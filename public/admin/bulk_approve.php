<?php
	require_once ("../../includes/class_lib.php");
	session_start();
	
	//make sure the user is logged in
	$utils->confirm_logged_in();
	
	$approved = $_POST["approved"];
	$id = $_POST["robotID"];
	
	$utils->approveRequest($id, $approved);
	
	//echo 'approved!';
	//echo $_POST["approved"];
	//echo $_POST["robotID"];
	
	
?>
<!DOCTYPE html>