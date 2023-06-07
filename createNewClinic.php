<?php
/*Create/insert new physiotherapist and clinic on system
2 steps:
1st: Add record to physiotherapyclinics table
2nd: Add record to logindata
Return Fail or Success*/

//Login and server connection data
$host="localhost";
$uname="root";
$pass="";
$dbname="androidstudiobase";
//User's data from url
$clinicName = $_GET['name'];
$clinicAddress = $_GET['address'];
$clinicAFM = $_GET['afm'];
$docID = $_GET['docID'];
$docName = $_GET['docName'];
$docEmail = $_GET['email'];
$docPassword = $_GET['password'];

$flag=0;
$data = "Fail";

//Connect
$dbh = mysqli_connect($host,$uname,$pass) or die("cannot connect");
mysqli_select_db($dbh, $dbname);

$sql = "INSERT INTO physiotherapyclinics (clinicName,clinicAFM,clinicAddress,physiotherapistID,physiotherapistName)
VALUES ('".$clinicName."','".$clinicAFM."','".$clinicAddress."','".$docID."','".$docName."')";

$result = mysqli_query($dbh, $sql);

if($result){
    $flag+=1;
}

$sql = "INSERT INTO logindata (uEmail,uPassword,userID,userType)
VALUES ('".$docEmail."','".$docPassword."','".$docID."','PHY')";

$result = mysqli_query($dbh, $sql);
if($result){
    $flag+=1;
}
if($flag==2){
    $data="Success";
}

header("Content-Type: application/json");
echo json_encode($data,JSON_UNESCAPED_UNICODE);
mysqli_close($dbh);

?>
