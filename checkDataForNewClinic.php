<?php
/*The checkDataForNewClinic.php is a provider for PSF on CreatePSPage. 
Create a JSON object with ... */

//Tryal: localhost/AndroidStudioProviders/checkDataForNewClinic.php?docName=Παπαδημητρίου Αλέξανδρος&address=Αγγελάκι,21&afm=20239123&docID=phy001&name=SomeThink&email=physiotherapist.papadimitrioy@gmail.com&password=phy1234

//Login and server connection data
$host="localhost";
$uname="root";
$pass="";
$dbname="androidstudiobase";

$clinicName = $_GET['name'];
$clinicAddress = $_GET['address'];
$clinicAFM = $_GET['afm'];
$doctorName = $_GET['docName'];
$doctorEmail = $_GET['email'];
$doctorPass = $_GET['password'];
$doctorID = $_GET['docID'];

$data = array();
//data[n]: true(correct) / false(problem)
//data[0]: clinic name
//data[1]: address
//data[2]: afm
//data[3]: physicotherapist name
//data[4]: physicotherapist ID
//data[5]: email
//data[6]: password

$dbh = mysqli_connect($host,$uname,$pass) or die("cannot connect");
mysqli_select_db($dbh, $dbname);

//set data[n]=true , n=0..6
for($i=0; $i<7; $i++){
    $data[$i] = true;
}

//Check for clinic's data
$sql = "SELECT * FROM physiotherapyclinics";

$result = mysqli_query($dbh, $sql);
while ($row=mysqli_fetch_array($result)) {
    
    //Check fields

    //clinic Name
    if($row['clinicAFM']==$clinicAFM){
        $data[2]=false;
    }

    //clinic address
    if($row['clinicName']==$clinicName){
        $data[0]=false;
    }

    //clinic afm
    if($row['clinicAddress']==$clinicAddress){
        $data[1]=false;
    }

    //doctor name
    if($row['physiotherapistID']==$doctorID){
        $data[4]=false;
    }

    //doctor id
    if($row['physiotherapistName']==$doctorName){
        $data[3]=false;
    }
    
}

//Check for login's data
$sql = "SELECT * FROM logindata";

$result = mysqli_query($dbh, $sql);
while ($row=mysqli_fetch_array($result)) {
    
    //Check fields

    //clinic Name
    if($row['uEmail']==$doctorEmail && $row['userType']=="PHY"){
        $data[5]=false;
    }

    //clinic address
    if($row['uPassword']==$doctorPass && $row['userType']=="PHY"){
        $data[6]=false;
    }
}

header("Content-Type: application/json");
echo json_encode($data,JSON_UNESCAPED_UNICODE);
mysqli_close($dbh);

?>