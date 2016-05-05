<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//header('Content-Type: text/html');
include 'storedInfo.php';

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "wangxis-db", "$myPassword", "wangxis-db");
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
} 

if (isset($_POST['fName']) && $_POST['fName'] != '' ) {
	$fname = $_POST['fName'];
} else {
	$fname = 'noName';
}

if (isset($_POST['lName']) && $_POST['lName'] != '') {
	$lname = $_POST['lName'];
} else {
	$lname = 'noName';
}

if (isset($_POST['userFName']) && $_POST['userFName'] != '') {
	$userfname = $_POST['userFName'];
} else {
	$userfname = "noName";
}

if (isset($_POST['userLName']) && $_POST['userLName'] != '') {
	$userlname = $_POST['userLName'];
} else {
	$userlname = "noName";
}
if (isset($_POST['awardType'])) {
	$awardtype = $_POST['awardType'];
} else {
	$awardtype = "no input";
}

//query signature based on user's lastname from DB

	$out_image = NULL;         //hold the binary file of image

	if (!($stmt = $mysqli->prepare("SELECT signature FROM user WHERE lname=?"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	if (!($stmt->bind_param("s", $userlname))) {
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if (!($stmt->execute())) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if (!($stmt->store_result())) {
		echo "Store Result failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if (!($stmt->bind_result($out_image))) {
		echo "Bind Result failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	$stmt->fetch();
	$stmt->close();

	$numBytes = file_put_contents("./pdfTemp/images/sig.jpg", $out_image);    //output image to jpg file. 
	if ($numBytes <= 0) {
		echo "Fail to get user's signature image, enter user's last name as User1, User2, or User3 for testing";
		exit();
	}

//if ($awardtype == "")
 //open the template
 //$newFile =  "template1.tex";
 $outPutData = file_get_contents("template1.tex");
 $awardee = $fname . ' ' . $lname;
 $username = $userfname . ' ' . $userlname;
 $tans = array("@@employeeName@@" => $awardee, "@@userName@@" => $username);
 $newout = strtr($outPutData, $tans);

 $newFileName = "./pdfTemp/". $fname . "ctf.tex";
 $baseName = $fname . "ctf.tex";
 
 file_put_contents($newFileName, $newout);
 
 chdir('pdfTemp');

 $command = "/usr/bin/pdflatex " . $baseName;

 $last_line = shell_exec($command);
 header("Content-type: application/pdf");
 $pdf = $fname . 'ctf.pdf';
 readfile($pdf);

?>