<?php
// Retrieve data from the Android app
$name = $_GET['name'];
$description = $_GET['description'];
$cost = $_GET['cost'];
$id = $_GET['id'];

// Establish database connection
$host="localhost:3306";
$uname="root";
$pass="";
$dbname="androidstudiobase";

$message='fail';
//Connect
$dbh = mysqli_connect($host,$uname,$pass) or die("cannot connect");
mysqli_select_db($dbh, $dbname);


// Insert new provider into the database
$sql = "INSERT INTO services (serviceID, serviceName,serviceDescription,serviceCost) VALUES ('".$id."','".$name."','".$description."','".$cost."')";
$result = mysqli_query($dbh, $sql);
if($result){
    $message='SUCCESS';
}
header("Content-Type: application/json");
echo json_encode($message,JSON_UNESCAPED_UNICODE);
mysqli_close($dbh);
?>