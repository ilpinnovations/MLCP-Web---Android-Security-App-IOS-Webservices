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
echo json_encode($rows);
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