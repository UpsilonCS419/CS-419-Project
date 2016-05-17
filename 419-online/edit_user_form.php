<!DOCTYPE html>
<html>

<head>
  <title>Edit Record</title>
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

$id = $_GET['id'];
$sql = "SELECT * FROM user where id='$id'";
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
	$fname=$row['fname'];
	$lname=$row['lname'];
}

?>
<h2>Edit User Data:</h2>
	
<form action="edit_users.php" method="post">
<input type="hidden" name="id" value="<?php echo $id; ?>">
<p>
    <label for="email">User (e-mail):</label>
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
<p>
    <label for="name">First Name:</label>
    <input type="text" name="fname" id="fname" value="<?php echo $fname; ?>">
</p>
<p>
    <label for="name">e-mail):</label>
    <input type="text" name="lname" id="lname" value="<?php echo $lname; ?>">
</p>
<input type="submit" value="Edit" class="submit">

<script src="script.js"></script>
</div>
</body>
</html>
