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
    <title>Upsilon Login/Sign Up Page</title>
    
        <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <script type="text/javascript" src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	
    

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
  <body style="background-color:#F0F8FF">
	<br/><br/><br/>
  <div class="col-md-3" id="leftCol" style="background-color:#F0F8FF">
     <div class="well"> 
      <div data-role="header">
        <h1>LogIn Options</h1>
      </div>

      
        
        <a id="newuser" data-role="button" class="btn btn-sm btn-success">SignUp</a>
        <a id="returninguser" data-role="button" class="btn btn-sm btn-warning">User Signin</a>
        <a id="adminuser" data-role="button" class="btn btn-sm btn-danger">Admin Signin</a>

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
					Password:  <input type="password" name="passwords" required><br/>
					<a href="resetuser.php" >Forgot Password</a><br/><br/>

					<input type="submit" class="btn btn-primary btn-lg active" name="login" value="Log In"><br/>
		</form>
		

      </div>  

      <div id="adminsign">
          <h3>Admin User</h2>
          
          <form method = "POST" action="">
					Username: <input type="text" name="adminusernames" required><br/><br/>
					Password:  <input type="password" name="adminpasswords" required><br/>
					<a href="resetadmin.php" >Forgot Password</a><br/><br/>
					<input type="submit" class="btn btn-primary btn-lg active" name="adminlogin" value="Log In"><br/>
		</form>
		

      </div>          

   </div>
   </div>
   
 <div class="container"><font size = "4">
	<div class="row">
  			
      		<div class="col-md-9">
              	<h1>Welcome to the Upsilon Award Center</h2><hr>
              
              	<h2>About Upsilon Award Center</h2>
              	<p>
                Hi, welcome to our site called Upsilon Award Center. In case you didn't know, this site is a
               place where users/employers can recognize the efforts of their employees by awarding them certificates of excellence. 
			   Users can create employee of the month/year awards. You will be able to view the pdf of the award and can send it out
			   as an email attachment to the hardworking employee. Users can view all the awards they have given out and have the ability to resend, preview, or 
			   even remove the award from their file if they so choose.<br/>

              	</p><hr>
				<p>
				For Administrators, you have the capabilities to create other users and admins. Admins will have business intelligence on their side,
				where they are able to view all users and admins in the database. They can filter awards by type of award, users who created the award, and/or
				filter by date range as well. You can even export this data as an csv excel file. On the dashboard tab, admins can view real time data in 
				the form of charts and graphs. With all this extra features, you will have the knowledge of Upsilon Award Center at the power of your fingertips. 
				</p><hr>
                <p>
                  <div class="row">
                  <div class="col-md-9"><img src="employee.jpg" class="img-responsive"></div>
                    
                </div>

                </p>
              
              	<hr>
              
              	<h2>Lets Get Started</h2>
              	<p>
                First you must be either logged in as a User or Admin or sign up to access these features. Please sign in or create an account on the left index.
				
					
              	<hr>
              <h4><br/>Design with help from <a href="http://getbootstrap.com">Bootstrap</a></h4>
              	<hr>
              	
              	
      		</div> 
  	</div>
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