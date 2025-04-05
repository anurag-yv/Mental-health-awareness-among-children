<?php
$servername = "localhost";
$username = "root";
$password = ""; // Make sure MySQL password is correct
$dbname = "mind";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
