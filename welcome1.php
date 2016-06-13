<?php require_once('Connections/mlcp.php'); ?>
<?php

error_reporting(E_ERROR);
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_Recordset1 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset1 = $_SESSION['MM_Username'];
}
mysql_select_db($database_mlcp, $mlcp);
$query_Recordset1 = sprintf("SELECT * FROM mlcp_vehicle WHERE vehiclenumber='$colname_Recordset1'");
$Recordset1 = mysql_query($query_Recordset1, $mlcp) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$vno= $row_Recordset1['vehiclenumber'];
$name= $row_Recordset1['vehiclenumber'];

?>
<?php
$sql="SELECT * FROM bookings WHERE vehiclenumber='$vno' AND book_timeout IS NULL";
$result = mysql_query($sql,$mlcp) ;
$totalRows = mysql_num_rows($result);

$sql1="SELECT * FROM bookings WHERE vehiclenumber='$vno' AND book_timeout IS NULL";
$result1 = mysql_query($sql1,$mlcp) ;
$row1 = mysql_fetch_assoc($result1);
$rows = mysql_num_rows($result1);
$floor_id=$row1['floorid'];
$book_intime1=  $row1['book_timein'];
$book_outtime1=$row1['book_timeout'];
date_default_timezone_set('Asia/Calcutta'); 
$today_date1= date("Y-m-d H:i:s");

$diff = abs(strtotime($today_date1) - strtotime($book_intime1)); 

$years  = floor($diff / (365*60*60*24)); 
$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

$hours  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 

$minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 

$seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60)); 

$sql7="SELECT count(*) AS booked_counts FROM mlcp_slot WHERE floorid='$floor_id' AND status='Occupied'";
$result7 = mysql_query($sql7,$mlcp);
$row7 = mysql_fetch_assoc($result7);
$booked_count= $row7['booked_counts'];
$sql8="SELECT count(*) AS booked_count FROM mlcp_slot WHERE floorid='$floor_id' AND status='Free'";
$result8 = mysql_query($sql8,$mlcp);
$row8 = mysql_fetch_assoc($result8);
$slots_remaining= $row8['booked_count'];
$totalslot=$booked_count+$slots_remaining;
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>MLCP | Welcome</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
        <script src="pace.js"></script>
 <link href="pace.css" rel="stylesheet" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
        <style type="text/css">
		#info 
		{
		position: fixed;
		bottom: 0;	
		background-color:white;
		text-align:left;
		width:100%;
		margin-right:10px;
		padding:15px;
		}
		.box.special1 {
			padding:10px;
			background-color:white;
			height: 230px;
		
			
		}
#tests {
    display:none;
}
#test:hover + #parent-content {
    display:block;
}
#verticalLine {
     width: 0px; /* Use only border style */
  height: 100%;
  float: left; 
  border: 1px inset; 
}
#horizontalLine
{
     width: 10px; /* Use only border style */
  height: 0px;
  float: left; 
  border: 1px inset; 
}
hr {   
    transform:rotate(90deg);
    -o-transform:rotate(90deg);
    -moz-transform:rotate(90deg);
    -webkit-transform:rotate(90deg);
}
		</style>
        <script>

