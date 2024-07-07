<?php
$servername = "your_servername";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Database connection established"; // Debugging line
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}