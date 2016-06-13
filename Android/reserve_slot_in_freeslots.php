<?php
error_reporting(0);
include_once('db.php'); 
$data = array();
$slot_id=$_POST['slot_id'];
$vehicle_no=$_POST['vehicle_no'];
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
$booking_id = $row1['booking_id'];
if($rows1==1)
{
$query2 = "UPDATE mlcp_slot SET status='Free',isReserved='No' WHERE slotid='$booked_slot_id'";
$result2 = mysql_query($query2,$connection);

$query4 = "SELECT slotname FROM mlcp_slot WHERE slotid='$slot_id'";
$result4 = mysql_query($query4,$connection);
$row4 = mysql_fetch_assoc($result4);
$slot_name=$row4['slotname'];

$query3 = "UPDATE mlcp_booking SET vehiclenumber='$vno',slotid='$slot_id',isconfirmed='True',issecurityupdate='1',book_timein='$today_date1' WHERE booking_id='$booking_id'";
$result3 = mysql_query($query3,$connection);	

//$query4 = "INSERT INTO mlcp_booking(slotid,employeeid,book_timein,isconfirmed) values('$slot_id','$emp_id','$today_date1','True')";
//$result4 = mysql_query($query4,$connection);

$query5 = "UPDATE mlcp_slot SET status='Occupied',isReserved='No',prevstatus='$booked_slot_id' WHERE slotid='$slot_id'";
$result5 = mysql_query($query5,$connection);	
if($query5){
	echo "Successful";
	$message = "Slot Changed ".$slot_name."";
	$params = array ('message' => $message, 'vehiclenumber' => $vno);
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