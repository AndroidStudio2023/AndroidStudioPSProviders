<?php
/*The findUser.php is a provider for users login to the app. 
Gets the importeds data (email,password,user type) with GET method inside from url and search for a user, with this data. 
If it find the user, then returns userID and userName(First & Last name) as JSON array. 
In case where user is physicotherapist, provider returns and the clinic's data. */

//Login and server connection data
$host="localhost:3306";
$uname="root";
$pass="";
$dbname="androidstudiobase";
//User's data from url
$userEmail = $_GET['email'];
$userPass = $_GET['password'];
$userType = $_GET['type'];
//data: returns data, currentUserArray: auxiliary list, flag: if find the user, then give access for finding the others data of user
$data = array();
$currentUserArray= array();
$flag=false;

//Connect
$dbh = mysqli_connect($host,$uname,$pass) or die("cannot connect");
mysqli_select_db($dbh, $dbname);

//Search if user exists
$sql = "SELECT * FROM logindata WHERE uEmail='".$userEmail."' AND uPassword='".$userPass."' AND userType='".$userType."'";
$result = mysqli_query($dbh, $sql);

//if found user
while ($row=mysqli_fetch_array($result)) {
    $flag=true;
    //1st element: userType
    array_push($currentUserArray,$row['userID']);
}
////if found user-> flag==TRUE
if($flag){
    //For PSF or Patient user get the Name
    //For Physiotherapist user get the Name and clinics informations 
    //$currentUserArray[0] is user ID for the system
    if ($userType=="PSF"){
        $sql = "SELECT psfName FROM psfusers WHERE psfID='".$currentUserArray[0]."'";
        $result = mysqli_query($dbh, $sql);
        while ($row=mysqli_fetch_array($result)) {
            $flag=true;
            //1st element: userType
            array_push($currentUserArray,$row['psfName']);
        }
    }else if($userType=="PHY"){
        $sql = "SELECT * FROM physiotherapyclinics WHERE physiotherapistID='".$currentUserArray[0]."'";
        $result = mysqli_query($dbh, $sql);
        while ($row=mysqli_fetch_array($result)) {
            $flag=true;
            //1st element: userType
            array_push($currentUserArray,$row['physiotherapistName'],$row['clinicAFM'],$row['clinicName'],$row['clinicAddress']);
        }
    }else{
        $sql = "SELECT patientName FROM patients WHERE AMKA='".$currentUserArray[0]."'";
        $result = mysqli_query($dbh, $sql);
        while ($row=mysqli_fetch_array($result)) {
            $flag=true;
            //1st element: userType
            array_push($currentUserArray,$row['patientName']);
        
        }
    }
}

$data = $currentUserArray;

header("Content-Type: application/json");
echo json_encode($data,JSON_UNESCAPED_UNICODE);
mysqli_close($dbh);

?>