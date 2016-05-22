<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

echo '<html><head><meta charset="UTF-8"/><title>Test Page</title></head><body>';
echo '<form action="latex.php" method="POST" target="_blank">';
echo 'Awardee First Name <input type="text" name="fName" >';
echo "<br/>";     //newline
echo 'Awardee Last Name <input type="text" name="lName" >';
echo "<br/>"; 
echo 'Award Type <input type = "text" name = "awardType" >';
echo "<br/>";
echo 'User First Name <input type="text" name="userFName" >';
echo "<br/>";     //newline
echo 'User Last Name <input type="text" name="userLName" >';
echo "<br/>"; 
echo '<input type = "submit" value ="Submit">';

echo '</form>';		
echo "<br>";
echo '<form action="mail.php" method="POST" target="_blank">';
echo 'Email Address <input type="email" name="email" >';
echo "<br/>"; 
echo '<input type = "submit" value ="SubmitEmail">';
echo '</form>';	
echo '</body></html>';

?>