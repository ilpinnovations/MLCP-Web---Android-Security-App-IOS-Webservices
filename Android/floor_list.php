<?php
error_reporting(0);
include_once('db.php'); 
$data = array();
$query = "SELECT floorid,floorname,noofslots FROM mlcp_floor";
$result = mysql_query($query,$connection);
$rows = mysql_num_rows($result);
if($rows>=1)
{
while($row = mysql_fetch_assoc($result))
{
	$floorid=$row['floorid'];
	$floorname=$row['floorname'];
	$noofslots=$row['noofslots'];

$sql1="SELECT count(*) AS booked_count FROM mlcp_slot WHERE floorid='$floorid' AND status='Occupied'";
$result1 = mysql_query($sql1,$connection);
$booked_count = mysql_fetch_assoc($result1);

$sql2="SELECT count(*) AS free_count FROM mlcp_slot WHERE floorid='$floorid' AND status='Free'";
$result2 = mysql_query($sql2,$connection);
$free_count = mysql_fetch_assoc($result2);

$sql3="SELECT floorid,floorname,noofslots FROM mlcp_floor WHERE floorid='$floorid'";
$result3 = mysql_query($sql3,$connection);
$level = mysql_fetch_assoc($result3);

$data[]= array(
 'data1'=>$booked_count,
'data2'=>$free_count,
'data3'=>$level
);	


}
echo json_encode(array('data' =>$data));
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