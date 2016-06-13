<?php 
error_reporting(E_ERROR);
require_once('db.php'); ?>
<?php
$floor_id= $_REQUEST['q'];
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
echo"
<div id='main_body'>
                    
                    <div class='row'>
					<div class='5u 12u(narrower)'>
                    <section class='box special1' align='center'>
                    <div class='row uniform 50%'>
											<div class='12u'>
                                           <h4> <b>Select Floor</b></h4>
												<div class='select-wrapper'>
";
$result = mysql_query("SELECT * FROM mlcp_floor", $connection);
echo "<select name='floor' id='floor' onchange='get_booking(this.value)' '>"; 
echo "<option value='".$floorid."'>".$floorname."</option>";
while ($row = mysql_fetch_assoc($result)){
	$id= $row['floorid'];
	$name=$row['floorname'];
	
	echo "<option value=$id>$name</option>";
	}
	echo "</select>";
	
	echo"
	</div>
											</div>
										</div>
                    </section>
                    </div>
                    <div class='7u 12u(narrower)'>
                    <section class='box special1'>
                     <div class='row no-collapse 50% uniform'>
                     <div class='6u'>
                     <b>Level : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $floorname."</b></br>
       <b>Total Slots :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $slots ."</b></br>
         <b>Slots Occupied :&nbsp;&nbsp;&nbsp;&nbsp;". $booked_count ."</b></br>
        <b>Free Slots :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $slots_remaining ."</b></br>
              <b>Reserved Slots :&nbsp;&nbsp;&nbsp;&nbsp;".$slots_reserved ."</b></br> 
                     </div>
                  
<div id='test' class='2u'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-car' onClick='get_parking_details()' style='font-size:25px;color:#FFF176; text-align:'></i><p align='center'><b>Occupied</b></p>
</div>
<div id='tests'>
		<h1>Hi</h1>
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
                            <div class='row no-collapse 50% uniform'>";

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


 echo "</div>
							</section>
                            <header>
						<h2>Occupied Slots</h2>
						
					</header>
                            <section class='box special'>
                            <div class='row no-collapse 50% uniform'>";
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
	

 echo"</div>
							</section>
 <header>
						<h2>Reserved Slots</h2>
						
					</header>
                            <section class='box special'>
                            <div class='row no-collapse 50% uniform'>";
	
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
	

 echo "</div>
							</section>

						</div>

                      
                        
					  </div>
					";
?>