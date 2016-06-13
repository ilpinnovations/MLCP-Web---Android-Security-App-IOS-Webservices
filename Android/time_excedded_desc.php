<?php require_once('db.php'); ?>
<?php
error_reporting(0);
$sql1="SELECT * FROM bookings WHERE book_timeout IS NULL ORDER BY book_timein DESC";
$result1 = mysql_query($sql1,$connection) ;
$rows = mysql_num_rows($result1);
while($row1 = mysql_fetch_assoc($result1))
{
$floor_id=$row1['floorid'];
$book_intime1=  $row1['book_timein'];
$book_outtime1=$row1['book_timeout'];
date_default_timezone_set('Asia/Calcutta'); 
$today_date1= date("Y-m-d H:i:s");

$diff = abs(strtotime($today_date1) - strtotime($book_intime1)); 

$years  = floor($diff / (365*60*60*24)); 
$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

$hours  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 

$minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 

$seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60)); 
$vno1=$row1['vehiclenumber'];
	$query2 = "SELECT vehiclenumber FROM mlcp_vehicle WHERE vehiclenumber='$vno1'";
$result2 = mysql_query($query2,$connection);
$vehiclenumber = mysql_fetch_assoc($resul2);
$vno=$vehiclenumber['vehiclenumber'];
if($days>=1 || $hours>=15)
{
$data1[]=array(
"days"=>"".$days."",
"hours"=>"".$hours."",
"minutes"=>"".$minuts."",
"vehicleno"=>"".$vno.""
);	
}
}
echo json_encode(array('data1' =>$row1,'data2'=>$data1));
?>