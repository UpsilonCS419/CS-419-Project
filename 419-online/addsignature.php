<?php

session_start();

include "creds.php";
error_reporting(E_ALL);

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Add Signature</title>
    
        <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <script type="text/javascript" src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
    

   

  </head>
  <body>
     
     
        <?php

		echo "<h1>Welcome ".$_SESSION['email'].". Please add your signature below.</h1><hr>";

		?>
     

      <form method="POST" action="redirect.php" enctype="multipart/form-data">
		
			
			<input type="file" name="mysignature" id="mysignature" required><br/><br/>

			<input type="submit" name="create" class="btn btn-primary btn-lg active" value="Add Signature"><br/>
		</form>

      
  
   

  </body>

</html>

