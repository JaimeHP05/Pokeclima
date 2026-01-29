<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id']) || !isset($_POST['location_id'])) {
    die("Error");
}

$user_id = $_SESSION['user_id'];
$location_id = intval($_POST['location_id']); //int number

$sql_check = "SELECT * FROM user_favorites WHERE user_id = $user_id AND location_id = $location_id";
$result = $conn->query($sql_check);

if ($result->num_rows > 0) { //Already in favorites, so remove it
    $conn->query("DELETE FROM user_favorites WHERE user_id = $user_id AND location_id = $location_id");
    echo "removed";
} else { //Not in favorites, so add it
    $conn->query("INSERT INTO user_favorites (user_id, location_id) VALUES ($user_id, $location_id)");
    echo "added";
}
?>