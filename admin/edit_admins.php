<!DOCTYPE html>
<html>

<head>
  <title>Delete Record</title>
  <meta charset="UTF-8">
  <link href="site.css" rel="stylesheet">
</head>

<body>

<div id="main">
<h1>Editing Records:</h1>


<?PHP
include("mysqlconnect.php");
db_connect();
error_reporting(E_ALL);

$id=$_POST['id'];
$email = $_POST['email'];
$password = $_POST['password'];
$cpassword= $_POST['confirmpassword'];

if ($password==$cpassword)
{
	$sql = "UPDATE admin  SET email='$email',password='$password'
 	where id='$id'";
	$result = mysql_query($sql);
	if (!$result) 
	{
    	die('Invalid query: ' . mysql_error());
	}	

	echo "Record has been edited successfully, please wait while redirecting...";
	echo "<script type='text/javascript'> document.location = 'admins.php'; </script>";
}
else
{
	echo "Password entries do not match. Please try again";
	echo "<p>";
	echo "<a href='edit_form_admins.php'>Return</a>";	
	echo "</p>";
}

?>

</div>
</body>
</html>
