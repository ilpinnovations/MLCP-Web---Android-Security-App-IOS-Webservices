<?php
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
error_reporting(E_ERROR);
 require_once('db.php'); 
?>
<?php
$floor_id = "1";
$sql="SELECT * FROM mlcp_floor WHERE floorid='$floor_id'";
$result = mysql_query($sql,$connection);
$row = mysql_fetch_assoc($result);
$totalRows = mysql_num_rows($result);
$floorname= $row['floorname'];
$floorid= $row['floorid'];


$sql1="SELECT count(*) AS booked_count FROM mlcp_slot WHERE floorid='$floor_id' AND status='Occupied'";
$result1 = mysql_query($sql1,$connection);
$row1 = mysql_fetch_assoc($result1);
$booked_count= $row1['booked_count'];
$slots_remainin = $slots - $booked_count;
$sql2="SELECT count(*) AS booked_count FROM mlcp_slot WHERE floorid='$floor_id' AND status='Free'";
$result2 = mysql_query($sql2,$connection);
$row2 = mysql_fetch_assoc($result2);
$slots_remaining= $row2['booked_count'];
$sql3="SELECT count(*) AS booked_count FROM mlcp_slot WHERE floorid='$floor_id' AND isReserved='yes'";
$result3 = mysql_query($sql3,$connection);
$row3 = mysql_fetch_assoc($result3);
$slots_reserved= $row3['booked_count'];
$slots= $booked_count+$slots_remaining+$slots_reserved;
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>MLCP | Availability</title>
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
			height: 150px;
		
			
		}
#tests {
    display:none;
}
#test:hover + #parent-content {
    display:block;
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
					
					<nav id="nav">
						<ul>
							<li><a href="index.php">Home</a></li>
						 	<!---<li>
								<a href="#" class="icon fa-angle-down">Menu</a>
								<ul>
									<li><a href="index.php.php#main">About</a></li>
									<li><a href="index.php.php#features">Features</a></li>
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
							</li>--->
                             <?php if(isset($_SESSION['MM_Username'])): ?>
							<li><a href="<?php echo $logoutAction ?>" class="button">Logout</a></li>
                            <li><a href="welcome1.php" class="button">My Account</a></li>
                            <?php else: ?>
                            <li><a href="login.php" class="button">Login</a></li>
                            <?php endif ?>
                                                    
						</ul>
					</nav>
				</header>
	<!-- Main -->
				<section id="main" class="container1">
					<header>
						<h2>Slot Availability</h2>
						<hr>
					</header>
                    <div id="main_body">                   
                    <div class='row'>
					<div class='5u 12u(narrower)'>
                    <section class='box special1' align='center'>
                    <div class='row uniform 50%'>
											<div class='12u'>
                                           <h4> <b>Select Floor</b></h4>
												<div class='select-wrapper'>
<?php
$result = mysql_query("SELECT * FROM mlcp_floor", $connection);
echo "<select name='floor' id='floor' onchange='get_booking(this.value)' '>"; 
echo "<option value='".$floorid."'>".$floorname."</option>";
while ($row = mysql_fetch_assoc($result)){
	$id= $row['floorid'];
	$name=$row['floorname'];
	
	echo "<option value=$id>$name</option>";
	}
	echo "</select>";
	
	?>
	</div>
											</div>
										</div>
                    </section>
                    </div>
                    <div class='7u 12u(narrower)'>
                    <section class='box special1'>
                     <div class='row no-collapse 50% uniform'>
                     <div class='6u'>
                     <b>Level : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $floorname?></b></br>
       <b>Total Slots :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $slots ?></b></br>
         <b>Slots Occupied :&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $booked_count ?></b></br>
        <b>Free Slots :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $slots_remaining ?></b></br>
        <b>Reserved Slots :&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $slots_reserved ?></b></br>
                     
                     </div>
                  
