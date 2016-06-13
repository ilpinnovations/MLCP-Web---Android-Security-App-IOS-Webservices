<?php
//error_reporting(0);
include_once('db.php'); 
$data = array();
$vno = $_GET["vehicle_no"];
$query = "SELECT * FROM mlcp_vehicle WHERE vehiclenumber='$vno'";
$result = mysql_query($query,$connection);
$row = mysql_num_rows($result);
$rows = mysql_fetch_assoc($result);
if($row>=1)
{
$sql1="SELECT * FROM bookings WHERE vehiclenumber='$vno' AND book_timeout IS NULL";
$result1 = mysql_query($sql1,$connection) ;
$rows1 = mysql_fetch_assoc($result1);
$row1 = mysql_num_rows($result1);
if($row1==1){
$book_intime1=  $rows1['book_timein'];
$book_outtime1=$rows1['book_timeout'];
date_default_timezone_set('Asia/Calcutta'); 
$today_date1= date("Y-m-d H:i:s");

$diff = abs(strtotime($today_date1) - strtotime($book_intime1)); 

$years  = floor($diff / (365*60*60*24)); 
$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

$hours  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 
$minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 

$seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60)); 
$data=array(
"duration"=>$hours." hr ".$minuts." m"
);	
$data1=array(
"message"=>"Allocated"
);
//$data1[]=array($rows1,$data)
echo json_encode(array($data1,$rows1,$data));
}
else
{
$data[]=array(
"message"=>"No Allocation."
);	
echo json_encode($data);
}

}
else
{
$data=array(
"message"=>"Not a registered vehicle."
);	
echo json_encode($data);
}
mysql_close($connection);
?>