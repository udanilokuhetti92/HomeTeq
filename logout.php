<?php
session_start();
$pagename="Logout";
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>";
echo "<title".$pagename."</title>";
echo "<body";
include ("headfile.html");
include("detectlogin.php");
echo "<h4>".$pagename."</h4>";

//Display thank you message 
echo "<p>Thank you!</p>";
//unset the session 
//destroy the session 
session_destroy();
//Display a log out confirmation message
echo "<p>You are now logged out.</p>"; 

include("footfile.html"); 

echo "</body>";
?>