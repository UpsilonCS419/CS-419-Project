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

$sql = "DELETE FROM admin where id='".$id."'";

$result = mysql_query($sql);
if (!$result) 
{
    echo "Sorry this record cannot be deleted from the database";
	echo "";
	echo "<a href=\"admins.php\">Back to Manage Customers</a>";

}
else if($_SESSION['id']==$id){
	echo "Your Record has been deleted successfully, please wait while redirecting...";
	echo '<script>
				 
					alert("Your account has been deleted. You will be redirected to the login/sign up page.");
		
					</script>';
	echo "<script type='text/javascript'> document.location = 'login.php'; </script>";
	
}
else
{
	echo "Record has been deleted successfully, please wait while redirecting...";
	echo "<script type='text/javascript'> document.location = 'admins.php'; </script>";
}
?>

</div>
</body>
</html>
