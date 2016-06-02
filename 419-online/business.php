<?php
session_start();

$sesstype=$_SESSION['type'];
$check = 'admin';


include("checktypeadmin.php");
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
  
  
  <!-- Include Required Prerequisites -->
  <!--http://www.daterangepicker.com/ Instruction for date ranger picker found at site -->
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/latest/css/bootstrap.css" />
 
<!-- Include Date Range Picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
  
 <link href="site.css" rel="stylesheet">
</head>

<body>

<h1>Upsilon Employee Recognition</h1>
<nav id="nav01"></nav>

<div id="main">

  <a href="logout.php" class="logoutLblPos">sign out</a>


<h2>Award Filters</h2>
<form method="POST" action="">
<select name="typelists">
<option value="allTypes" name="allTypes">All Types of Awards</option>
<option value="monthly">Monthly</option>
<option value="yearly">Yearly</option>
</select>

<?php
		$userList = "SELECT id, email FROM user ORDER BY email";
		$userFilter = $con->prepare($userList);
		$userFilter->execute();
		$userID = NULL;
		$catList1 = NULL;
		$userFilter->bind_result($userID, $catList1);
		echo '<select name= "userEmails">';
		echo '<option value="allUsers" name="allUsers">All Users</option>';
		while($userFilter->fetch()){
			$list1 = $catList1;
			if($list1 != NULL){
				echo '<option value="'.$list1.'">'.$list1.'</option>';
			}
		}
		echo '</select>';
		$userFilter->close();
		
             ?>

Date Range<input type="text" name="datefilter" value=""/>
 
<script type="text/javascript">

//date range picker helped from http://www.daterangepicker.com/
//use with jquery
$(function() {

  $('input[name="datefilter"]').daterangepicker({
      autoUpdateInput: false,
      locale: {
          cancelLabel: 'Clear'
      }
  });

  $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
  });

  $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });

});
</script>
<input type="submit" value="Filter" name="filtering" class="submit">
</form>
<hr>




<?PHP

//header('Content-Type: text/csv; charset=utf-8');
//header('Content-Disposition: attachment; filename=data.csv');


