<?php
//error_reporting(0);
include_once('db.php'); 
$data = array();

//$vno = $_GET["vehicle_no"];
$environment ="DEVELOPMENT";
$appname = $_POST["appname"];
$appversion = $_POST["appversion"];
$deviceuid = $_POST["deviceuid"];
$devicetoken = $_POST["devicetoken"];
$devicename = $_POST["devicename"];
$devicemodel = $_POST["devicemodel"];
$deviceversion =$_POST["deviceversion"];
$pushbadge = $_POST["pushbadge"];
$pushalert = $_POST["pushalert"];
$pushsound =$_POST["pushsound"];
$clientid = $_POST["clientid"];
$query = "INSERT INTO `apns_devices`
				VALUES (
					NULL,
					'{$clientid}',
					'{$appname}',
					'{$appversion}',
					'{$deviceuid}',
					'{$devicetoken}',
					'{$devicename}',
					'{$devicemodel}',
					'{$deviceversion}',
					'{$pushbadge}',
					'{$pushalert}',
					'{$pushsound}',
					'{$environment}',
					'active',
					NOW(),
					NOW()
				)
				ON DUPLICATE KEY UPDATE
				# If not using real UUID (iOS5+), uid may change on reinstall.
				`deviceuid`='{$deviceuid}',
				`devicetoken`='{$devicetoken}',
				`appversion`='{$appversion}',
				`devicename`='{$devicename}',
				`devicemodel`='{$devicemodel}',
				`deviceversion`='{$deviceversion}',
				`pushbadge`='{$pushbadge}',
				`pushalert`='{$pushalert}',
				`pushsound`='{$pushsound}',
				`development`='{$environment}',
				`status`='active',
				`modified`=NOW();";
$result = mysql_query($query,$connection);


$data=array(
"message"=>"done"
);	
echo json_encode($data);
mysql_close($connection);

?>