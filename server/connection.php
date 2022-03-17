<?php 
//data that is needed to connect to MySQL 
  $db_hostname = 'localhost';
  $db_database = 'my_restaurant';
  $db_username = 'root';
  $db_password = '';

//connect to the database using the credentials defined in login.php
$connection = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);

//if the connection fails, we exit the code, and show an error message
if (!$connection)
    die("Unable to connect to MySQL: " . mysqli_connect_errno());
