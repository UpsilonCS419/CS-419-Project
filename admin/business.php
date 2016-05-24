
<?PHP
include("mysqlconnect.php");
db_connect();
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html>

<head>
 <title>Upsilon Employee Recognition</title>
 <meta charset="UTF-8">
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
   		var options = {
       		title: 'Number of awards per type',
       		chartArea: {width: '50%'},
       		hAxis: {
         	title: 'Number of awards',
        	minValue: 0
        	},
      	};


        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
</head>
<body>

<h1>Upsilon Employee Recognition</h1>
<nav id="nav01"></nav>

<div id="main">

  <a href="url" class="logoutLblPos">sign out</a>


<div id="chart_div"/>
<script src="script.js"></script>

</body>
</html>
