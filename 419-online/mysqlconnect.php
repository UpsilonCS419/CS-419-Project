
<?php
function db_connect()
{
  $con=mysql_connect("oniddb.cws.oregonstate.edu","lozadas-db","ZM18X2OT5DBHUvi0");
    if (!$con)
     {
       die('Could not connect: ' . mysql_error());
     }
   mysql_select_db("lozadas-db", $con); 
	return $con;
}
?>

