<?php
/*The getDailyAppointments.php is a provider for Physiotherapist on DailyAppointments page. 
Return a JSON Array with daily appointments (appointments<->a ArrayList)*/

//Login and server connection data
$host="localhost";
$uname="root";
$pass="";
$dbname="androidstudiobase";

$data = array();

$docID = $_GET['docID'];//physiotherapistID
$date = $_GET['date'];//selected date

$sDate = $date." 00:00:00";//start day time
$fDate = $date." 23:59:59";//finish day time

$dbh = mysqli_connect($host,$uname,$pass) or die("cannot connect");
mysqli_select_db($dbh, $dbname);

$sql = "SELECT patientID,patientName,requestTime FROM patientappointments
INNER JOIN
patients
ON patients.AMKA=patientappointments.patientID
WHERE patientappointments.requestTime>='".$sDate."' AND 
patientappointments.requestTime<='".$fDate."' 
AND patientappointments.physiotherapistID='".$docID."'";

$result = mysqli_query($dbh, $sql);
while ($row=mysqli_fetch_array($result)) {
    $currentAppointment = array();
    //Split and save hour
    $splitDay = explode(' ', $row['requestTime']);
    $hour = $splitDay[1];

    //Parse current appointment
    array_push($currentAppointment,$row['patientID'],$row['patientName'],$hour);
    //Save current to data array
    array_push($data,$currentAppointment);
    
}

header("Content-Type: application/json");
echo json_encode($data,JSON_UNESCAPED_UNICODE);
mysqli_close($dbh);

?>