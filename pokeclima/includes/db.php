<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pokeclima";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8"); //utf8 because ñ and tildes
?>