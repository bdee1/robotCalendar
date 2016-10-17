<?php
  require_once ("../includes/class_lib.php");

  $start = (empty($_GET['start']))?date('Y-m-01 00:00:00'):$_GET['start'];
  $end   = (empty($_GET['end']))?date('Y-m-t 00:00:00', strtotime($start)):$_GET['end']; 
  echo $utils->getEventsJSON($start, $end);
?>
