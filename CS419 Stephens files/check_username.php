<?php

include"creds.php";

$signUserss = "SELECT email FROM user";
	$checks=$con->query($signUserss);
	
	if($checks->num_rows>0){
		while($roww=$checks->fetch_assoc()){
			if($_REQUEST['q']!= $roww['email'] && $_REQUEST['q']!="" && strlen($_REQUEST['q'])>3){
				$hint= "Available!!!";
				
			}
			else if(strlen($_REQUEST['q'])<4){
				$hint= "Username length is too short. 4 char min.";
				break;
		}
		else{
			$hint = "Username Unavailable!!!";
			break;
		}
		
	}

}
$checks->close();
echo $hint;
?>

