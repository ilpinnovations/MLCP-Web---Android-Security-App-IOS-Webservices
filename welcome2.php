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
$query_Recordset1 = sprintf("SELECT * FROM mlcp_employee WHERE employeeid='$colname_Recordset1'");
$Recordset1 = mysql_query($query_Recordset1, $mlcp) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$emp_id= $row_Recordset1['employeeid'];
$name= $row_Recordset1['name'];

?>
<?php
$sql="SELECT * FROM bookings WHERE employeeid='$emp_id' ORDER BY book_timein DESC Limit 1";
$result = mysql_query($sql,$mlcp);
$totalRows = mysql_num_rows($result);

$sql1="SELECT * FROM bookings WHERE employeeid='$emp_id' ORDER BY book_timein DESC Limit 1";
$result1 = mysql_query($sql1,$mlcp);
$row1 = mysql_fetch_assoc($result1);
$slot_name1 =  $row1['slotname'];
preg_match("/([a-zA-Z]+)(\\d+)/", $slot_name1, $matches);
$newslot=$matches[2];
$book_intime1=  $row1['book_timein'];
$book_outtime1= $row1['book_timeout'];
$book_intime1 = date("H:ia",strtotime($book_intime1));
$book_outtime1 = date("H:ia",strtotime($book_outtime1));

$start_time1 = strtotime($book_intime1);
$end_time1 = strtotime($book_outtime1);
$diff = $end_time1 - $start_time1;
$years   = floor($diff / (365*60*60*24)); 
$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
$hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 
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
					<h1>Welcome <?php echo $name ?></h1>
					<nav id="nav">
						<ul>
                        <?php
						if($hours>=15)
						{
							echo "<li>Your vehicle is parked for more than 15 Hours</li>";
							}
						?>
                        <li><a href="index.php">Home</a></li>
						 	<li>
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
									</li>-->
								</ul>
							</li>
                          <li><a href="<?php echo $logoutAction ?>" class="button">Logout</a></li>                           
						</ul>
					</nav>
				</header>
	<!-- Main -->
				<section id="main" class="container1">
					<header>
						<h2>Parking Details</h2>
						
					</header>
                    <div id="main_body">                    
                    <div class='row'>
					<div class='3u 12u(narrower)'>
                   <p>&nbsp;</p>
					</div>
                    <div class='6u 12u(narrower)'>
                    <section class='box'>
                    <?php
					if($totalRows==0)
					{
						echo "<div class='6u'>
                     <b>You have not parked your car</b>
                     
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
$book_intime = date("H:ia",strtotime($book_intime));
$book_outtime = date("H:ia",strtotime($book_outtime));

$start_time = strtotime($book_intime);
$end_time = strtotime($book_outtime);
$difference = $end_time - $start_time;


$sql1="SELECT count(*) AS booked_count FROM bookings WHERE floorid='$floorid'";
$result1 = mysql_query($sql1,$mlcp);
$row1 = mysql_fetch_assoc($result1);
$booked_count= $row1['booked_count'];
$slots_remaining = $total_slots - $booked_count;
				echo"<div class='12u'>
				<table class='table table-striped' align='center'>
   
    <tbody>
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
        <td>".$total_slots ."</td>
        
      </tr>
	  <tr>
        <td>Free Slots</td>
        <td>". $slots_remaining ."</td>
        
      </tr>
      <tr>
        <td>Entry Time</td>
        <td>". $book_intime ."</td>
        
      </tr>
	   <tr>
        <td>Exit Time</td>
        <td>". $book_outtime ."</td>
        
      </tr>
	  <tr>
        <td>Slots Occupied</td>
        <td>". $booked_count ."</td>
        
      </tr>
	  
	  <tr>
        <td>Parking Duration</td>
        <td>". date('G', $difference)." Hours ". date('i', $difference)." Minutes</td>
        
      </tr>
	  <tr>
	  <td><div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>Your&nbsp;Car</p></div></td>
	  <td><div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>Occupied</p></div></td>
	  </tr>
    </tbody>
  </table>";
							
							}
						}
					?>
                    
                 
                    </section>
                    </div>
                    </div>
                   <header>
						<h2>Track Your Vehicle</h2>
						
					</header>
					<div class='row'>
						
						<div class='12u 12u(narrower)'>

							<section class='box special'>
                           
