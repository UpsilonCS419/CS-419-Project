<?php

session_start();

?>

<!DOCTYPE html>
<html>

<head>
  <title>Delete Record</title>
  <meta charset="UTF-8">
  <link href="site.css" rel="stylesheet">
</head>

<body>

<div id="main">
<h1>Deleting Records:</h1>


<?PHP
include("mysqlconnect.php");
db_connect();
error_reporting(E_ALL);

$id = $_GET['id'];

$sql = "DELETE FROM user where id='".$id."'";

$result = mysql_query($sql);
if (!$result) 
{
    echo "Sorry this record cannot be deleted from the database";
	echo "";
	echo "<a href=\"usersonly.php\">Back to Manage Customers</a>";

}
else
{
	echo "Your account has been deleted successfully, please wait while redirecting to homepage...";
	echo "<script type='text/javascript'> document.location = 'login.php'; </script>";
}
?>

</div>
</body>
</html>
