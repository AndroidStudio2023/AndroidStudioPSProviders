<?php

//Login and server connection data
$host="localhost:3306";
$uname="root";
$pass="";
$dbname="androidstudiobase";

$data=array();
$currentUserArray= array();
$flag=false;

$idpatient=$_GET['patient'];

//Connect
$dbh = mysqli_connect($host,$uname,$pass) or die("cannot connect");
mysqli_select_db($dbh, $dbname);

$sql="SELECT DISTINCT physiotherapyclinics.physiotherapistID,physiotherapistName FROM physiotherapyclinics LEFT JOIN patientsandclinicsconnection ON physiotherapyclinics.physiotherapistID = patientsandclinicsconnection.physiotherapistID WHERE physiotherapyclinics.physiotherapistID IN (SELECT physiotherapistID FROM patientsandclinicsconnection WHERE patientID=".$idpatient.")";

$result = mysqli_query($dbh, $sql);

//if found user
while ($row=mysqli_fetch_array($result)) {
    $flag=true;
    //1st element: userType
    array_push($data,$row['physiotherapistID']);
    array_push($data,$row['physiotherapistName']);
}

header("Content-Type: application/json");
echo json_encode($data,JSON_UNESCAPED_UNICODE);
mysqli_close($dbh);
?>