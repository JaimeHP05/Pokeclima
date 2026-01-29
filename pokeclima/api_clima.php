 <?php
error_reporting(0); //Warnings are not JSON, breaks the API
header('Content-Type: application/json');
include 'includes/db.php';
session_start();

$api_key = "33c649d076b4df434808ec9f1974662b";

$user_favorites = [];
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $res_fav = $conn->query("SELECT location_id FROM user_favorites WHERE user_id = $user_id");
    while($row = $res_fav->fetch_assoc()) {
        $user_favorites[] = $row['location_id'];
    }
}

$sql = "SELECT * FROM locations";
$result = $conn->query($sql);

$response_data = []; //Mickey herramienta
$error_img = "https://img.pokemondb.net/sprites/home/normal/unown-qm.png";

$context_options = [ //XAMPP lacks SSL, so we disable verification
    "ssl" => [
        "verify_peer" => false,
        "verify_peer_name" => false,
    ]
];
$context = stream_context_create($context_options);

while($loc = $result->fetch_assoc()) {

    $lat = $loc['lat']; //latitude
    $lng = $loc['lng']; //longitude
    $url = "https://api.openweathermap.org/data/2.5/weather?lat=$lat&lon=$lng&appid=$api_key&units=metric";
    $json_data = @file_get_contents($url, false, $context);
        //Go directly to $url, do not check the include path
    $api_success = false;

    if ($json_data) {
        $weather_data = json_decode($json_data, true);
        
        if (isset($weather_data['main']['temp'])) {
            $temp = round($weather_data['main']['temp']);
            $condition_code = $weather_data['weather'][0]['main']; 
            $api_success = true;
        }
    }

    if (!$api_success) { //If API fails throw Unown
        $temp = "?";
        $condition_code = "Unknown";
        $pokemon_img = $error_img;
    } else { //If API works, get the Pokémon
        $sql_poke = "SELECT image_url FROM weather_pokemon WHERE weather_condition = '$condition_code' LIMIT 1";
        $res_poke = $conn->query($sql_poke);
        
        if ($res_poke && $res_poke->num_rows > 0) {
            $poke_row = $res_poke->fetch_assoc();
            $pokemon_img = $poke_row['image_url'];
        } else {
            $pokemon_img = $error_img;
        }
    }

    $is_fav = in_array($loc['id'], $user_favorites); //Check if ID is in the list

    $response_data[] = [
        'id' => $loc['id'],
        'city_name' => $loc['name'],
        'lat' => $loc['lat'],
        'lng' => $loc['lng'],
        'temp' => $temp,
        'img' => $pokemon_img,
        'condition' => $condition_code,
        'is_favorite' => $is_fav
    ];
}

echo json_encode($response_data); //Turn PHP to JSON text and send to web
?>