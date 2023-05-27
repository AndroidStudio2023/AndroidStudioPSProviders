<?php
/*The getClinics.php is a provider for PSF on PSFCentralPage. 
Create a JSON array with all Clinics Data */

//Login and server connection data
$host="localhost";
$uname="root";
$pass="";
$dbname="androidstudiobase";

$data = array();

$dbh = mysqli_connect($host,$uname,$pass) or die("cannot connect");
mysqli_select_db($dbh, $dbname);

$sql = "SELECT clinicAFM,clinicName,clinicAddress FROM physiotherapyclinics";

$result = mysqli_query($dbh, $sql);
while ($row=mysqli_fetch_array($result)) {
    
    array_push($data,array($row[0],$row[1],$row[2]));
    
}

header("Content-Type: application/json");
echo json_encode($data,JSON_UNESCAPED_UNICODE);
mysqli_close($dbh);?>