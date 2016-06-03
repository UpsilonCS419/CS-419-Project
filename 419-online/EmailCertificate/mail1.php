<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include './PHPMailer/class.phpmailer.php';

session_start();
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "lozadas-db", "ZM18X2OT5DBHUvi0", "lozadas-db");
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
} 

if(isset($_POST['sendAward'])) {
	$awardeeId = $_POST['sendAward'];
	//unset($_SESSION['awardeeId2']);
} 
/*
else if(isset($_SESSION['awardeeId'])){
	$awardeeId = $_SESSION['awardeeId'];
	//unset($_SESSION['awardeeId']);
}
*/
else {
	echo "No certificate to send";
	exit();
}

$read2 = "SELECT * FROM award WHERE id = '$awardeeId'";        
$favorites = $mysqli->query($read2);
$rows1=$favorites->fetch_assoc();

//$names = explode(" ", file_get_contents('names.txt'));

$emailAddr = $rows1['email'];

if ($rows1['tid'] == 2) {
	$htmlTemp = 'emailTemplate.html';
	$emailSubject = 'Employee of Year Award';
} else if ($rows1['tid'] == 1) {
	$htmlTemp = 'emailTemplate1.html';
	$emailSubject = 'Employee of Month Award';
} else {
	echo "error on award type";
	exit();
}
$sessid = $_SESSION['id'];
$read3 = "SELECT * FROM user WHERE id = '$sessid'";        
$favorites1 = $mysqli->query($read3);
$rows2=$favorites1->fetch_assoc();

$tempFile = './Templates/' . $htmlTemp;
$bodytext = file_get_contents($tempFile); //get email template

$awardee = $rows1['fname'] . ' ' . $rows1['lname'];
$user =  $rows2['fname'] . ' ' . $rows2['lname'];
$trans = array("@@fullName@@" => $awardee, "@@userFullName@@" => $user);
$body = strtr($bodytext, $trans);

$email = new PHPMailer();
$email->From      = 'hengs@oregonstate.edu';
$email->FromName  = $user;
$email->Subject   = $emailSubject;
$email->Body      = $body;
$email->AddAddress($emailAddr);

//$names = explode(" ", file_get_contents('names.txt'));
$pdfFile = $rows1['lname'] . 'ctf.pdf';

$file_to_attach = './pdfTemp/' . $pdfFile;;

$email->AddAttachment( $file_to_attach );
$email->isHtml(true);

//return $email->Send();

if(!$email->Send()) {
	echo "There was an error sending the message";
	exit();
}

echo "Certificate has been sent to ". $emailAddr;

?>