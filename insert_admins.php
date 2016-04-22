<!DOCTYPE html>
<html>

<head>
  <title>Insert Record</title>
  <meta charset="UTF-8">
  <link href="site.css" rel="stylesheet">
</head>

<body>

<div id="main">
<h1>Inserting Records:</h1>


<?PHP
include("mysqlconnect.php");
db_connect();
error_reporting(E_ALL);

$name = $_POST['name'];
$category = $_POST['category'];
$vendor=$_POST['vendor'];
$price=$_POST['price'];


//$cid=$row['id'];
$vid=$row1['id'];
$sql = "INSERT INTO products (name,cid,vid,price)
 VALUES ('$name', (SELECT id from categories WHERE name='$category'),(SELECT id from vendors WHERE name='$vendor') ,'$price')";
$result = mysql_query($sql);
if (!$result) 
{
    die('Invalid query: ' . mysql_error());
}

echo "Record has been inserted successfully, please wait while redirecting...";
echo "<script type='text/javascript'> document.location = 'inventory.php'; </script>";
?>

</div>
</body>
</html>
