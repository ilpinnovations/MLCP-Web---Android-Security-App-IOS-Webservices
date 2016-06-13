<?php

$message= 'Your slot has been changed';
$booked_slot_emp_id = "1037386";
curl_setopt($ch, CURLOPT_URL,"http://mymlcp.co.in/gcm/push_notification/gcm.php?push=true");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,"empid=".$booked_slot_emp_id."&message=".$message."");

// in real life you should use something like:
// curl_setopt($ch, CURLOPT_POSTFIELDS, 
//          http_build_query(array('postvar1' => 'value1')));

// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);

curl_close ($ch);
echo "Successfull";
echo $server_output;

?>