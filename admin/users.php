<!DOCTYPE html>
<html>

<head>
  <title>Upsilon Employee Recognition</title>
  <meta charset="UTF-8">
  <link href="site.css" rel="stylesheet">
</head>

<body>

<h1>Upsilon Employee Recognition</h1>
<nav id="nav01"></nav>

<div id="main">
<a href="url" class="logoutLblPos">sign out</a>

<?PHP
include("mysqlconnect.php");
db_connect();

error_reporting(E_ALL);
$result = mysql_query("SELECT * FROM user");

echo "<h2>Users</h2>";
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

<script src="script.js"></script>

</body>
</html>
