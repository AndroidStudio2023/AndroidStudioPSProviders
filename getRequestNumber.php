<?php
/*The createNewAppointment.php is a provider for physiotherapist on main page. 
Returns the number of request (if it is >0: print popup message) */

//Login and server connection data
$host="localhost:3306";
$uname="root";
$pass="";
$dbname="androidstudiobase";

//data: returns data, currentUserArray: auxiliary list, flag: if find the user, then give access for finding the others data of user
$data = "0";

//Connect
$dbh = mysqli_connect($host,$uname,$pass) or die("cannot connect");
mysqli_select_db($dbh, $dbname);

$docID = $_GET['docID'];

$query = "SELECT COUNT(*) FROM patinetsrequests WHERE physiotherapistID='".$docID."'";

//$data -> number of request
$result =  mysqli_query($dbh, $query);
while ($row=mysqli_fetch_array($result)) {
    
    $data = $row['COUNT(*)'];
    
}
header("Content-Type: application/json");
echo json_encode($data,JSON_UNESCAPED_UNICODE);
mysqli_close($dbh);

?>