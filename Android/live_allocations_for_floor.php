<?php
error_reporting(0);
include_once('db.php'); 
$data = array();
$floor_name = $_GET['floor'];
$query = "SELECT booking_slot,slotname,floorname,vehiclenumber,book_timein,book_timeout FROM bookings WHERE floorname='$floor_name' AND status='Occupied'";
$result = mysql_query($query,$connection);
$rows = mysql_num_rows($result);

if($rows>=1)
{
date_default_timezone_set('Asia/Calcutta'); 
$today_date= date("Y-m-d h:i:s");

$today_date = date("H:ia",strtotime($today_date));


$start_time1 = strtotime($today_date);
while($row = mysql_fetch_assoc($result))
{
	$intime = $row['book_timein'];

	$intime = date("H:ia",strtotime($intime));
	$end_time1 = strtotime($intime);
	$diff =$start_time1- $end_time1;
	$years   = floor($diff / (365*60*60*24)); 
$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
$hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 
$minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 
$seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60));
if( $years<1 && $days<1 && $hours<1 && $minuts<=30)
{
	//$emp_id=$row['employeeid'];
	//$query1 = "SELECT vehiclenumber FROM mlcp_vehicle WHERE employeeid='$emp_id'";
//$result1 = mysql_query($query1,$connection);
//$vehiclenumber = mysql_fetch_assoc($result1);
//$vno=$vehiclenumber['vehiclenumber'];

$data[]= array ('data1'=>$row);
//$data2=array_merge($data,$data1);
}
}
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