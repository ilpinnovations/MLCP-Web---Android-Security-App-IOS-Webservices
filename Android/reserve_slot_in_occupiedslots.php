<?php
error_reporting(0);
include_once('db.php'); 
$data = array();
$slot_id=$_POST['slot_id'];
$vehicle_no=$_POST['vehicle_no'];
//$booked_slot_vno= $_POST['booked_vno'];
date_default_timezone_set('Asia/Calcutta'); 
$today_date1= date("Y-m-d H:i:s");
if(isset($slot_id))
{
$query = "SELECT * FROM mlcp_vehicle WHERE vehiclenumber='$vehicle_no'";
$result = mysql_query($query,$connection);
$rows = mysql_num_rows($result);
$row = mysql_fetch_assoc($result);
$vno=$row['vehiclenumber'];

if($rows==1)
{
$query1 = "SELECT * FROM mlcp_booking WHERE vehiclenumber='$vno' AND book_timeout IS NULL";
$result1 = mysql_query($query1,$connection);
$row1 = mysql_fetch_assoc($result1);
$rows1 = mysql_num_rows($result1);
$booked_slot_id=$row1['slotid'];

$query7 = "SELECT * FROM mlcp_booking WHERE slotid='$slot_id' AND book_timeout IS NULL";
$result7 = mysql_query($query7,$connection);
$row7 = mysql_fetch_assoc($result7);
$booked_slot_vno=$row7['vehiclenumber'];

if($rows1==1)
{
$query2 = "UPDATE mlcp_slot SET status='Occupied',isReserved='No' WHERE slotid='$slot_id'";
$result2 = mysql_query($query2,$connection);

$query3 = "UPDATE mlcp_booking SET isconfirmed='True',book_timein='$today_date1',vehiclenumber='$vno',issecurityupdate='1' WHERE slotid='$slot_id' AND book_timeout IS NULL";
$result3 = mysql_query($query3,$connection);	


$query4 = "UPDATE mlcp_slot SET status='Occupied',isReserved='No' WHERE slotid='$booked_slot_id'";
$result4 = mysql_query($query4,$connection);

$query6 = "SELECT slotname FROM mlcp_slot WHERE slotid='$slot_id'";
$result6= mysql_query($query6,$connection);
$row6 = mysql_fetch_assoc($result6);
$slot_name=$row6['slotname'];

$query5 = "UPDATE mlcp_booking SET isconfirmed='True',book_timein='$today_date1',vehiclenumber='$booked_slot_vno',issecurityupdate='1' WHERE slotid='$booked_slot_id' AND book_timeout IS NULL";
$result5 = mysql_query($query5,$connection);	
if($result5)
{
	echo "Successful";
	$message = "Slot Changed ".$slot_name."";
	$params = array ('message' => $message, 'empid' => $booked_slot_vno);
	$query = http_build_query ($params);
	$contextData = array ( 'method' => 'POST', 'content'=> $query );
	$context = stream_context_create (array ( 'http' => $contextData ));
	$result =  file_get_contents ('http://mymlcp.co.in/gcm/push_notification/gcm.php?push=true', false, $context);
}
}
else
{
echo "Vehicle exists but slot is not booked for this vehicle.";
}
}
else
{
echo "Vehicle not found.";
}
}
mysql_close($connection);
?>