<?php

if($sesstype == 'user'){
	//echo '<br/>No permission to access this user site. Redirecting to login page.';
	header("location: login.php");
  	exit();
}

?>