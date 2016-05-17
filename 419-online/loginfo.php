<?php

session_start();
session_destroy();
session_start();



if(isset($_POST['login'])){
$username = $_POST['usernames'];
$password = $_POST['passwords'];

include "creds.php";

$rest = $con->prepare("SELECT 'id' FROM user WHERE email='$_POST[usernames]' AND password='$_POST[passwords]' LIMIT 1");
$rest->execute();
$resultss = $rest->get_result();
$rows = $resultss->fetch_assoc();
if($rows>0){


	//$_SESSION['login']= $_POST['login'];
	//$_SESSION['Username']= $row['Username'];
	$_SESSION['id']= $rows['id'];
	//$_SESSION['Email']= $rows['Email'];
}
//rest->close();

$res = $con->prepare("SELECT * FROM user WHERE email='$_POST[usernames]' AND password='$_POST[passwords]' LIMIT 1");
$res->execute();
$results = $res->get_result();
$row = $results->fetch_assoc();
if($row>0){


	//$_SESSION['login']= $_POST['login'];
	$_SESSION['email']= $row['email'];
	$_SESSION['id']= $row['id'];
	$_SESSION['type'] = "user";
	if($row['signature']==NULL){
		header("Location: addsignature.php");
	}
	else{
		header("Location: usersonly.php");
	}
	//$_SESSION['type']= $row['type'];
	

}
else{
	echo '<script>
				 
					alert("Username and Password do not match. Please try again.");
		
					</script>';
	session_destroy();
}
$res->close();
}

if(isset($_POST['adminlogin'])){
$username = $_POST['adminusernames'];
$password = $_POST['adminpasswords'];

include "creds.php";

$rest = $con->prepare("SELECT 'id' FROM admin WHERE email='$_POST[adminusernames]' AND password='$_POST[adminpasswords]' LIMIT 1");
$rest->execute();
$resultss = $rest->get_result();
$rows = $resultss->fetch_assoc();
if($rows>0){


	//$_SESSION['login']= $_POST['login'];
	//$_SESSION['Username']= $row['Username'];
	$_SESSION['id']= $rows['id'];
	//$_SESSION['Email']= $rows['Email'];
}
//rest->close();

$res = $con->prepare("SELECT * FROM admin WHERE email='$_POST[adminusernames]' AND password='$_POST[adminpasswords]' LIMIT 1");
$res->execute();
$results = $res->get_result();
$row = $results->fetch_assoc();
if($row>0){


	//$_SESSION['login']= $_POST['login'];
	$_SESSION['email']= $row['email'];
	$_SESSION['id']= $row['id'];
	$_SESSION['type']= "admin";
	header("Location: admins.php");

}
else{
	echo '<script>
				 
					alert("Username and Password do not match. Please try again.");
		
					</script>';
	session_destroy();
}
$res->close();
}
?>