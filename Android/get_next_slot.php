<?php
error_reporting(0);
include_once('db.php'); 
$data = array();


$query = "SELECT * FROM mlcp_floor";
$result = mysql_query($query,$connection);
$rows = mysql_num_rows($result);
if($rows>=1)
{
while($row = mysql_fetch_assoc($result))
{
$floor_id=$row['floorid'];
$query1 = "SELECT * FROM mlcp_slot WHERE floorid='$floor_id' AND status='Free'";
$result1 = mysql_query($query1,$connection);
$row1 = mysql_fetch_assoc($result1);
$totalrows1 = mysql_num_rows($result1);
if($totalrows1>=1 )
{
	$data= $row;
break;

}
else
{
$data= array("floorname"=> "Parking full");
}
}
//header('content-type:application/json');
echo json_encode($data);
}



mysql_close($connection);
?>