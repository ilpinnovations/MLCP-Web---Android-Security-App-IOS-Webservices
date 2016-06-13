<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_mlcp = "107.180.3.85";
$database_mlcp = "mlcpapp";
$username_mlcp = "tcsmlcp";
$password_mlcp = "J@447788";
$mlcp = mysql_pconnect($hostname_mlcp, $username_mlcp, $password_mlcp) or trigger_error(mysql_error(),E_USER_ERROR); 

?>