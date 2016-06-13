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
$slots= $row['noofslots'];

$sql1="SELECT count(*) AS booked_count FROM bookings WHERE floorid='1'";
$result1 = mysql_query($sql1,$connection);
$row1 = mysql_fetch_assoc($result1);
$booked_count= $row1['booked_count'];
$slots_remaining = $slots - $booked_count;
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
			height: 130px;
		
			
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
					<h1>Welcome Omkar Tarale</h1>
					<nav id="nav">
						<ul>
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
                          <li><a href="index.php" class="button">Logout</a></li>                           
						</ul>
					</nav>
				</header>
	<!-- Main -->
				<section id="main" class="container1">
					<header>
						<h2>Current Bookings</h2>
						<hr>
					</header>
                    <div id="main_body">
                    <div class="row">
                     <div class="4u 12u(narrower)">
                     <p>&nbsp;</p>
                     </div>
                    <div class="4u 12u(narrower)">
                    <section class="box special1" align="center">
                     <div class="row uniform 50%">
											<div class="12u">
                                           <h4> <b>Select Floor</b></h4>
												<div class="select-wrapper">
                                             	<?php  

$result = mysql_query("SELECT * FROM mlcp_floor", $connection);
echo "<select name='floor' id='floor' onchange='get_booking(this.value)' '>"; 
echo "<option value=''></option>";
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
                    <div class="4u 12u(narrower)">
                    </div>
                    </div>
                       
                    
                    <div class='row'>
					<div class='3u 12u(narrower)'>
                    <section class='box special1' align='center'>
                    <div class='row uniform 50%'>
											<div class='12u'>
                                           <h4> <b>Select Floor</b></h4>
												<div class='select-wrapper'>
<?php
$result = mysql_query("SELECT * FROM mlcp_floor", $connection);
echo "<select name='floor' id='floor' onchange='get_booking(this.value)' '>"; 
echo "<option value=''></option>";
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
                    <div class='6u 12u(narrower)'>
                    <section class='box special1'>
                     <div class='row no-collapse 50% uniform'>
                     <div class='6u'>
                     <b>Floor Name : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $floorname?></b></br>
       <b>Total Slots :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $slots ?></b></br>
         <b>Slots Occupied :&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $booked_count ?></b></br>
        <b>Free Slots :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $slots_remaining ?></b></br>
                     
                     </div>
                  
<div class='2u'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-car' onClick='get_parking_details()' style='font-size:25px;color:grey; text-align:'></i><p align='center'><b>Occupied</b></p>
</div>
<div class='2u'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-car' style='font-size:25px;color:green;'></i><p align='center'><b>Free</b></p></div>
<div class='2u'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-car' style='font-size:25px;color:red;'></i><p align='center'><b>Reserved</b></p></div>
                     </div>
                    </section>
                    </div>
                    </div>
                   
					<div class='row'>
						
						<div class='9u 12u(narrower)'>

							<section class='box special'>
                            <div class='row no-collapse 50% uniform'>
	<?php
	$result15 = mysql_query("SELECT * FROM mlcp_slot WHERE floorid='$floor_id'", $connection);

while ($row15 = mysql_fetch_assoc($result15)){
	$status= $row15['status'];
	$slot_id= $row15['slotid'];
	$slot_name=$row15['slotname'];
	$is_reserved= $row15['isReserved'];
	$slot_vehicle_size= $row15['vehiclesize'];
	if(strcasecmp($is_reserved,"Yes")==0)
	{
		echo "<div  class='1u'><i onClick='get_parking_details(".$slot_id.")' class='fa fa-car' style='font-size:40px;color:red;'></i><p>".$slot_name."</p>
		
		</div><div id='tests' >
		<b>Slot Name : ".$slot_name."</b></br>
		<b>Status : ".$status."</b></br>
		<b>Reserved : ".$is_reserved."</b></br>
		<b>Slot Vehicle Size : ".$slot_vehicle_size."</b></br>
		</div>";
		}
	elseif(strcasecmp($status,"FREE")==0)
	{
	echo "<div  class='1u'><i onClick='get_parking_details(".$slot_id.")' class='fa fa-car' style='font-size:40px;color:green;'></i><p>".$slot_name."</p>
		
		</div><div id='tests' >
		<b>Slot Name : ".$slot_name."</b></br>
		<b>Status : ".$status."</b></br>
		<b>Reserved : ".$is_reserved."</b></br>
		<b>Slot Vehicle Size : ".$slot_vehicle_size."</b></br>
		</div>";
	}
	elseif(strcasecmp($status,"occupied")==0)
	{
		echo "<div  class='1u'><i onClick='get_parking_details(".$slot_id.")' class='fa fa-car' style='font-size:40px;color:grey;'></i><p>".$slot_name."</p>
		
		</div><div id='tests' >
		<b>Slot Name : ".$slot_name."</b></br>
		<b>Status : ".$status."</b></br>
		<b>Reserved : ".$is_reserved."</b></br>
		<b>Slot Vehicle Size : ".$slot_vehicle_size."</b></br>
		</div>";
		}
	
	
	}
?>
 </div>
							</section>

						</div>
                      
                        <div id='information' class='3u 12u(narrower)'>
  <div id='info'>
                          
								<h3><b>Floor A</b></h3>
                               
                                <h4><b>Slot Number :</b></h4>
                                
                                <h4><b>Status :</b></h4>
                              
                                <h4><b>Reservation : </b></h4>
                              
                                <h4><b>Employee ID :</b></h4>
                            
                                <h4><b>Employee Name : </b></h4>
                               
                                <h4><b>Vehicle Number : </b></h4>
                             
                                <h4><b>Vehicle Size : </b></h4>
                               
                                <h4><b>In Time : </b></h4>
                            
                                <h4><b>Out Time :</b> </h4>
								
			
                                
							
</div>
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