<?php
error_reporting(E_ERROR);
 require_once('db.php'); ?>
<?php
$slot_id= $_REQUEST['a'];
$sql="SELECT * FROM bookings WHERE slotid='$slot_id'";
$result = mysql_query($sql,$connection);
$row = mysql_fetch_assoc($result);
$totalRows = mysql_num_rows($result);
$floor_name= $row['floorname'];
$slot_name= $row['slotname'];
$status= $row['status'];
$reservation=$row['isReserved'];
$emp_id=$row['employeeid'];
$emp_name=$row['name'];
$in_time=$row['book_timein'];
$out_time=$row['book_timeout'];

$sql1="SELECT * FROM mlcp_vehicle WHERE employeeid='$emp_id'";
$result1 = mysql_query($sql1,$connection);
$row1 = mysql_fetch_assoc($result1);
$totalRows1 = mysql_num_rows($result1);
$vehicle_number= $row1['vehiclenumber'];
$vehicle_size= $row1['vehiclesize'];
if($totalRows==0)
{
	echo "<div id='info'>
<h3><b>No Booking</b></h3>
</div>";
	}
else
{
echo "
<div id='information' class='3u 12u(narrower)'>
<div id='info'>
                          
								<h3><b>Floor ".$floor_name."</b></h3>
                               
                                <h4><b>Slot Name : ".$slot_name."</b></h4>
                                
                                <h4><b>Status : ".$status."</b></h4>
                              
                                <h4><b>Reservation : ".$reservation."</b></h4>
                              
                                <h4><b>Employee ID : ".$emp_id."</b></h4>
                            
                                <h4><b>Employee Name :".$emp_name." </b></h4>
                               
                                <h4><b>Vehicle Number : ".$vehicle_number."</b></h4>
                             
                                <h4><b>Vehicle Size : ".$vehicle_size."</b></h4>
                               
                                <h4><b>In Time : ".$in_time."</b></h4>
                            
                                <h4><b>Out Time :".$out_time."</b> </h4>
								
								
                                
							</div>";
}


?>