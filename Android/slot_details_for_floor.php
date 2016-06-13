<?php
error_reporting(0);
include_once('db.php'); 
$data = array();
$floor_id = $_GET['floor'];
$query = "SELECT booking_slot,slotname,floorname,vehiclenumber,book_timein,book_timeout FROM bookings WHERE floorid='$floor_id' AND status='Occupied' AND isReserved='No' AND book_timeout IS NULL ORDER BY slotname ASC";
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
else
{
	$data=array(
"message"=>"No Data"
);	
echo json_encode($data);
	}


mysql_close($connection);
?>