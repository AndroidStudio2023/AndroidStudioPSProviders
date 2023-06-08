<?php

//Login and server connection data
$host="localhost:3306";
$uname="root";
$pass="";
$dbname="androidstudiobase";

//data: returns data(List with lists), {list with request (request->List)}
$data = array();

$flag=false;

$docID=$_GET['id'];
//Connect
$dbh = mysqli_connect($host,$uname,$pass) or die("cannot connect");
mysqli_select_db($dbh, $dbname);
$sql = "SELECT patients.AMKA,patients.patientName,patinetsrequests.requestTime FROM patinetsrequests
INNER JOIN 
patients
ON patinetsrequests.patientID=patients.AMKA
WHERE patinetsrequests.physiotherapistID='".$docID."'";
$result =  mysqli_query($dbh, $sql);
while ($row=mysqli_fetch_array($result)) {
    $currentRequestArray= array();
    array_push($currentRequestArray,$row['AMKA'],$row['patientName'],$row['requestTime']);
    array_push($data,$currentRequestArray);
}

header("Content-Type: application/json");
echo json_encode($data,JSON_UNESCAPED_UNICODE);
mysqli_close($dbh);
?>