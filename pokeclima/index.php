<?php
include 'includes/db.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- mobile stuff and not zooming -->
    <title>PokeClima</title>
    <link rel="icon" type="image/png" href="https://img.pokemondb.net/sprites/heartgold-soulsilver/back-normal/pikachu.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>
<body style="background-image: url('https://img.pokemondb.net/images/lets-go-pikachu-eevee/kanto-region-map-lets-go.jpg');">

    <nav class="main-nav">
        <div class="nav-logo">PokeClima</div>
        <div class="nav-links">
            <!-- "Hello" or "Login" -->
            <?php 
            if(isset($_SESSION['user_id'])) {
                echo "<span>Hello, " . $_SESSION['username'] . "</span>";
                if($_SESSION['role'] == 'admin') {
                    echo '<a href="admin.php">Admin Panel</a>';
                }
                echo '<a href="logout.php">Logout</a>';
            } else {
                echo '<a href="login_form.php">Login</a>';
                echo '<a href="register_form.php">Register</a>';
            }
            ?>
        </div>
    </nav>

    <main>
        <div class="map-wrapper">
            <div id="map-container"></div>
        </div>

        <!-- Favorites section -->
        <?php if(isset($_SESSION['user_id'])): ?>
        <div class="favorites-wrapper">
            <h3 class="fav-title">My Favorite Cities</h3>
            <div id="favorites-list" class="fav-grid">
                </div>
        </div>
        <?php endif; ?>
    </main>

    <script src="js/app.js"></script> <!-- do not move -->
</body>
</html>