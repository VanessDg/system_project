<?php
$servername = "localhost"; // Change if necessary
$username = "root"; // Default for XAMPP
$password = ""; // Leave empty for XAMPP
$database = "system_project"; // Your database name

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
