<?php
error_reporting(0);
include_once('db.php'); 
$data = array();
$slot_id=$_POST['slot_id'];
$emp_id=$_POST['emp_id'];
$vehicle_no=$_POST['vehicle_no'];
if(isset($emp_id))
{
$query = "SELECT * FROM mlcp_employee WHERE employeeid='$emp_id'";
$result = mysql_query($query,$connection);
$rows = mysql_num_rows($result);
if($rows!=1)
{
$query = "INSERT INTO mlcp_employee(employeeid) values('$emp_id')";
$result = mysql_query($query,$connection);

$query1 = "INSERT INTO mlcp_vehicle(vehiclenumber,employeeid) values('$vehicle_no','$emp_id')";
$result1 = mysql_query($query1,$connection);

$query = "UPDATE mlcp_slot SET status='Free',isReserved='No' WHERE slotid='$slot_id'";
$result = mysql_query($query,$connection);

$query1 = "UPDATE mlcp_booking SET isconfirmed='False',book_timeout=now() WHERE slotid='$slot_id' AND book_timeout IS NULL";
$result1 = mysql_query($query1,$connection);

$query = "INSERT INTO mlcp_booking(slotid,employeeid,book_timein,isconfirmed) values('$slot_id','$emp_id',now(),'yes')";
$result = mysql_query($query,$connection);

$query1 = "UPDATE mlcp_slot SET status='Occupied',isReserved='No' WHERE slotid='$slot_id'";
$result1 = mysql_query($query1,$connection);	
}
else
{
$query = "UPDATE mlcp_slot SET status='Free',isReserved='No' WHERE slotid='$slot_id'";
$result = mysql_query($query,$connection);

$query1 = "UPDATE mlcp_booking SET isconfirmed='False',book_timeout=now() WHERE slotid='$slot_id' AND book_timeout IS NULL";
$result1 = mysql_query($query1,$connection);

$query = "INSERT INTO mlcp_booking(slotid,employeeid,book_timein,isconfirmed) values('$slot_id','$emp_id',now(),'yes')";
$result = mysql_query($query,$connection);

$query1 = "UPDATE mlcp_slot SET status='Occupied',isReserved='No' WHERE slotid='$slot_id'";
$result1 = mysql_query($query1,$connection);	
}
}

echo "New slot booked";
 

mysql_close($connection);
?>