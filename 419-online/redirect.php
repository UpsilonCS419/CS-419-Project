<?php

session_start();
include "creds.php";
error_reporting(E_ALL);


		if(isset($_POST['create'])){

			$sessname = $_SESSION['email'];

			$imagetmp=addslashes (file_get_contents($_FILES['mysignature']['tmp_name']));
				
			$AddQuery = $con->prepare ("UPDATE user SET signature='$imagetmp' WHERE email='$sessname'");         
				
			$AddQuery->execute();
			$AddQuery->close();
				
			header("location: usersonly.php");


				
		};
	
	?>