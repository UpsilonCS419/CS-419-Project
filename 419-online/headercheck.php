<?php

session_start();

$sesstype=$_SESSION['type'];
$check = 'user';


include("checktypeuser.php");
include "creds.php";

error_reporting(E_ALL);

if(!$_SESSION["id"]){
  echo "You are not logged in!";
  header("location: login.php");
  echo '<br/>Please <a href="login.php" class="btn btn-primary btn-lg active" role="button">Login</a>';
  die();
}


$sessid=$_SESSION['id'];


?>