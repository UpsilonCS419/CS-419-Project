<?php

//include"creds.php";

include "loginfo.php"; // Includes Login Script

if(isset($_SESSION['Username'])){
header("location: users.php");
}

include"creds.php";



?>

<!DOCTYPE html>
<html>
  <head>
    <title>Login/Sign Up Page</title>
    
        <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <script type="text/javascript" src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
    

    <script>
	    function showCreate(str) {
	    if (str == "") {
	        document.getElementById("txtHints").innerHTML = "";
	        return;
	    } else { 
	        if (window.XMLHttpRequest) {
	            // code for IE7+, Firefox, Chrome, Opera, Safari
	            xmlhttp = new XMLHttpRequest();
	        } else {
	            // code for IE6, IE5
	            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	        }
	        xmlhttp.onreadystatechange = function() {
	            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	                document.getElementById("txtHints").innerHTML = xmlhttp.responseText;
	            }
	        }
	        xmlhttp.open("GET","check_username.php?q="+str,true);
	        xmlhttp.send();
	    }
	    }

      $(function(){
        
        $('#existinguser').hide();
        
        $('#currentsignin').hide();
        $('#adminsign').hide();
        
        $("#newuser").click(function(){
          $("#currentsignin").show();
          $("#existinguser").hide();
          $('#adminsign').hide();
          });
        
        $("#returninguser").click(function(){
          $("#existinguser").show();
          $("#currentsignin").hide();
          $('#adminsign').hide();
          });

        $("#adminuser").click(function(){
          $("#adminsign").show();
          $("#currentsignin").hide();
          $('#existinguser').hide();
          });


      });


    </script>

  </head>
  <body>
     
      <div data-role="header">
        <h1>Award List</h1>
      </div>

      
        
        <a id="newuser" data-role="button" style="background: red; color: white;">Create A Login</a>
        <a id="returninguser" data-role="button" style="background: green; color: white;">User Sign In</a>
        <a id="adminuser" data-role="button" style="background: green; color: white;">Admin Signin</a>

        <div id="currentsignin">
          <h1>New User</h1>
          
          <form method = "POST" action="" enctype="multipart/form-data">
		
			Email: <input type="text" name="username" onkeyup="showCreate(this.value)" required><br/>
			<span id= "txtHints" class="txtHints"></span><br/>
			Password:  <input type="password" name="password" required><br/><br/>
			First Name: <input type="text" name="firstname" required><br/><br/>
			Last Name: <input type="text" name="lastname" required><br/><br/>
			<input type="file" name="mysignature" id="mysignature" required><br/><br/>

			<input type="submit" name="create" class="btn btn-primary btn-lg active" value="Create Account"><br/>
		</form>
        
        </div>
       
        <div id="existinguser">
          <h2>Regular User</h2>
          
          <form method = "POST" action="">
					Username: <input type="text" name="usernames" required><br/><br/>
					Password:  <input type="password" name="passwords" required><br/><br/>

					<input type="submit" class="btn btn-primary btn-lg active" name="login" value="Log In"><br/>
		</form>

      </div>  

      <div id="adminsign">
          <h3>Admin User</h2>
          
          <form method = "POST" action="">
					Username: <input type="text" name="adminusernames" required><br/><br/>
					Password:  <input type="password" name="adminpasswords" required><br/><br/>
					<input type="submit" class="btn btn-primary btn-lg active" name="adminlogin" value="Log In"><br/>
		</form>

      </div>          

   

  </body>

</html>

<?php


		if(isset($_POST['create'])){
			
			$date=date("Y-m-d");

			$imagetmp=addslashes (file_get_contents($_FILES['mysignature']['tmp_name']));

			$signUsers = "SELECT email FROM user WHERE email='$_POST[username]'";
			$check=$con->query($signUsers);
			
			if($check->num_rows>0){
				echo '<script>
				 
					alert("Username already exists. Please try again!");
		
					</script>';
			}
			else if((strlen($_POST['username'])<4) || (strlen($_POST['password'])<4)){
				echo '<script>
				 
					alert("Username and/or password is too short. Each must be 4 characters long!");
		
					</script>';
				
			}
			else{
				
				$AddQuery = $con->prepare ("INSERT INTO user (email, password, fname, lname, date_stamp, signature) VALUES ('$_POST[username]','$_POST[password]','$_POST[firstname]','$_POST[lastname]','$date','$imagetmp')");         
				echo '<script>
				 
					alert("New Account Created Successfully! Please Log in.");
		
					</script>';
				$AddQuery->execute();
				$AddQuery->close();
				}
				$check->close();

				
		};
	
	
	?>