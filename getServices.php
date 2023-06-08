<?php
/*The getServices.php is a provider for Physiotherapist on Add_new_visit page. 
Return a JSON Array with servises (service<->a ArrayList)*/

//Login and server connection data
$host="localhost";
$uname="root";
$pass="";
$dbname="androidstudiobase";

$data = array();

$dbh = mysqli_connect($host,$uname,$pass) or die("cannot connect");
mysqli_select_db($dbh, $dbname);

$sql = "SELECT * FROM services";

$result = mysqli_query($dbh, $sql);
while ($row=mysqli_fetch_array($result)) {
    $current_service=array();
    array_push($current_service,$row['serviceID']);
    array_push($current_service,$row['serviceName']);
    array_push($current_service,$row['serviceDescription']);
    array_push($current_service,$row['serviceCost']);
    array_push($data,$current_service);
    
}

header("Content-Type: application/json");
echo json_encode($data,JSON_UNESCAPED_UNICODE);
mysqli_close($dbh);

?>