<?php
/*The addPatientVisit.php is a provider for physiotherapist. 
Create new patient visit (write patient record, add patient visit, connects visit with services) */

//Login and server connection data
$host="localhost";
$uname="root";
$pass="";
$dbname="androidstudiobase";

$flag=false;

$patID = $_GET['amka'];
$phyID = $_GET['phyID'];
$servicesIDs = $_GET['serv'];
$servList = explode(",",$servicesIDs);
$date = $_GET['time'];
$date = rtrim($date,'[');
$date = rtrim($date,']');
$message = "success";

//Connect
$dbh = mysqli_connect($host,$uname,$pass) or die("cannot connect");
mysqli_select_db($dbh, $dbname);

//create new visit
$crtVisit = "INSERT INTO patientvisits (patientID, physiotherapistID, visitTime) VALUES ('".$patID."', '".$phyID."', '".$date."')";
$result = mysqli_query($dbh, $crtVisit);


if($result){
    //Update history
    $countServ = count($servList);

    $lastHVs = "SELECT visitID FROM patientvisits WHERE patientvisits.visitID=(SELECT MAX(visitID) FROM patientvisits)";
    $resultHVs = mysqli_query($dbh, $lastHVs);
    $visLId;
    while ($row=mysqli_fetch_array($resultHVs)){
        $visLId = $row['visitID'];
    }

    for($i=0; $i<$countServ; $i++){
        $servID = $servList[$i];//Get current service id
        $crtHistory = "INSERT INTO histories (serviceID,patientID,physiotherapistID,servDate) VALUES ('".$servID."','".$patID."','".$phyID."','".$date."')";
        $resultH = mysqli_query($dbh, $crtHistory);
        if($resultH){
            //Get history id
            $lastHs = "SELECT historyID FROM visitacivities WHERE visitacivities.historyID=(SELECT MAX(historyID) FROM visitacivities)";
            $resultLH = mysqli_query($dbh, $lastHs);
            if($resultLH){
                $hisID;
                while ($row=mysqli_fetch_array($resultLH)){
                    $hisID = $row['historyID'];
                }
                //connection
                $crtConn = "INSERT INTO visitacivities (visitID,historyID) VALUES ('".$visLId."','".$hisID."')";
                $resultConn = mysqli_query($dbh, $crtConn);
                if(!$resultConn){
                    $message = "fail";
                    break;
                }
            }else{
                $message = "fail";
                break;
            }
            
        }else{
            $message = "fail";
            break;
        }
        
    }
}else{
    $message="fail";
}



header("Content-Type: application/json");
echo json_encode($message,JSON_UNESCAPED_UNICODE);
mysqli_close($dbh);

?>