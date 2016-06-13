<?php
error_reporting(0);
include_once('db.php'); 
$data = array();
$floor_name = $_GET['floor_name'];
$query = "SELECT booking_slot,slotname,floorname,vehiclenumber FROM bookings WHERE floorname='$floor_name'";
$result = mysql_query($query,$connection);
$rows = mysql_num_rows($result);
if($rows>=1)
{
while($row = mysql_fetch_assoc($result))
{

$data[]= array ('data1'=>$row);
//$data2=array_merge($data,$data1);
}
//header('content-type:application/json');
echo json_encode($data);
}



mysql_close($connection);
?>