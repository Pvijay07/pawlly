<?php 

$servername = "localhost";
$username = "u766513033_pawlley";
$password = "";
$database = "u766513033_pawlley";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

?>