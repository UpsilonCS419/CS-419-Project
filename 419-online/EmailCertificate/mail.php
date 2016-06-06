<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include './PHPMailer/class.phpmailer.php';

session_start();
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "lozadas-db", "ZM18X2OT5DBHUvi0", "lozadas-db");
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
} 

if(isset($_SESSION['awardeeId2'])) {
//	$awardeeId = $_SESSION['awardeeId2'];
	unset($_SESSION['awardeeId2']);
} else {
	echo "No certificate to send";
	exit();
}

$names = explode(" ", file_get_contents('names.txt'));

$emailAddr = $names[5];

if ($names[4] == "YearAward") {
	$htmlTemp = 'emailTemplate.html';
	$emailSubject = 'Employee of Year Award';
} else if ($names[4] == "MonthAward") {
	$htmlTemp = 'emailTemplate1.html';
	$emailSubject = 'Employee of Month Award';
} else {
	echo "error on award type";
	exit();
}

$tempFile = './Templates/' . $htmlTemp;
$bodytext = file_get_contents($tempFile); //get email template

$awardee = $names[0] . ' ' . $names[1];
$user =  $names[2] . ' ' . $names[3];
$trans = array("@@fullName@@" => $awardee, "@@userFullName@@" => $user);
$body = strtr($bodytext, $trans);

$email = new PHPMailer();
$email->From      = 'hengs@oregonstate.edu';
$email->FromName  = $user;
$email->Subject   = $emailSubject;
$email->Body      = $body;
$email->AddAddress($emailAddr);

$names = explode(" ", file_get_contents('names.txt'));
$pdfFile = $names[1] . 'ctf.pdf';

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