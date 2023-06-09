<?php
/*The createNewAppointment.php is a provider for physiotherapist on request page. 
The physiotherapist accept a patient request, so this provider creates a appointment */

//Login and server connection data
$host="localhost:3306";
$uname="root";
$pass="";
$dbname="androidstudiobase";

//data: returns data, currentUserArray: auxiliary list, flag: if find the user, then give access for finding the others data of user
$data = "fail";

//Connect
$dbh = mysqli_connect($host,$uname,$pass) or die("cannot connect");
mysqli_select_db($dbh, $dbname);
$patientId = $_GET['amka'];
$reqeuestTime = $_GET['reqTime']; 
$docID = $_GET['docID'];

$insertQuery = "INSERT INTO patientappointments (patientID, physiotherapistID, requestTime) VALUES ('".$patientId."', '".$docID."', '".$reqeuestTime."')";

//$data -> returned message
$result =  mysqli_query($dbh, $insertQuery);
if($result){
    $data="Success";
}
header("Content-Type: application/json");
echo json_encode($data,JSON_UNESCAPED_UNICODE);
mysqli_close($dbh);

?>
