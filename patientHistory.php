<?php
/*The patientsHistory.php gets the history data (service name and date)
for the patient with the given patientid and saves it in a JSON array*/

//Login and server connection data
$host='localhost:3307';
$uname='root';
$pass='root';
$dbname='physiotherapy';


//patientid and doctorid from URL
$patientid = $_GET['patientid'];
$doctorid = $_GET['doctorid'];

//history: array with the patient's history data
$history = array();

//Connect
$dbh = mysqli_connect($host,$uname,$pass) or die("cannot connect");
mysqli_select_db($dbh, $dbname);


//This query returns all possible rows of the patient's history services and adds all the dates in the end
//patientid = 11120202352
$sql = "SELECT serviceName FROM services JOIN histories ON services.serviceID = histories.ServiceID AND PatientID ='".$patientid."' AND  physiotherapistID ='".$doctorid."'
        UNION ALL SELECT servDate FROM histories WHERE PatientID ='".$patientid."' AND  physiotherapistID ='".$doctorid."'";

//Gets the result from the execution of the query
 $result = mysqli_query($dbh, $sql);


//Saves the returning data in the history array (first all the service names, then all the dates)
while ($row=mysqli_fetch_array($result)){
    array_push($history, $row[0]);
}


header("Content-Type: application/json");
echo json_encode($history,JSON_UNESCAPED_UNICODE);
mysqli_close($dbh);
?>
