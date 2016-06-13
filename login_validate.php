	
<?php
error_reporting(0);
include_once('db.php');  
//$uname = $_GET['uname'];
$pass=$_GET['pass'];
$data = array();
if(isset($uname))
{
$query = "SELECT vehiclenumber FROM mlcp_vehicle WHERE vehiclenumber='$pass'";
$result = mysql_query($query,$connection);
$rows = mysql_num_rows($result);
if($rows==1)
{
echo "<div class='12u'>
<strong>Validated Successfully</strong>
</div>";
}
else{
echo "<div class='12u'>
<strong>Not a registered User.</strong>
</div>";
}

}
mysql_close($connection);
?>