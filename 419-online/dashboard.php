<?php

session_start();

$sesstype=$_SESSION['type'];
$check = 'user';
include("checktypeadmin.php");

include("mysqlconnect.php");
db_connect();

error_reporting(E_ALL);

if(!$_SESSION["id"]){
  echo "You are not logged in!";
  header("location: login.php");
  echo '<br/>Please <a href="login.php" class="btn btn-primary btn-lg active" role="button">Login</a>';
  die();
}




$sessid=$_SESSION['id'];

$results = mysql_query("SELECT * FROM admin WHERE id='$sessid'");
$rows = mysql_fetch_array($results);
$sessname = $rows['email'];

?>


<!DOCTYPE html>
<html>

<head>
 <title>Upsilon Employee Recognition</title>
 <meta charset="UTF-8">
 	
  <script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
  <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/latest/css/bootstrap.css" />
 
<!-- Include Date Range Picker -->
  <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
  <link href="site.css" rel="stylesheet">

<link href="site.css" rel="stylesheet">
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

		 var data = new google.visualization.arrayToDataTable([
		  ['Award Type', 'Number of awards'],

		  <?php
				
			$result = mysql_query("SELECT (SELECT title from award_type where id=tid)AS
									awardType,count(tid)AS count FROM award GROUP BY tid");
			while($row=mysql_fetch_assoc($result))
			{
				echo "['".$row['awardType']."',".$row['count']."],";	
			}	
			?>	

		]);

		var data1=new google.visualization.arrayToDataTable([
		['Date', 'Number of user accounts created'],	
					
		  <?php
				
			$result = mysql_query("SELECT date_stamp,count(date_stamp)AS count FROM user group by date_stamp");
			while($row=mysql_fetch_assoc($result))
			{
				echo "['".$row['date_stamp']."',".$row['count']."],";	
			}	
			?>	
		]);

				
		var data2=new google.visualization.arrayToDataTable([
		['Date', 'Number of user accounts created'],	
					
		  <?php
				
			$result = mysql_query("SELECT date_award,count(date_award) AS count FROM award GROUP BY date_award");
			while($row=mysql_fetch_assoc($result))
			{
				echo "['".$row['date_award']."',".$row['count']."],";	
			}	
			?>	
		]);

   		var options = {
       		title: 'Percentage of awards created by award type',
       		//chartArea: {width: '60%'},
       		is3D: true, 
        	colors: ['#1b9e77', '#d95f02', '#7570b3'], 
			hAxis: {
         	title: 'Number of awards',
        	minValue: 0
			},
      	};

		var options1 = {
        title: "Number of user acount created per day",
        colors: ['#1b9e77', '#d95f02', '#7570b3'], 
		legend: { position: "none" },
      };	

		var options2 = {
        title: "Number of awards per day",
        colors: ['#d95f02', '#7570b3'], 
		legend: { position: "none" },
	};	
        // Instantiate and draw charts.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
		
        var chart1 = new google.visualization.ColumnChart(document.getElementById('chart_div1'));
        chart1.draw(data1, options1);
	
        var chart2 = new google.visualization.ColumnChart(document.getElementById('chart_div2'));
        chart2.draw(data2, options2);

	
      }
    </script>
</head>

<body>

<h1>Upsilon Employee Recognition: <?php echo $sessname; ?></h1>
<nav id="nav01"></nav>

<div id="main">
<a href="logout.php" class="logoutLblPos">sign out</a>

<div id="chart_div" style="width: 900px; height: 500px;"></div>
<div id="chart_div1" style="width: 1000px; height: 500px;"></div>
<div id="chart_div2" style="width: 1000px; height: 500px;"></div>

</body>
</html>
<script src="script.js"></script>


