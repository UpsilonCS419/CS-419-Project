<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "lozadas-db", "ZM18X2OT5DBHUvi0", "lozadas-db");
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
} 
if(isset($_POST['viewAward'])) {
	$awardeeId = $_POST['viewAward'];
	//unset($_SESSION['awardeeId']);
	//$_SESSION['awardeeId2'] = $awardeeId; //pass to email sending page 
} 
/*
else if($_SESSION['awardeeId']!=NULL){
	$awardeeId = $_SESSION['awardeeId'];
}
*/
else {
	echo "Award is not created";
	exit();
}

$userId = $_SESSION['id'];

//echo $awardeeEmail;
//query the awardee's name, email and award type
$fname = NULL;
$lname = NULL;
$awardTid = NULL;
$emailAddr = NULL;
$awardDate = NULL;
if (!($stmt = $mysqli->prepare("SELECT tid, fname, lname, email, date_award FROM award WHERE id=?"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

if (!($stmt->bind_param("i", $awardeeId))) {
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

if (!($stmt->execute())) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
if (!$stmt->bind_result($awardTid, $fname, $lname, $emailAddr, $awardDate)) {
		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	$stmt->fetch();
	$stmt->close();
if ($awardTid == 1) {
	$awardtype = "MonthAward";
} else {
	$awardtype = "YearAward";
}

//query name of user

$userfname = NULL;
$userlname = NULL;

//query signature based on user's lastname from DB

	$out_image = NULL;         //hold the binary file of image

	if (!($stmt = $mysqli->prepare("SELECT fname, lname, signature FROM user WHERE id=?"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	if (!($stmt->bind_param("i", $userId))) {
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if (!($stmt->execute())) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if (!($stmt->store_result())) {
		echo "Store Result failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if (!($stmt->bind_result($userfname, $userlname, $out_image))) {
		echo "Bind Result failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	$stmt->fetch();
	$stmt->close();

	$numBytes = file_put_contents("./pdfTemp/images/sig.jpg", $out_image);    //output image to jpg file. 
	if ($numBytes <= 0) {
		echo "Fail to get user's signature image, enter user's last name as User1, User2, or User3 for testing";
		exit();
	}

//open the template
	if ($awardtype == "YearAward") {
		$newFile =  "template1.tex";
	} else if ($awardtype == "MonthAward") {
		$newFile =  "template2.tex";
	} else {
		echo "Award type doesn't exist!";
		exit ();
	}
 $tempFile = "./Templates/" . $newFile;
 $outPutData = file_get_contents($tempFile);
 $awardee = $fname . ' ' . $lname;
 $username = $userfname . ' ' . $userlname;
 $phpdate = strtotime($awardDate);
 $date = date("m-d-y", $phpdate);
 $tans = array("@@employeeName@@" => $awardee, "@@userName@@" => $username, "@@date@@" => $date);
 $newout = strtr($outPutData, $tans);

 $newFileName = "./pdfTemp/". $lname . "ctf.tex";
 $baseName = $lname . "ctf.tex";
 
 file_put_contents($newFileName, $newout);
 
 $fileContent = $awardee . ' ' . $username . ' ' . $awardtype . ' ' . $emailAddr;  
 file_put_contents('names.txt', $fileContent);      //save the names, email in the file for sending email

 chdir('pdfTemp');

 $command = "/usr/bin/pdflatex " . $baseName;

 $last_line = shell_exec($command);
 header("Content-type: application/pdf");
 $pdf = $lname . 'ctf.pdf';
 readfile($pdf);

?>