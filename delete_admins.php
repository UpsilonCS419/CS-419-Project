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
    echo "Sorry this record cannot be deleted from the database as it is part of an existing order";
	echo "";
	echo "<a href=\"customers.php\">Back to Manage Customers</a>";

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
