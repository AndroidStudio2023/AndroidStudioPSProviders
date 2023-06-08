<?php
/*The findPatient.php is a provider for physiotherapist. 
Gets physiotherapistID and returns all physiotherapist's patients */

//Login and server connection data
$host="localhost:3306";
$uname="root";
$pass="";
$dbname="androidstudiobase";
$docID = $_GET['docID'];
$data = array();//Returned array


//Connect
$dbh = mysqli_connect($host,$uname,$pass) or die("cannot connect");
mysqli_select_db($dbh, $dbname);
$sql = "SELECT patients.AMKA,patients.patientName,patients.patientAddress FROM patientsandclinicsconnection
INNER JOIN 
patients ON patients.AMKA=patientsandclinicsconnection.patientID
WHERE physiotherapistID='".$docID."'";
$result = mysqli_query($dbh, $sql);
while ($row=mysqli_fetch_array($result)) {
    $currentPatientArray= array();//array for current patinent
    array_push($currentPatientArray,$row['AMKA'],$row['patientName'],$row['patientAddress']);
    array_push($data,$currentPatientArray);
}

header("Content-Type: application/json");
echo json_encode($data,JSON_UNESCAPED_UNICODE);
mysqli_close($dbh);

?>
