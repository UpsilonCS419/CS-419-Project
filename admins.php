<!DOCTYPE html>
<html>

<head>
  <title>Epsilon Employee Recognition</title>
  <meta charset="UTF-8">
  <link href="site.css" rel="stylesheet">
</head>

<body>

<h1>Eposilon Employee Recognition</h1>
<nav id="nav01"></nav>

<div id="main">


<?PHP
include("mysqlconnect.php");
db_connect();

error_reporting(E_ALL);
$result = mysql_query("SELECT * FROM admin");

echo "<h2>Admins</h2>";
echo "<table>";
echo "<tr>";
  echo "<th>user</th>";
  echo "<th>type</th>";

echo "</tr>";
while($row = mysql_fetch_array($result))
{
	echo "<tr>";
   	echo "<td>";
	echo $row['email'];
    echo "</td>";
	echo "<td>";
   	echo "<a href=\"edit_customer.php?id=".$row['id']."\">Edit</a>"; 
	echo "</td>";
   	echo "<td>";
   	echo "<a href=\"delete_customer.php?id=".$row['id']."\">Delete</a>"; 
   	echo "</td>";
  	echo "</tr>";
}
echo "</table>";


?>

<form name="addCustomer" action="insert_form_admins.php">            
            <input type="submit" value="Add	Admin">
        </form>

</div>

<script src="script.js"></script>

</body>
</html>
