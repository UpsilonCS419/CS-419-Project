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

$query1="SELECT id FROM award where uid='".$id."'";
$awards=mysql_query($query1);
if ($awards)
{
	//If there are awards associated with a user  
	while($row = mysql_fetch_array($awards))
	{
		$sql = "DELETE FROM award where id='".$row['id']."'";
		$result= mysql_query($sql);
		if (!$result)
		{
    		echo "Sorry this record cannot be deleted from the database";
			echo "";
			echo "<a href=\"users.php\">Back to Manage Customers</a>";
		}
	}	
		$sql1 = "DELETE FROM user where id='".$id."'";
		$result1 = mysql_query($sql1);
		if (!$result1)
		{
    		echo "Sorry this record cannot be deleted from the database";
			echo "";
			echo "<a href=\"users.php\">Back to Manage Customers</a>";
		}
		else
		{
			echo "record has been deleted successfully, please wait while redirecting...";
			echo "<script type='text/javascript'> document.location = 'users.php'; </script>";
		}
}
else
{
	$sql = "DELETE FROM user where id='".$id."'";

	$result = mysql_query($sql);
	if (!$result) 
	{
    	echo "Sorry this record cannot be deleted from the database";
		echo "";
		echo "<a href=\"users.php\">Back to Manage Customers</a>";
	}
	else
	{
		echo "record has been deleted successfully, please wait while redirecting...";
		echo "<script type='text/javascript'> document.location = 'users.php'; </script>";
	}
}
?>

</div>
</body>
</html>
