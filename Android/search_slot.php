<?php
error_reporting(0);
include_once('db.php'); 
$data = array();
$slot_name=$_POST['slot_name'];
$query4 = "SELECT * FROM mlcp_slot WHERE slotname='$slot_name'";
$result4 = mysql_query($query4,$connection);
$row4 = mysql_fetch_assoc($result4);
$slot_id=$row4['slotid'];

$query = "SELECT * FROM mlcp_booking WHERE slotid='$slot_id' AND book_timeout IS NULL";
$result = mysql_query($query,$connection);
$rows = mysql_num_rows($result);
$row = mysql_fetch_assoc($result);
$vno=$row['vehiclenumber'];
if($rows==1)
{
$query2 = "SELECT * FROM bookings WHERE vehiclenumber='$vno' AND slotid='$slot_id' AND book_timeout IS NULL";
$result2 = mysql_query($query2,$connection);
$row2 = mysql_fetch_assoc($result2);

$data= array ('data'=>$row2,'flag'=>"is_booked",'is_exist'=>true);
echo json_encode($data);
}
else
{
$query3 = "SELECT * FROM mlcp_slot WHERE slotid='$slot_id'";
$result3 = mysql_query($query3,$connection);
$row3 = mysql_fetch_assoc($result3);
$rows3=mysql_num_rows($result3);
if($rows3==1)
{
$data= array ('data'=>$row3,'flag'=>"is_empty",'is_exist'=>true);
echo json_encode($data);
	
}
else
{
$data=array(
"flag"=>"Does not exist.",
"is_exist"=>false
);
echo json_encode($data);
}
}


mysql_close($connection);
?>