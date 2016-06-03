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
<h1>Forgot Password<h1>
<form action='#' method='post'>
<table cellspacing='5' align='center'>
<tr><td>Email id:</td><td><input type='text' name='mail'required/></td></tr>
<tr><td></td><td><input type='submit' name='submit' value='Submit'/></td></tr>
</table>
</form>
<?php
if(isset($_POST['submit']))
{ 

	include("mysqlconnect.php");
	db_connect();
	error_reporting(E_ALL);
	
	$mail=$_POST['mail'];
	
	$results = mysql_query("SELECT * FROM admin WHERE email='$mail'") or die('No Such Email' . mysql_error());
	$rows = mysql_fetch_array($results);
	$recovername = $rows['email'];
	$recoverID = $rows['id'];
	$randomID = (rand(10,10000));
	$sql = "UPDATE admin SET reset='$randomID' where id='$recoverID'";


$result = mysql_query($sql);
if (!$result) 
{
    die('Invalid query: ' . mysql_error());
}
 
 
	//http://www.phponwebsites.com/2014/07/php-mysql-forgot-password-to-mail.html
	//emailing and password recovery with help from the above site, along with css style of password recovery form
  $to=$rows['email'];
  $resetURL = 'https://web.engr.oregonstate.edu/~hengs/wiki/docs/cs419/resetpasswordadmin.php?email=' . $to . '&reset=' . $randomID;
  $subject='Password Reset for User Admin Award';
  $message='please click the follow link to reset your password: ' . $resetURL; 
  $headers='From:hengs@oregonstate.edu';
  $m=mail($to,$subject,$message,$headers);
  if($m)
  {
    echo'Check your inbox in mail';
  }
  else
  {
   echo'mail is not send';
  }
 
 
}
?>
</body>
</html>