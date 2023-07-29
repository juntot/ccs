<?php
$servername = "localhost";
$username = "u563804646_user";
$password = "K&Mh[d^M3k";
$dbname = "u563804646_cccs";

$conn = '';
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  return $conn;
} catch(PDOException $e) {
  // echo "Error: " . $e->getMessage();
  die("Unable to connect to database");
  $conn = '';
}

