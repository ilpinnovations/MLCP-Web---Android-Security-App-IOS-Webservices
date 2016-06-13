<?php
$db_username = "tcsmlcp";
$db_password = "J@447788";
$db_host = "107.180.3.85";
$db_name = "mlcpapp";
$connection = mysql_connect($db_host,$db_username,$db_password) or die('Cannot connect to Database');
mysql_select_db($db_name,$connection) or die('Error selecting Database');

?>