<div class='row no-collapse 50% uniform'>
<div class='1u'><p>&nbsp;</p></div>
<?php
if($newslot==1)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>Your vehicle is parked here</p><p>1</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>1</p></div>";
		}
?>
<div class='1u'><hr></div>
<?php
if($newslot==2)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>2</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>2</p></div>";
		}
?><div class='1u'><hr></div>
<?php
if($newslot==3)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>3</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>3</p></div>";
		}
?><div class='1u'><hr></div>		
<?php
if($newslot==4)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>4</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>4</p></div>";
		}
?><div class='1u'><hr></div>
<?php
if($newslot==5)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>5</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>5</p></div>";
		}
?><div class='1u'><hr></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
</div>
<div class='row no-collapse 50% uniform'>
<div class='1u'><hr style="transform:rotate(180deg);-o-transform:rotate(180deg);-moz-transform:rotate(180deg);-webkit-transform:rotate(180deg);"></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>		
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><hr style="transform:rotate(180deg);-o-transform:rotate(180deg);-moz-transform:rotate(180deg);-webkit-transform:rotate(180deg);"></div>
</div>
<div class='row no-collapse 50% uniform'>
<?php
if($newslot==6)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>6</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>6</p></div>";
		}
?><div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><hr></div>
<?php
if($newslot==7)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>7</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>7</p></div>";
		}
?>
<?php
if($newslot==8)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>8</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>8</p></div>";
		}
?><?php
if($newslot==9)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>9</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>9</p></div>";
		}
?><?php
if($newslot==10)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>10</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>10</p></div>";
		}
?><div class='1u'><hr></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
<?php
if($newslot==11)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>11</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>11</p></div>";
		}
?></div>
<div class='row no-collapse 50% uniform'>
<div class='1u'><hr style="transform:rotate(180deg);-o-transform:rotate(180deg);-moz-transform:rotate(180deg);-webkit-transform:rotate(180deg);"></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='6u'><hr style="transform:rotate(180deg);-o-transform:rotate(180deg);-moz-transform:rotate(180deg);-webkit-transform:rotate(180deg);"></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><hr style="transform:rotate(180deg);-o-transform:rotate(180deg);-moz-transform:rotate(180deg);-webkit-transform:rotate(180deg);"></div>
</div>
<div class='row no-collapse 50% uniform'>
<?php
if($newslot==12)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>12</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>12</p></div>";
		}
?><div class='1u'><p>&nbsp;</p></div>
<?php
if($newslot==13)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>13</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>13</p></div>";
		}
?><div class='1u'><hr></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>		
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><hr></div>
<?php
if($newslot==14)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>14</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>14</p></div>";
		}
?><div class='1u'><p>&nbsp;</p></div>
<?php
if($newslot==15)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>15</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>15</p></div>";
		}
?></div>
<div class='row no-collapse 50% uniform'>
<div class='1u'><hr style="transform:rotate(180deg);-o-transform:rotate(180deg);-moz-transform:rotate(180deg);-webkit-transform:rotate(180deg);"></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><hr style="transform:rotate(180deg);-o-transform:rotate(180deg);-moz-transform:rotate(180deg);-webkit-transform:rotate(180deg);"></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>		
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><hr style="transform:rotate(180deg);-o-transform:rotate(180deg);-moz-transform:rotate(180deg);-webkit-transform:rotate(180deg);"></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><hr style="transform:rotate(180deg);-o-transform:rotate(180deg);-moz-transform:rotate(180deg);-webkit-transform:rotate(180deg);"></div>
</div>
<div class='row no-collapse 50% uniform'>
<?php
if($newslot==16)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>16</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>16</p></div>";
		}
?><div class='1u'><p>&nbsp;</p></div>
<?php
if($newslot==17)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>17</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>17</p></div>";
		}
