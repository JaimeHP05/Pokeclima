<?php
include 'includes/db.php';

$conn->query("SET FOREIGN_KEY_CHECKS = 0"); //Delete related table without error

//Delete old stuff if it exists
$conn->query("DROP TABLE IF EXISTS user_favorites");
$conn->query("DROP TABLE IF EXISTS users");
$conn->query("DROP TABLE IF EXISTS locations");
$conn->query("DROP TABLE IF EXISTS maps");
$conn->query("DROP TABLE IF EXISTS weather_pokemon");

//user
$sql_users = "CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'user'
)";
$conn->query($sql_users);

//maps
$sql_maps = "CREATE TABLE maps (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
)";
$conn->query($sql_maps);

//locations
$sql_locs = "CREATE TABLE locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    api_id VARCHAR(50) NOT NULL,
    map_id INT NOT NULL,
    lat DECIMAL(10, 8) NOT NULL,
    lng DECIMAL(10, 8) NOT NULL,
    FOREIGN KEY (map_id) REFERENCES maps(id) ON DELETE CASCADE
)";
$conn->query($sql_locs);

//pokémon
$sql_poke = "CREATE TABLE weather_pokemon (
    id INT AUTO_INCREMENT PRIMARY KEY,
    weather_condition VARCHAR(50) NOT NULL,
    image_url VARCHAR(255) NOT NULL
)";
$conn->query($sql_poke);

//favs
$sql_favs = "CREATE TABLE user_favorites (
    user_id INT NOT NULL,
    location_id INT NOT NULL,
    PRIMARY KEY (user_id, location_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (location_id) REFERENCES locations(id) ON DELETE CASCADE
)";
$conn->query($sql_favs);

//seeding
$conn->query("INSERT INTO maps (id, name) VALUES (1, 'Spain')");

$sql_insert_locs = "INSERT INTO locations (name, api_id, map_id, lat, lng) VALUES 
('Madrid', 'Madrid,ES', 1, 40.4168, -3.7038),
('Barcelona', 'Barcelona,ES', 1, 41.3851, 2.1734),
('Sevilla', 'Sevilla,ES', 1, 37.3891, -5.9845),
('Valencia', 'Valencia,ES', 1, 39.4699, -0.3763),
('Bilbao', 'Bilbao,ES', 1, 43.2630, -2.9350),
('Santiago', 'Santiago de Compostela,ES', 1, 42.8782, -8.5448)";
$conn->query($sql_insert_locs);

$sql_insert_poke = "INSERT INTO weather_pokemon (weather_condition, image_url) VALUES 
('Clear', 'https://img.pokemondb.net/sprites/home/normal/eevee.png'),
('Clouds', 'https://img.pokemondb.net/sprites/home/normal/altaria.png'),
('Rain', 'https://img.pokemondb.net/sprites/home/normal/politoed.png'),
('Drizzle', 'https://img.pokemondb.net/sprites/home/normal/psyduck.png'),
('Thunderstorm', 'https://img.pokemondb.net/sprites/home/normal/zapdos.png'),
('Snow', 'https://img.pokemondb.net/sprites/home/normal/alolan-vulpix.png'),
('Mist', 'https://img.pokemondb.net/sprites/home/normal/gastly.png'),
('Smoke', 'https://img.pokemondb.net/sprites/home/normal/koffing.png'),
('Haze', 'https://img.pokemondb.net/sprites/home/normal/weezing.png'),
('Dust', 'https://img.pokemondb.net/sprites/home/normal/sandslash.png'),
('Fog', 'https://img.pokemondb.net/sprites/home/normal/gengar.png'),
('Sand', 'https://img.pokemondb.net/sprites/home/normal/tyranitar.png'),
('Ash', 'https://img.pokemondb.net/sprites/home/normal/torkoal.png'),
('Squall', 'https://img.pokemondb.net/sprites/home/normal/pidgeot.png'),
('Tornado', 'https://img.pokemondb.net/sprites/home/normal/rayquaza.png')";
$conn->query($sql_insert_poke);

$pass_admin = password_hash("admin", PASSWORD_DEFAULT); //I am the System Security
$conn->query("INSERT INTO users (username, password, role) VALUES ('admin', '$pass_admin', 'admin')");

$conn->query("SET FOREIGN_KEY_CHECKS = 1");

echo "<h1>Installation Complete</h1>";
echo "<a href='index.php'>Go to Main Page</a>";
?>