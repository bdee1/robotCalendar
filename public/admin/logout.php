<?php
	require_once ("../../includes/class_lib.php");
	session_start();
			
	/*$_SESSION["admin_id"] = null;
	$_SESSION["username"] = null;
	
	$utils->redirect_to("login.php");*/
	
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-42000, '/');
	}
	session_destroy();
	$utils->redirect_to("login.php");
?>