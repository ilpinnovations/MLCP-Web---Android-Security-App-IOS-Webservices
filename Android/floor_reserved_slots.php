<?php
error_reporting(0);
include_once('db.php'); 
$data = array();
$floor_id=$_GET['floorid'];

$query = "SELECT * FROM mlcp_slot WHERE floorid='$floor_id' AND isReserved='yes' ORDER BY slotname ASC";
$result = mysql_query($query,$connection);
$rows = mysql_num_rows($result);
if($rows>=1)
{
while($row = mysql_fetch_assoc($result))
{
	$data[]= $row;
}
//header('content-type:application/json');
echo json_encode(array("data"=>$data));
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