function get_booking(str)
{
	
if (str=="")
  {
  document.getElementById("editinfo").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
   document.getElementById("main_body").innerHTML = xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","current_booking_ajax.php?q="+str,true);
xmlhttp.send();
}

function get_parking_details(str)
{
	
if (str=="")
  {
  document.getElementById("editinfo").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
   document.getElementById("information").innerHTML = xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","parking_details_ajax.php?a="+str,true);
xmlhttp.send();
}
 
</script>
	</head>
	<body>
		<div id="page-wrapper">

			<!-- Header -->
				<header id="header">
					<h1>Welcome To MLCP</h1>
					<nav id="nav">
						<ul>
                        
                        <li><a href="index.php">Home</a></li>
						 	<!---<li>
								<a href="#" class="icon fa-angle-down">Menu</a>
								<ul>
									<li><a href="index.php#main">About</a></li>
									<li><a href="index.php#features">Features</a></li>
									<!--<li><a href="elements.html">Elements</a></li>
									<li>
										<a href="#">Submenu</a>
										<ul>
											<li><a href="#">Option One</a></li>
											<li><a href="#">Option Two</a></li>
											<li><a href="#">Option Three</a></li>
											<li><a href="#">Option Four</a></li>
										</ul>
									</li>
								</ul>
							</li>-->
                          <li><a href="<?php echo $logoutAction ?>" class="button">Logout</a></li>                           
						</ul>
					</nav>
				</header>
	<!-- Main -->
				<section id="main" class="container1">
					<header>
						<h2>Parking Details</h2>
						<?php
						if($rows!=0)
						{
						if($days>=1 || $hours>=15)
						{
							echo "<h4>Your vehicle is parked for more than 15 Hours</h4>";
						}
						}
						
						
						?>
					</header>
                    <div id="main_body">                    
                    <div class='row'>
					<div class='3u 12u(narrower)'>
                   <p>&nbsp;</p>
					</div>
                    <div class='6u 12u(narrower)'>
                    <section class='box'>
                    <?php
					if($rows==0)
					{
						echo "<div class='6u'>
                     <b>Sorry, You have not used MLCP</b>
                     
                     </div>";
					}
					else
					{
					while ($row = mysql_fetch_assoc($result)){
						
$level= $row['floorname'];
$floorid= $row['floorid'];
$total_slots = $row['noofslots'];
$slot_name =  $row['slotname'];
$book_intime=  $row['book_timein'];
$book_outtime= $row['book_timeout'];
$book_intime2 = date("D,jMY H:i",strtotime($book_intime));
$intime_state = date("A",strtotime($book_intime));
$book_outtime = date("H:i",strtotime($book_outtime));
$outtime_state = date("A",strtotime($book_outtime));
date_default_timezone_set('Asia/Calcutta'); 
$today_date= date("Y-m-d H:i:s");


$diffe = abs(strtotime($today_date) - strtotime($book_intime)); 

$years1   = floor($diffe / (365*60*60*24)); 
$months1  = floor(($diffe - $years1 * 365*60*60*24) / (30*60*60*24)); 
$days1    = floor(($diffe - $years1 * 365*60*60*24 - $months1*30*60*60*24)/ (60*60*24));

$hours1  = floor(($diffe - $years1 * 365*60*60*24 - $months1*30*60*60*24 - $days1*60*60*24)/ (60*60)); 

$minuts1  = floor(($diffe - $years1 * 365*60*60*24 - $months1*30*60*60*24 - $days1*60*60*24 - $hours1*60*60)/ 60); 

$seconds1 = floor(($diffe - $years1 * 365*60*60*24 - $months1*30*60*60*24 - $days1*60*60*24 - $hours1*60*60 - $minuts1*60)); 

				echo"<div class='12u'>
				<table class='table table-striped' align='center'>
   
    <tbody>
	 <tr>
        <td>Vehicle Number</td>
        <td>".$vno."</td>
        
      </tr>
      <tr>
        <td>Level</td>
        <td>".$level."</td>
        
      </tr>
	   <tr>
        <td>Slot Name</td>
        <td>".$slot_name ."</td>
        
      </tr>
      <tr>
        <td>Total Slots</td>
        <td>".$totalslot ."</td>
        
      </tr>
	  <tr>
        <td>Free Slots</td>
        <td>". $slots_remaining ."</td>
        
      </tr>
      <tr>
        <td>Entry Date & Time</td>
        <td>". $book_intime2 ." ".$intime_state."</td>
        
      </tr>
	  <tr>
        <td>Slots Occupied</td>
        <td>". $booked_count ."</td>
        
      </tr>
	  
	  <tr>
        <td>Parking Duration</td>
        <td>".$days1." Days ". $hours1." Hours ". $minuts1." Minutes</td>
        
      </tr>
    </tbody>
  </table>";
							
							}
						}
					?>
                    
                 
                    </section>
                    </div>
                    </div>
                   

						
                      
                        
				         
                    </div>
</section>

						</div>
                    
				<footer id="footer">
					<!---<ul class="icons">
						<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
						<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
						<li><a href="#" class="icon fa-github"><span class="label">Github</span></a></li>
						<li><a href="#" class="icon fa-dribbble"><span class="label">Dribbble</span></a></li>
						<li><a href="#" class="icon fa-google-plus"><span class="label">Google+</span></a></li>
					</ul>-->
					<ul class="copyright">
						<li>&copy; ILP Innovations. All rights reserved.</li>
					</ul>
				</footer>

		</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.dropotron.min.js"></script>
			<script src="assets/js/jquery.scrollgress.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>

	</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
