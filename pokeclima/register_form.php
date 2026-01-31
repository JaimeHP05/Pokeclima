<?php
include 'includes/db.php';
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $pass_hash = password_hash($pass, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES (?, ?)"; //Prepared statement to avoid SQL Injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $pass_hash); //string and string

    try {
        if ($stmt->execute()) { //Everything is ok
            header("Location: login_form.php");
            exit;
        }
    } catch (mysqli_sql_exception $e) { // uh oh
        if ($e->getCode() == 1062) { //Duplicate entry very important
            $message = "Username already exists.";
        } else { //other error
            $message = "Registration error.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="https://img.pokemondb.net/sprites/heartgold-soulsilver/back-normal/pikachu.png">
</head>
<body>

    <nav class="auth-nav">
        <a href="index.php">Back to Map</a>
    </nav>

    <div class="auth-container">
        <h2 class="auth-title">Register</h2>
        
        <form method="POST">
            <label>Username:</label>
            <input type="text" name="username" class="form-input" required>
            
            <label>Password:</label>
            <input type="password" name="password" class="form-input" required>

            <button type="submit" class="btn-submit">Register</button>
        </form>
        
        <p class="error-msg"><?php echo $message; ?></p>
        
        <div class="auth-footer">
            <a href="login_form.php">Already have an account? Login</a>
        </div>
    </div>
</body>

</html>
