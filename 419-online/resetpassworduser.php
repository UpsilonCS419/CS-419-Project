<?php

include("mysqlconnect.php");
db_connect();
error_reporting(E_ALL);

$useremail = $_GET['email'];
$userrandomID = $_GET['reset'];
$checkreset = mysql_query("SELECT * FROM user WHERE email='$useremail'") or die('No Such Email' . mysql_error());
$randomCheck = mysql_fetch_array($checkreset);
$idcheck = $randomCheck['reset'];
if($userrandomID != $idcheck){
	
	echo 'you have already updated this link.';
	echo '<meta http-equiv="refresh" content="0;URL=noreset.php" />';
	
}
?>

<html>
<head>
<style type="text/css">
 input{
 border:1px solid olive;
 border-radius:5px;
 }
 h1{
  color:darkgreen;
  font-size:22px;
  text-align:center;
 }

</style>
</head>
<body>
<h1>User, Type your new password: <?php echo $_GET['email']; ?><h1>
<form action='#' method='post'>
<table cellspacing='5' align='center'>
<tr><td>New Password:</td><td><input type='password' name='userpassword' required/></td></tr>
<tr><td>Confirm Password:</td><td><input type='password' name='confirmuserpassword' required/></td></tr>
<tr><td></td><td><input type='submit' name='submit' value='Submit'/></td></tr>
</table>
</form>
<?php


if(isset($_POST['submit']))
{ 
	$resetpassword=$_POST['userpassword'];
	$confirm = $_POST['confirmuserpassword'];
	if($resetpassword == $confirm){
		//include("mysqlconnect.php");
		//db_connect();
		//error_reporting(E_ALL);
		
		//$resetpassword=$_POST['userpassword'];
		
		$useremail = $_GET['email'];
		$userrandomID = $_GET['reset'];
		
		
		
			$results = mysql_query("SELECT * FROM user WHERE email='$useremail' AND reset='$userrandomID'") or die('No Such Email' . mysql_error());
			$rows = mysql_fetch_array($results);
			$recovername = $rows['email'];
			$recoverID = $rows['id'];
			$randomID = (rand(10,10000));
			$sql = "UPDATE user SET password='$resetpassword', reset='$randomID' where id='$recoverID'";


			$result = mysql_query($sql);
			if (!$result) 
			{
				die('Invalid query: ' . mysql_error());
			}
			
			
			echo '<br/>';
			echo 'You have successfully updated your new password.';
			echo '<br/>';
			
			echo 'Please <a href=login.php>Log In Now</a>'; 
			
			//echo '<meta http-equiv="refresh" content="0;URL=login.php" />';
			//header("location: login.php");
			
		
		
	}
	
	else
{
	echo "Password entries do not match. Please try again.";
	echo "<p>";
	echo "Try Again.";	
	echo "</p>";
}
	

 
}
?>
</body>
</html>