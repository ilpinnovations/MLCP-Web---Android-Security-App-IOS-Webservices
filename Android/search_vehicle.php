<?php
error_reporting(0);
include_once('db.php'); 
$data = array();

$vehicle_no=$_POST['vehicle_no'];
$query = "SELECT * FROM mlcp_vehicle WHERE vehiclenumber='$vehicle_no'";
$result = mysql_query($query,$connection);
$rows = mysql_num_rows($result);
$row = mysql_fetch_assoc($result);
$vno=$row['vehiclenumber'];
if($rows==1)
{
$query2 = "SELECT * FROM bookings WHERE vehiclenumber='$vno' AND book_timeout IS NULL";
$result2 = mysql_query($query2,$connection);
$row2= mysql_fetch_assoc($result2);
$rows1 = mysql_num_rows($result2);
if($rows1==1)
{

$data= array ('data'=>$row2,'flag'=>"is_booked",'is_exist'=>true);
echo json_encode($data);	
}
else
{
$query3= "SELECT * FROM mlcp_vehicle WHERE vehiclenumber='$vno'";
$result3 = mysql_query($query3,$connection);
$row3= mysql_fetch_assoc($result3);
$data= array ('data1'=>$row,'data2'=>$row3,'flag'=>"is_vehicle",'is_exist'=>true);
echo json_encode($data);	
}
}

else
{
$data=array(
"is_exist"=>false
);	
echo json_encode($data);	
}

mysql_close($connection);
?>