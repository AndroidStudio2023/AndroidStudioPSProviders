<?php
/*The deleteRequest.php is a provider for physiotherapits. 
Deletes a patient's request for appointment */

//Login and server connection data
$host="localhost:3306";
$uname="root";
$pass="";
$dbname="androidstudiobase";
$recID = $_GET['reqID'];
//data: returns data, currentUserArray: auxiliary list, flag: if find the user, then give access for finding the others data of user
$data = "fail";

//Connect
$dbh = mysqli_connect($host,$uname,$pass) or die("cannot connect");
mysqli_select_db($dbh, $dbname);
$query = "DELETE FROM patinetsrequests WHERE requestID = ".$recID."";

//$data -> returned message
$result =  mysqli_query($dbh, $query);
if($result){
    $data="Success";
}
header("Content-Type: application/json");
echo json_encode($data,JSON_UNESCAPED_UNICODE);
mysqli_close($dbh);
?>