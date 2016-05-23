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
      <input type="radio" name="typeaward" value="yearly" id="yearly" required>Employee of the Year<br/>
      Date of Award<input name="awarddate" id="datepicker" required><br/>
      Time of Award<input type="time" name="awardtime" id="awardtime" required><br/><br/>

      <input type="submit" name="create" class="btn btn-primary btn-lg active" value="Create Award"><br/>
    </form>

<form method = "POST" action = "./EmailCertificate/latex.php" target="_blank">
	
	<input type="submit" name="submitReq" class="btn btn-primary btn-lg active" value="Create Certificate"><br/>
</form>	
	
<form method = "POST" action = "./EmailCertificate/mail.php" target="_blank">
	
	<input type="submit" name="email" class="btn btn-primary btn-lg active" value="Send Email"><br/>
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
	  $_SESSION['awardeeId'] = $AddQuery->insert_id;
      $AddQuery->close();
	  
	  makeCertificate();
}

//......................................................................................
//function to make certificate

function makeCertificate() {
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "lozadas-db", "ZM18X2OT5DBHUvi0", "lozadas-db");
		if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	} 
	
	if(isset($_SESSION['awardeeId'])) {
	$awardeeId = $_SESSION['awardeeId'];
	unset($_SESSION['awardeeId']);
	$_SESSION['awardeeId2'] = $awardeeId; //pass to email sending page 
} else {
	echo "Award is not created";
	exit();
}

$userId = $_SESSION['id'];

//query the awardee's name, email and award type
$fname = NULL;
$lname = NULL;
$awardTid = NULL;
$emailAddr = NULL;
if (!($stmt = $mysqli->prepare("SELECT tid, fname, lname, email FROM award WHERE id=?"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

if (!($stmt->bind_param("i", $awardeeId))) {
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

if (!($stmt->execute())) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
if (!$stmt->bind_result($awardTid, $fname, $lname, $emailAddr)) {
		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	$stmt->fetch();
	$stmt->close();
if ($awardTid == 1) {
	$awardtype = "MonthAward";
} else {
	$awardtype = "YearAward";
}

//query name of user

$userfname = NULL;
$userlname = NULL;

//query signature based on user's lastname from DB

	$out_image = NULL;         //hold the binary file of image

	if (!($stmt = $mysqli->prepare("SELECT fname, lname, signature FROM user WHERE id=?"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	if (!($stmt->bind_param("i", $userId))) {
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if (!($stmt->execute())) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if (!($stmt->store_result())) {
		echo "Store Result failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if (!($stmt->bind_result($userfname, $userlname, $out_image))) {
		echo "Bind Result failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	$stmt->fetch();
	$stmt->close();

	$numBytes = file_put_contents("./pdfTemp/images/sig.jpg", $out_image);    //output image to jpg file. 
	if ($numBytes <= 0) {
		echo "Fail to get user's signature image, enter user's last name as User1, User2, or User3 for testing";
		exit();
	}

//open the template
	if ($awardtype == "YearAward") {
		$newFile =  "template1.tex";
	} else if ($awardtype == "MonthAward") {
		$newFile =  "template2.tex";
	} else {
		echo "Award type doesn't exist!";
		exit ();
	}
 $tempFile = "./Templates/" . $newFile;
 $outPutData = file_get_contents($tempFile);
 $awardee = $fname . ' ' . $lname;
 $username = $userfname . ' ' . $userlname;

 $tans = array("@@employeeName@@" => $awardee, "@@userName@@" => $username);
 $newout = strtr($outPutData, $tans);

 $newFileName = "./pdfTemp/". $lname . "ctf.tex";
 $baseName = $lname . "ctf.tex";
 
 file_put_contents($newFileName, $newout);
 
 $fileContent = $awardee . ' ' . $username . ' ' . $awardtype . ' ' . $emailAddr;  
 file_put_contents('names.txt', $fileContent);      //save the names, email in the file for sending email

 chdir('pdfTemp');

 $command = "/usr/bin/pdflatex " . $baseName;

 $last_line = shell_exec($command);
 //header("Content-type: application/pdf");
 //$pdf = $lname . 'ctf.pdf';
 //readfile($pdf);
}
   
//End of function to make certificate ................................................................

        
   

    


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
				echo "<td>Emp of Year</td>";
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
