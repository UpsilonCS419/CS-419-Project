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

$id=$_POST['id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email=$_POST['email'];
$phone=$_POST['phone'];
$address_line1 = $_POST['address_line1'];
$address_line2 = $_POST['address_line2'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip_code = $_POST['zip_code'];
$country =$_POST['country'];

$sql = "UPDATE customers  SET
first_name='$first_name',last_name='$last_name',email='$email',phone='$phone',address_line1='$address_line1',address_line2='$address_line2',city='$city',state='$state',zip_code='$zip_code',country='$country'
where id='$id'";


$result = mysql_query($sql);
if (!$result) 
{
    die('Invalid query: ' . mysql_error());
}

echo "Record has been updated successfully, please wait while redirecting...";
echo "<script type='text/javascript'> document.location = 'customers.php'; </script>";
?>

</div>
</body>
</html>
