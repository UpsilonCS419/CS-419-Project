<?php

  session_start();
  include "creds.php";

  $id = $_GET['emailname'];
  // do some validation here to ensure id is safe

  //$link = mysql_connect("localhost", "root", "");
  //mysql_select_db("dvddb");
  $sql = "SELECT signature FROM user WHERE email='$id'";
  $result = mysql_query("$sql");
  $row = mysql_fetch_assoc($result);
  mysql_close($con);
  $thesign = $row['signature'];

  header("Content-type: image/jpeg");
  echo base64_decode($thesign); 
?>