?><div class='1u'><hr></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>		
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><hr></div>
<?php
if($newslot==18)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>18</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>18</p></div>";
		}
?><div class='1u'><p>&nbsp;</p></div>
<?php
if($newslot==19)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>19</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>19</p></div>";
		}
?></div>
<div class='row no-collapse 50% uniform'>
<div class='1u'><hr style="transform:rotate(180deg);-o-transform:rotate(180deg);-moz-transform:rotate(180deg);-webkit-transform:rotate(180deg);"></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><hr style="transform:rotate(180deg);-o-transform:rotate(180deg);-moz-transform:rotate(180deg);-webkit-transform:rotate(180deg);"></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>		
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><hr style="transform:rotate(180deg);-o-transform:rotate(180deg);-moz-transform:rotate(180deg);-webkit-transform:rotate(180deg);"></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><hr style="transform:rotate(180deg);-o-transform:rotate(180deg);-moz-transform:rotate(180deg);-webkit-transform:rotate(180deg);"></div>
</div>
<div class='row no-collapse 50% uniform'>
<?php
if($newslot==20)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>20</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>20</p></div>";
		}
?><div class='1u'><p>&nbsp;</p></div>
<?php
if($newslot==21)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>21</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>21</p></div>";
		}
?><div class='1u'><hr></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>		
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><hr></div>
<?php
if($newslot==22)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>22</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>22</p></div>";
		}
?><div class='1u'><p>&nbsp;</p></div>
<?php
if($newslot==23)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>23</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>23</p></div>";
		}
?></div>
<div class='row no-collapse 50% uniform'>
<div class='1u'><hr style="transform:rotate(180deg);-o-transform:rotate(180deg);-moz-transform:rotate(180deg);-webkit-transform:rotate(180deg);"></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='6u'><hr style="transform:rotate(180deg);-o-transform:rotate(180deg);-moz-transform:rotate(180deg);-webkit-transform:rotate(180deg);"></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><hr style="transform:rotate(180deg);-o-transform:rotate(180deg);-moz-transform:rotate(180deg);-webkit-transform:rotate(180deg);"></div>
</div>
<div class='row no-collapse 50% uniform'>
<?php
if($newslot==24)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>24</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>24</p></div>";
		}
?><div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><hr></div>
<?php
if($newslot==25)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>25</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>25</p></div>";
		}
?><?php
if($newslot==26)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>26</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>26</p></div>";
		}
?><?php
if($newslot==27)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>27</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>27</p></div>";
		}
?><?php
if($newslot==28)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>28</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>28</p></div>";
		}
?><div class='1u'><hr></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
<?php
if($newslot==29)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>29</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>29</p></div>";
		}
?></div>
<div class='row no-collapse 50% uniform'>
<div class='1u'><hr style="transform:rotate(180deg);-o-transform:rotate(180deg);-moz-transform:rotate(180deg);-webkit-transform:rotate(180deg);"></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>		
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><hr style="transform:rotate(180deg);-o-transform:rotate(180deg);-moz-transform:rotate(180deg);-webkit-transform:rotate(180deg);"></div>
</div>
<div class='row no-collapse 50% uniform'>
<div class='1u'><p>&nbsp;</p></div>
<?php
if($newslot==30)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>30</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>30</p></div>";
		}
?><div class='1u'><hr></div>
<?php
if($newslot==31)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>31</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>31</p></div>";
		}
?><div class='1u'><hr></div>
<?php
if($newslot==32)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>32</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>32</p></div>";
		}
?><div class='1u'><hr></div>		
<?php
if($newslot==33)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>33</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>33</p></div>";
		}
?><div class='1u'><hr></div>
<?php
if($newslot==34)
{
	echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:green;'></i><p>34</p></div>";
	}
	else
	{
		echo"<div class='1u'><i class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>34</p></div>";
		}
?><div class='1u'><hr></div>
<div class='1u'><p>&nbsp;</p></div>
<div class='1u'><p>&nbsp;</p></div>
</div>
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
