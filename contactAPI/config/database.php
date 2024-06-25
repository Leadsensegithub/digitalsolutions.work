<?php
// used to connect to the database
// $host = "localhost";
// $db_name = "ds_data";
// $username = "root";
// $password = "Santhiya@19";

$host = "localhost";
$db_name = "DS_Data";
$username = "DSdata123";
$password = "Digitalsolutions@123";

try {
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
}
  
// show error
catch(PDOException $exception){
    echo "Connection error: " . $exception->getMessage();
}
?>
