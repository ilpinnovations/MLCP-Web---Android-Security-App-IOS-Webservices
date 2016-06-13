<?php
error_reporting(0);
include_once('db.php'); 
$data = array();
$slot_id=$_GET['slot_id'];
$vno=$_GET['vehiclenumber'];
date_default_timezone_set('Asia/Calcutta'); 
$today_date1= date("Y-m-d H:i:s");
$query = "UPDATE mlcp_slot SET status='Free',prevstatus='$slot_id' WHERE slotid='$slot_id'";
$result = mysql_query($query,$connection);

//$query1 = "UPDATE mlcp_booking SET isconfirmed='False', book_timeout='$today_date1' WHERE slotid='$slot_id' AND vehiclenumber='$vno' AND book_timeout IS NULL";

$query1 = "UPDATE mlcp_booking SET isconfirmed='False',issecurityupdate='1', book_timeout='$today_date1' WHERE slotid='$slot_id' AND vehiclenumber='$vno' AND book_timeout IS NULL";

$result1 = mysql_query($query1,$connection);

echo "Slot Released";
 

mysql_close($connection);
?>