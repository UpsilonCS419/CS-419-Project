<!DOCTYPE html>
<html>

<head>
  <title>Delete Record</title>
  <meta charset="UTF-8">
  <link href="site.css" rel="stylesheet">
</head>

<body>

<h1>Epsilon Employee Recognition</h1>
<nav id="nav01"></nav>
<div id="main">
<a href="url" class="logoutLblPos">sign out</a>
<?PHP
include("mysqlconnect.php");
db_connect();
error_reporting(E_ALL);

$id = $_GET['id'];
$sql = "SELECT * FROM admin where id='$id'";
$result = mysql_query($sql);
if (!$result) 
{
    die('Invalid query: ' . mysql_error());
}

//echo "<script type='text/javascript'> document.location = 'customers.php'; </script>";
while ($row=mysql_fetch_array($result))
{
	$email=$row['email'];
	$password=$row['password'];
}

?>
<h2>Edit Admin Data:</h2>
	
<form action="edit_admins.php" method="post">
<input type="hidden" name="id" value="<?php echo $id; ?>">
<p>
    <label for="name">User (e-mail):</label>
    <input type="text" name="email" id="email" value="<?php echo $email; ?>">
</p>
<p>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" value="<?php echo $password; ?>">
</p>
<p>
    <label for="confirmpassword">Confirm Password:</label>
    <input type="password" name="confirmpassword" id="confirmpassword" value="<?php echo
$password; ?>" >
</p>

<input type="submit" value="Edit" class="submit">

<script src="script.js"></script>
</div>
</body>
</html>