if(isset($_POST['filtering'])){
	
	if($_POST['datefilter']!=NULL){
		$postdata = $_POST['datefilter'];
		$parts = explode(' ', $postdata);
		$firstdate = $parts[0];
		$seconddate = $parts[2];
		
		$rawdate1=htmlentities($firstdate);
		$date1 = date('Y-m-d', strtotime($rawdate1));
		
		$rawdate2=htmlentities($seconddate);
		$date2 = date('Y-m-d', strtotime($rawdate2));
		
		echo $date1;
		echo '<br/>';
		echo $date2;
		echo '<br/>';
	
	}
	$userSort = $_POST['userEmails'];
	
	if($_POST['typelists']=="allTypes" && $_POST['datefilter']!=NULL && $userSort=="allUsers"){
		$filter = "SELECT award.id, award.fname, award.lname, award.email, award.date_award, award.time_award,
		user.email, user.fname, user.lname, user.signature, award_type.title FROM award 
		INNER JOIN user ON award.uid = user.id
		INNER JOIN award_type ON award.tid = award_type.id WHERE award.date_award >= '".$date1."' AND award.date_award <= '".$date2."'";
	}
	
	else if($_POST['typelists']=="monthly" && $_POST['datefilter']!=NULL && $userSort=="allUsers"){
		$filter = "SELECT award.id, award.fname, award.lname, award.email, award.date_award, award.time_award,
		user.email, user.fname, user.lname, user.signature, award_type.title FROM award 
		INNER JOIN user ON award.uid = user.id
		INNER JOIN award_type ON award.tid = award_type.id WHERE award.date_award >= '".$date1."' AND award.date_award <= '".$date2."' AND award_type.id = 1";
	}
    
    else if($_POST['typelists']=="yearly" && $_POST['datefilter']!=NULL && $userSort=="allUsers"){
		$filter = "SELECT award.id, award.fname, award.lname, award.email, award.date_award, award.time_award,
		user.email, user.fname, user.lname, user.signature, award_type.title FROM award 
		INNER JOIN user ON award.uid = user.id
		INNER JOIN award_type ON award.tid = award_type.id WHERE award.date_award >= '".$date1."' AND award.date_award <= '".$date2."' AND award_type.id = 2";
	}
	else if($_POST['typelists']=="allTypes" && $_POST['datefilter']==NULL && $userSort=="allUsers"){
		$filter = "SELECT award.id, award.fname, award.lname, award.email, award.date_award, award.time_award,
		user.email, user.fname, user.lname, user.signature, award_type.title FROM award 
		INNER JOIN user ON award.uid = user.id
		INNER JOIN award_type ON award.tid = award_type.id";
	}
	else if($_POST['typelists']=="monthly" && $_POST['datefilter']==NULL && $userSort=="allUsers"){
		$filter = "SELECT award.id, award.fname, award.lname, award.email, award.date_award, award.time_award,
		user.email, user.fname, user.lname, user.signature, award_type.title FROM award 
		INNER JOIN user ON award.uid = user.id
		INNER JOIN award_type ON award.tid = award_type.id WHERE award_type.id = 1";
	}
	else if($_POST['typelists']=="yearly" && $_POST['datefilter']==NULL && $userSort=="allUsers"){
		$filter = "SELECT award.id, award.fname, award.lname, award.email, award.date_award, award.time_award,
		user.email, user.fname, user.lname, user.signature, award_type.title FROM award 
		INNER JOIN user ON award.uid = user.id
		INNER JOIN award_type ON award.tid = award_type.id WHERE award_type.id = 2";
	}
	
	
	//second filter
	
	else if($_POST['typelists']=="allTypes" && $_POST['datefilter']!=NULL){
		$filter = "SELECT award.id, award.fname, award.lname, award.email, award.date_award, award.time_award,
		user.email, user.fname, user.lname, user.signature, award_type.title FROM award 
		INNER JOIN user ON award.uid = user.id
		INNER JOIN award_type ON award.tid = award_type.id WHERE award.date_award >= '".$date1."' AND award.date_award <= '".$date2."' AND user.email = '".$userSort."'";
	}
	
	else if($_POST['typelists']=="monthly" && $_POST['datefilter']!=NULL){
		$filter = "SELECT award.id, award.fname, award.lname, award.email, award.date_award, award.time_award,
		user.email, user.fname, user.lname, user.signature, award_type.title FROM award 
		INNER JOIN user ON award.uid = user.id
		INNER JOIN award_type ON award.tid = award_type.id WHERE award.date_award >= '".$date1."' AND award.date_award <= '".$date2."' AND award_type.id = 1 AND user.email = '".$userSort."'";
	}
    
    else if($_POST['typelists']=="yearly" && $_POST['datefilter']!=NULL){
		$filter = "SELECT award.id, award.fname, award.lname, award.email, award.date_award, award.time_award,
		user.email, user.fname, user.lname, user.signature, award_type.title FROM award 
		INNER JOIN user ON award.uid = user.id
		INNER JOIN award_type ON award.tid = award_type.id WHERE award.date_award >= '".$date1."' AND award.date_award <= '".$date2."' AND award_type.id = 2 AND user.email = '".$userSort."'";
	}
	else if($_POST['typelists']=="allTypes" && $_POST['datefilter']==NULL){
		$filter = "SELECT award.id, award.fname, award.lname, award.email, award.date_award, award.time_award,
		user.email, user.fname, user.lname, user.signature, award_type.title FROM award 
		INNER JOIN user ON award.uid = user.id
		INNER JOIN award_type ON award.tid = award_type.id WHERE user.email = '".$userSort."'";
	}
	else if($_POST['typelists']=="monthly" && $_POST['datefilter']==NULL){
		$filter = "SELECT award.id, award.fname, award.lname, award.email, award.date_award, award.time_award,
		user.email, user.fname, user.lname, user.signature, award_type.title FROM award 
		INNER JOIN user ON award.uid = user.id
		INNER JOIN award_type ON award.tid = award_type.id WHERE award_type.id = 1 AND user.email = '".$userSort."'";
	}
	else if($_POST['typelists']=="yearly" && $_POST['datefilter']==NULL){
		$filter = "SELECT award.id, award.fname, award.lname, award.email, award.date_award, award.time_award,
		user.email, user.fname, user.lname, user.signature, award_type.title FROM award 
		INNER JOIN user ON award.uid = user.id
		INNER JOIN award_type ON award.tid = award_type.id WHERE award_type.id = 2 AND user.email = '".$userSort."'";
	}
	       
        
    }
	
else{
	
	$filter = "SELECT award.id, award.fname, award.lname, award.email, award.date_award, award.time_award,
		user.email, user.fname, user.lname, user.signature, award_type.title FROM award 
		INNER JOIN user ON award.uid = user.id
		INNER JOIN award_type ON award.tid = award_type.id";
	
}

$CatStmt = $con->prepare($filter);
$CatStmt->execute();

$awardid = NULL;
$afname = NULL;
$alname = NULL;
$aemail = NULL;
$adate = NULL;
$atime = NULL;
$uemail = NULL;
$ufname = NULL;
$ulname = NULL;
$usignature = NULL;
$atitle = NULL;


$CatStmt->bind_result($awardid, $afname, $alname, $aemail, $adate, $atime, $uemail, $ufname, $ulname, $usignature, $atitle);
echo "<div class='row'>";
	echo '<h2>Award List</h2><table class="table table-bordered table-hover table-striped">';
	echo '<th>First Name awarded  </th><th>Last Awarded  </th><th>Type Awarded  </th><th>Email Awarded  </th><th>Date Awarded  </th><th>Email of User  </th><th>First Name User  </th><th>last Name User  </th>';
	while($CatStmt->fetch()){
			
		echo '<tr><td>'.$afname.'</td><td>'.$alname.'</td><td>'.$atitle.'</td><td>'.$aemail.'</td><td>'.$adate.'</td><td>'.$uemail.'</td><td>'.$ufname.'</td><td>'.$ulname.'</td></tr>';
		
		
		}

echo "</table>";
echo '</div>';
$CatStmt->close();

?>


<script src="script.js"></script>

</body>
</html>
