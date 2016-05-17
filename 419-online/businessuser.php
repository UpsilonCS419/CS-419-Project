<?php

session_start();

$sesstype=$_SESSION['type'];
$check = 'user';


include("checktypeuser.php");
include "creds.php";

error_reporting(E_ALL);

if(!$_SESSION["id"]){
  echo "You are not logged in!";
  header("location: login.php");
  echo '<br/>Please <a href="login.php" class="btn btn-primary btn-lg active" role="button">Login</a>';
  die();
}


$sessid=$_SESSION['id'];

?>


<!DOCTYPE html>
<html>

<head>
  <title>Upsilon Employee Recognition</title>
  <meta charset="UTF-8">
  <link href="site.css" rel="stylesheet">
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
  
  <script>
  $(document).ready(function() {
    $("#datepicker").datepicker();
  });
  </script>

</head>

<body>

<h1>Upsilon Employee Recognition: <?php echo $_SESSION['email']; ?></h1>
<nav id="nav01"></nav>

<div id="main">

  <a href="logout.php" class="logoutLblPos">sign out</a>


<h2>Create Award</h2>


<form method = "POST" action="">
    
      First Name: <input type="text" name="firstname" required><br/>
      Last Name: <input type="text" name="lastname" required><br/>
      Email:  <input type="text" name="email" required><br/>
      Type of Award:<input type="radio" name="typeaward" value="monthly" id="monthly">Employee of the Month
      <input type="radio" name="typeaward" value="weekly" id="weekly" required>Employee of the Week<br/>
      Date of Award<input name="awarddate" id="datepicker" required><br/>
      Time of Award<input type="time" name="awardtime" id="awardtime" required><br/><br/>

      <input type="submit" name="create" class="btn btn-primary btn-lg active" value="Create Account"><br/>
    </form>




<script src="script1.js"></script>

<hr/>
<h2>Award Given List</h2>

<?php

if(isset($_POST['deletefav'])) {
	$DeleteQuery1 = $con->prepare("DELETE FROM award WHERE id = '$_POST[deletefav]'");
	$DeleteQuery1->execute();
	$DeleteQuery1->close();
	echo "You have deleted this award.<br/>";
	}


if(isset($_POST['create'])){

    $sessids=$_SESSION['id'];
      
      $rawdate=htmlentities($_POST['awarddate']);
      $date = date('Y-m-d', strtotime($rawdate));
      $type = $_POST['typeaward'];
      $typeid = 0;

      $rawtime=htmlentities($_POST['awardtime']);
      $time = date('H:i:s', strtotime($rawtime));

      if($type=="monthly"){

        $AddQuery = $con->prepare ("INSERT INTO award (uid, tid, fname, lname, email, date_award, time_award) VALUES ('$sessids', 1, '$_POST[firstname]','$_POST[lastname]','$_POST[email]','$date','$time')");
        
      }
      else{
        $AddQuery = $con->prepare ("INSERT INTO award (uid, tid, fname, lname, email, date_award, time_award) VALUES ('$sessids', 2, '$_POST[firstname]','$_POST[lastname]','$_POST[email]','$date','$time')");
      }

      $AddQuery->execute();
      $AddQuery->close();
    

   
        

        
    };

    


?>

<?php

$read2 = "SELECT * FROM award WHERE uid = '$_SESSION[id]'";        
		$favorites = $con->query($read2);
		if($favorites->num_rows>0){
			echo '<table border = 1><br/>';
			echo '<th>First Name</th>';
			echo '<th>Last Name</th>';
			echo '<th>Email</th>';
			echo '<th>Type of Award</th>';
			echo '<th>Date of Award</th>';
			echo '<th>Delete</th>';
			
		while($rows1=$favorites->fetch_assoc()){
			if($rows1['tid']==1){
				echo "<tr><td>".$rows1['fname']."</td>";
				echo "<td>".$rows1['lname']."</td>";
				echo "<td>".$rows1['email']."</td>";
				echo "<td>Emp of Month</td>";
				$phpdate = strtotime($rows1['date_award']);
				$myformat = date("m/d/y", $phpdate);
				echo "<td>".$myformat."</td>";
				echo '<form action = "" method="POST">';
				echo "<td><input type='hidden' name='deletefav' value=".$rows1["id"]."><input type='submit' value='Delete Favorite' name='delete2'></td></form></tr>";
			}
			else{
				echo "<tr><td>".$rows1['fname']."</td>";
				echo "<td>".$rows1['lname']."</td>";
				echo "<td>".$rows1['email']."</td>";
				echo "<td>Emp of Week</td>";
				$phpdate = strtotime($rows1['date_award']);
				$myformat = date("m/d/y", $phpdate);
				echo "<td>".$myformat."</td>";
				echo '<form action = "" method="POST">';
				echo "<td><input type='hidden' name='deletefav' value=".$rows1["id"]."><input type='submit' value='Delete Favorite' name='delete2'></td></form></tr>";
				
			}
			}}
		else{
			echo "No awards created.";
		}
		


?>





</body>
</html>
