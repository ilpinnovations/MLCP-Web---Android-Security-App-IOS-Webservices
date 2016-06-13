<?php
$url = 'http://mymlcp.co.in/mlcpapp/?tag=GetParkingStatus';
$content = file_get_contents($url);

$json = json_decode($content, true);

foreach($json['values'] as $item) {
  
$yestbusthour_array=array($item['slot7A'],$item['slot7B'],$item['slot7C'],$item['slot7D'],$item['slot7E'],$item['slot7F'],$item['slot7G'],$item['slot7H'],$item['slot7I']);

$day7=array($item['slot7A'],$item['slot7B'],$item['slot7C'],$item['slot7D'],$item['slot7E'],$item['slot7F'],$item['slot7G'],$item['slot7H'],$item['slot7I']);
$day7_max = max($day7);

$day6=array($item['slot6A'],$item['slot6B'],$item['slot6C'],$item['slot6D'],$item['slot6E'],$item['slot6F'],$item['slot6G'],$item['slot6H'],$item['slot6I']);
$day6_max = max($day76);

$day5=array($item['slot5A'],$item['slot5B'],$item['slot5C'],$item['slot5D'],$item['slot5E'],$item['slot5F'],$item['slot5G'],$item['slot5H'],$item['slot5I']);
$day5_max = max($day5);

$day4=array($item['slot4A'],$item['slot4B'],$item['slot4C'],$item['slot4D'],$item['slot4E'],$item['slot4F'],$item['slot4G'],$item['slot4H'],$item['slot4I']);
$day4_max = max($day4);

$day3=array($item['slot3A'],$item['slot3B'],$item['slot3C'],$item['slot3D'],$item['slot3E'],$item['slot3F'],$item['slot3G'],$item['slot3H'],$item['slot3I']);
$day3_max = max($day3);

$day2=array($item['slot2A'],$item['slot2B'],$item['slot2C'],$item['slot2D'],$item['slot2E'],$item['slot2F'],$item['slot2G'],$item['slot2H'],$item['slot2I']);
$day2_max = max($day2);

$day1=array($item['slot1A'],$item['slot1B'],$item['slot1C'],$item['slot1D'],$item['slot1E'],$item['slot1F'],$item['slot1G'],$item['slot1H'],$item['slot1I']);
$day1_max = max($day1);

$predicted_hour_array = array($day1_max,$day2_max,$day3_max,$day4_max,$day5_max,$day6_max,$day7_max,);
}
$yest_bussiest_hour_value= max($yestbusthour_array);
$predicted_busiest_hour_value= max($predicted_hour_array);

switch ($yest_bussiest_hour_value) {
    case 0:
        $yest_bussiest_hour="07:00AM to 07:30AM";
        break;
    case 1:
        $yest_bussiest_hour="07:30AM to 08:00AM";
        break;
    case 2:
        $yest_bussiest_hour="08:00AM to 08:30AM";
        break;
    case 3:
        $yest_bussiest_hour="08:30AM to 09:00AM";
        break;
    case 4:
        $yest_bussiest_hour="09:00AM to 09:30AM";
        break;
    case 5:
        $yest_bussiest_hour="09:30AM to 10:00AM";
        break;
    case 6:
        $yest_bussiest_hour="10:00AM to 10:30AM";
        break;
    case 7:
        $yest_bussiest_hour="10:30AM to 11:00AM";
        break;
    case 8:
        $yest_bussiest_hour="11:00AM to 11:30AM";
        break;
    case 9:
        $yest_bussiest_hour="11:30AM to 12:00PM";
        break;
   
    default:
        $yest_bussiest_hour="11:00AM to 11:30PM";
}

switch ($predicted_busiest_hour_value) {
    case 0:
        $predict_bussiest_hour="07:00AM to 07:30AM";
        break;
    case 1:
        $predict_bussiest_hour="07:30AM to 08:00AM";
        break;
    case 2:
        $predict_bussiest_hour="08:00AM to 08:30AM";
        break;
    case 3:
        $predict_bussiest_hour="08:30AM to 09:00AM";
        break;
    case 4:
        $predict_bussiest_hour="09:00AM to 09:30AM";
        break;
    case 5:
        $predict_bussiest_hour="09:30AM to 10:00AM";
        break;
    case 6:
        $predict_bussiest_hour="10:00AM to 10:30AM";
        break;
    case 7:
        $predict_bussiest_hour="10:30AM to 11:00AM";
        break;
    case 8:
        $predict_bussiest_hour="11:00AM to 11:30AM";
        break;
    case 9:
        $predict_bussiest_hour="11:30AM to 12:00PM";
        break;
   
    default:
        $predict_bussiest_hour="11:00AM to 11:30PM";
}

?>