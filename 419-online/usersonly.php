<?php

session_start();

$sesstype=$_SESSION['type'];
$check = 'admin';

include "checktypeuser.php";


include("mysqlconnect.php");
db_connect();
error_reporting(E_ALL);

if(!$_SESSION["id"]){
  echo "You are not logged in!";
  header("location: login.php");
  echo '<br/>Please <a href="login.php" class="btn btn-primary btn-lg active" role="button">Login</a>';
  die();
}

$sessid=$_SESSION['id'];


$results = mysql_query("SELECT * FROM user WHERE id='$sessid'");
$rows = mysql_fetch_array($results);
$sessname = $rows['email'];

?>


<!DOCTYPE html>
<html>

<head>
  <title>Upsilon Employee Recognition</title>
  <meta charset="UTF-8">
  <link href="site.css" rel="stylesheet">

</head>

<body>

<h1>Upsilon Employee Recognition: <?php echo $sessname; ?></h1>
<nav id="nav01"></nav>

<div id="main">
<a href="logout.php" class="logoutLblPos">sign out</a>

<?PHP


$result = mysql_query("SELECT * FROM user WHERE id='$sessid'");

echo "<h2>Your Account</h2>";
echo "<table>";
echo "<tr>";
  echo "<th>User</th>";
  echo "<th>First Name</th>";
  echo "<th>Last Name</th>";
  echo "<th>Date Account Created</th>";

echo "</tr>";
while($row = mysql_fetch_array($result))
{
	echo "<tr>";
   	echo "<td>";
	echo $row['email'];
    echo "</td>";
    echo "<td>";
    echo $row['fname'];
   	echo "</td>";
  	echo "<td>";
    echo $row['lname'];
   	echo "</td>";
  	echo "<td>";
    echo $row['date_stamp'];
  	echo "</td>";
    echo "<td>";
    if($row['signature']==NULL){
		echo "No Signature Yet.";
	}
	else{
		echo "<img src='getsignature.php?emailname=".$sessname."' width='100' height='100' />";
	}
    echo "</td>";
    echo "<td>";
   	echo "<a href=\"edit_user_form_only.php?id=".$row['id']."\">Edit</a>"; 
	echo "</td>";
   	echo "<td>";
   	echo "<a href=\"delete_users_only.php?id=".$row['id']."\">Delete Your Account</a>"; 
   	echo "</td>";
  	echo "</tr>";
}
echo "</table>";


?>



</div>



</body>
</html>
<script src="script1.js"></script>


