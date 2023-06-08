<?php

//Login and server connection data
$host="localhost:3306";
$uname="root";
$pass="";
$dbname="androidstudiobase";

$message='fail';

$idpatient=$_GET['patient'];
$docid=$_GET['doctor'];
$daytime=$_GET['id'];

//Connect
$dbh = mysqli_connect($host,$uname,$pass) or die("cannot connect");
mysqli_select_db($dbh, $dbname);

$sql = "INSERT INTO patinetsrequests (patientID, physiotherapistID, requestTime) VALUES ('".$idpatient."', '".$docid."', '".$daytime."')";

$result = mysqli_query($dbh, $sql);

if($result){
    $message='SUCCESS';
}
header("Content-Type: application/json");
echo json_encode($message,JSON_UNESCAPED_UNICODE);
mysqli_close($dbh);
?>