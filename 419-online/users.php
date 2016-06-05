<?php

session_start();

$sesstype=$_SESSION['type'];
$check = 'user';
include("checktypeadmin.php");

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

$results = mysql_query("SELECT * FROM admin WHERE id='$sessid'");
$rows = mysql_fetch_array($results);
$sessname = $rows['email'];

?>


<!DOCTYPE html>
<html>

<head>
  <title>Upsilon Employee Recognition</title>
  <meta charset="UTF-8">
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/latest/css/bootstrap.css" />
 
<!-- Include Date Range Picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
  
 <link href="site.css" rel="stylesheet">
</head>

<body>

<h1>Upsilon Employee Recognition: <?php echo $_SESSION['email']; ?></h1>
<nav id="nav01"></nav>

<div id="main">
<a href="logout.php" class="logoutLblPos">sign out</a>

<?PHP

$result = mysql_query("SELECT * FROM user");

echo "<h2>User Accounts</h2>";
echo "<table class='table table-bordered table-hover table-striped' >";
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
   /* echo "<td>";
	 Commented out by lozadas
	if($row['signature']==NULL){
		echo "No Signature Yet.";
	}
	else{
		echo "<img src='getsignature.php?emailname=".$sessname."' width='100' height='100' />";
	}
    echo "</td>";
    */
	echo "<td>";
	echo "<a href=\"edit_user_form.php?id=".$row['id']."\">Edit</a>"; 
	echo "</td>";
   	echo "<td>";
   	echo "<a href=\"delete_users.php?id=".$row['id']."\">Delete</a>"; 
   	echo "</td>";
  	echo "</tr>";
}
echo "</table>";


?>

<form name="addCustomer" action="insert_form_users.php">            
            <input type="submit" value="Add	User" class="submit">
</form>

</div>



</body>
</html>
<script src="script.js"></script>


