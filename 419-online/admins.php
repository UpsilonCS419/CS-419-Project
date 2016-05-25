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

<h1>Upsilon Employee Recognition</h1>
<nav id="nav01"></nav>

<div id="main">

  <a href="url" class="logoutLblPos">sign out</a>

<?PHP
include("mysqlconnect.php");
db_connect();

error_reporting(E_ALL);
$result = mysql_query("SELECT * FROM admin");

echo "<h2>Administrators </h2>";
echo "<table class='table table-bordered table-hover table-striped' >";
echo "<tr>";
  echo "<th>Admin Account</th>";

echo "</tr>";
while($row = mysql_fetch_array($result))
{
	echo "<tr>";
   	echo "<td>";
	echo $row['email'];
    echo "</td>";
	echo "<td>";
   	echo "<a href=\"edit_admin_form.php?id=".$row['id']."\">Edit</a>"; 
	echo "</td>";
   	echo "<td>";
   	echo "<a href=\"delete_admins.php?id=".$row['id']."\">Delete</a>"; 
   	echo "</td>";
  	echo "</tr>";
}
echo "</table>";


?>

<form name="addCustomer" action="insert_form_admins.php" >            
            <input type="submit" value="Add	Admin" class="submit">
        </form>

</div>

<script src="script.js"></script>

</body>
</html>
