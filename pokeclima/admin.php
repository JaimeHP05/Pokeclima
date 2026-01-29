<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') { //Security stuff
    die("Access Denied.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_city'])) {
    $name = $_POST['name'];
    $api_id = $_POST['api_id'];
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];

    $sql = "INSERT INTO locations (name, api_id, map_id, lat, lng) VALUES ('$name', '$api_id', 1, '$lat', '$lng')"; //Default map_id=1 to make it simple
    $conn->query($sql);
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM locations WHERE id = " . intval($id)); //intval to avoid SQL Injection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>
<body>
    <nav class="main-nav">
        <div class="nav-logo">Admin Panel</div>
        <div class="nav-links"><a href="index.php">Back to Map</a></div>
    </nav>

    <div class="admin-container">
        <h1>Add New Location</h1>
        
        <div class="admin-panel-layout">
            <div style="flex: 1;">
                <form method="POST">
                    <label>City Name</label>
                    <input type="text" name="name" class="admin-input" required>
                    
                    <label>API ID (e.g. Madrid,ES)</label>
                    <input type="text" name="api_id" class="admin-input" required>
                    
                    <label>Latitude</label>
                    <input type="text" name="lat" id="input-lat" class="admin-input" readonly required>

                    <label>Longitude</label>
                    <input type="text" name="lng" id="input-lng" class="admin-input" readonly required>

                    <button type="submit" name="add_city" class="btn-add">Add Location</button>
                </form>
            </div>

            <div style="flex: 2;">
                <div id="admin-map" style="height: 400px; border: 1px solid #ccc;"></div>
                <p style="text-align: center; font-size: 0.9rem; color: #666;">Click on the map to set coordinates.</p>
            </div>
        </div>

        <h3>Existing Locations</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Lat / Lng</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM locations");
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['lat'] . " / " . $row['lng'] . "</td>";
                    echo "<td><a href='admin.php?delete=" . $row['id'] . "' class='btn-delete'>Delete</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="js/app.js"></script>
</body>
</html>