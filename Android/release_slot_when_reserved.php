<?php
error_reporting(0);
include_once('db.php'); 
$data = array();
$slot_id=$_GET['slot_id'];

$query = "UPDATE mlcp_slot SET status='Free',isReserved='No' WHERE slotid='$slot_id'";
$result = mysql_query($query,$connection);

$query1 = "UPDATE mlcp_booking SET isconfirmed='False',book_timeout=now() WHERE slotid='$slot_id' AND book_timeout IS NULL";
$result1 = mysql_query($query1,$connection);

echo "Slot Released";
 

mysql_close($connection);
?>