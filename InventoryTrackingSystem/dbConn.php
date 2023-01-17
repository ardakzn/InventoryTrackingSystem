<?php
$database= mysqli_connect("localhost","root","","its_db");
if(!$database)
{
    die("Connection failed: " . mysqli_connect_error());
}


?>