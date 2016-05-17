<!DOCTYPE html>
<html>

<head>
  <title>Delete Record</title>
  <meta charset="UTF-8">
  <link href="site.css" rel="stylesheet">
</head>

<body>

<h1>Upsilon Employee Recognition</h1>
<nav id="nav01"></nav>
<div id="main">

<a href="logout.php" class="logoutLblPos">sign out</a>

<h2>Create New Admin Account:</h2>

<form action="insert_admins.php" method="post">
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


<input type="submit" value="Submit" class="submit">
</form>

</div>
<script src="script.js"></script>

</body>
</html>
