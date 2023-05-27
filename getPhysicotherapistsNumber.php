<?php
/*The getServicesNumber.php is a provider for PSF on newPSFCentralPage. 
Create a JSON object with Physicotherapists/Clinics number */

//Login and server connection data
$host="localhost";
$uname="root";
$pass="";
$dbname="androidstudiobase";

$data = 0;

$dbh = mysqli_connect($host,$uname,$pass) or die("cannot connect");
mysqli_select_db($dbh, $dbname);

$sql = "SELECT COUNT(DISTINCT clinicAFM) FROM physiotherapyclinics";

$result = mysqli_query($dbh, $sql);
while ($row=mysqli_fetch_array($result)) {
    
    $data = $row['COUNT(DISTINCT clinicAFM)'];
    
}

header("Content-Type: application/json");
echo json_encode($data,JSON_UNESCAPED_UNICODE);
mysqli_close($dbh);

?>