<div class='2u'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-car' onClick='get_parking_details()' style='font-size:25px;color:#FFF176; text-align:'></i><p align='center'><b>Occupied</b></p>
</div>
<div class='2u'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-car' style='font-size:25px;color:green;'></i><p align='center'><b>Free</b></p></div>
<div class='2u'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-car' style='font-size:25px;color:red;'></i><p align='center'><b>Reserved</b></p></div>
                     </div>
                    </section>
                    </div>
                    </div>
                   
					<div class='row'>
						
						<div class='12u 12u(narrower)'>
 <header>
						<h2>Free Slots</h2>
						
					</header>
							<section class='box special'>
                            <div class='row no-collapse 50% uniform'>
	<?php
	$result15 = mysql_query("SELECT * FROM mlcp_slot WHERE floorid='$floor_id' AND status='Free'", $connection);
$totalRows15 = mysql_num_rows($result15);
if($totalRows15!=0)
	{
		while ($row15 = mysql_fetch_assoc($result15)){
	$status= $row15['status'];
	$slot_id= $row15['slotid'];
	$slot_name=$row15['slotname'];
	$is_reserved= $row15['isReserved'];
	$slot_vehicle_size= $row15['vehiclesize'];
	
		echo "<div  class='1u'><i onClick='get_parking_details(".$slot_id.")' class='fa fa-car' style='font-size:40px;color:green;'></i><p>".$slot_name."</p>
		
		</div><div id='tests' >
		<b>Slot Name : ".$slot_name."</b></br>
		<b>Status : ".$status."</b></br>
		<b>Reserved : ".$is_reserved."</b></br>
		<b>Slot Vehicle Size : ".$slot_vehicle_size."</b></br>
		</div>";	
	}
	}
	else
	{
		echo "Sorry, There are no free slots at this level, Please select another level.";
		}

?>
 </div>
							</section>
                            <header>
						<h2>Occupied Slots</h2>
						
					</header>
                            <section class='box special'>
                            <div class='row no-collapse 50% uniform'>
	<?php
	$result16 = mysql_query("SELECT * FROM mlcp_slot WHERE floorid='$floor_id' AND status='occupied'", $connection);
$totalRows16 = mysql_num_rows($result16);
if($totalRows16!=0)
	{
while ($row16 = mysql_fetch_assoc($result16)){
	$status= $row16['status'];
	$slot_id= $row16['slotid'];
	$slot_name=$row16['slotname'];
	$is_reserved= $row16['isReserved'];
	$slot_vehicle_size= $row16['vehiclesize'];
	
		echo "<div  class='1u'><i onClick='get_parking_details(".$slot_id.")' class='fa fa-car' style='font-size:40px;color:#FFF176;'></i><p>".$slot_name."</p>
		
		</div><div id='tests' >
		<b>Slot Name : ".$slot_name."</b></br>
		<b>Status : ".$status."</b></br>
		<b>Reserved : ".$is_reserved."</b></br>
		<b>Slot Vehicle Size : ".$slot_vehicle_size."</b></br>
		</div>";
		}
	}
	else
	{
		
		echo "No slots at this level are occupied";
	}
	
?>
 </div>
							</section>
 <header>
						<h2>Reserved Slots</h2>
						
					</header>
                            <section class='box special'>
                            <div class='row no-collapse 50% uniform'>
	<?php
	$result17 = mysql_query("SELECT * FROM mlcp_slot WHERE floorid='$floor_id' AND isReserved='yes'", $connection);
$totalRows17 = mysql_num_rows($result17);
if($totalRows17!=0)
	{
while ($row17 = mysql_fetch_assoc($result17)){
	$status= $row17['status'];
	$slot_id= $row17['slotid'];
	$slot_name=$row17['slotname'];
	$is_reserved= $row17['isReserved'];
	$slot_vehicle_size= $row17['vehiclesize'];
	
		echo "<div  class='1u'><i onClick='get_parking_details(".$slot_id.")' class='fa fa-car' style='font-size:40px;color:red;'></i><p>".$slot_name."</p>
		
		</div><div id='tests' >
		<b>Slot Name : ".$slot_name."</b></br>
		<b>Status : ".$status."</b></br>
		<b>Reserved : ".$is_reserved."</b></br>
		<b>Slot Vehicle Size : ".$slot_vehicle_size."</b></br>
		</div>";
		}
	}
	else
	{
		
		echo "No slots at this level are reserved";
	}
	
?>
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