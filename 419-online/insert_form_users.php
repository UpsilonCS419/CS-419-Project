<!DOCTYPE html>
<html>

<head>
  <title>Delete Record</title>
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

<a href="logout.php" class="logoutLblPos">sign out</a>

<h2>Create New User Account:</h2>

<form action="insert_user.php" method="post">
<p>
    <label for="user">User(e-mail):</label>
    <input type="text" name="user" id="user" required>
</p>
<p>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
</p>

<p>
    <label for="password">Confirm Password:</label>
    <input type="password" name="confirmpassword" id="confirmpassword"
required>
</p>


<p>
    <label for="fname">First Name:</label>
    <input type="fname" name="fname" id="fname"
required>
</p>


<p>
    <label for="lname">Last Name:</label>
    <input type="lname" name="lname" id="lname"
required>
</p>

<input type="submit" value="Submit" class="submit">
</form>

</div>
<script src="script.js"></script>

</body>
</html>
