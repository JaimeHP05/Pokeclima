<?php
include 'includes/db.php';
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user); //s = string
    $stmt->execute();
    
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) { //if the user exists...
        if (password_verify($pass, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            
            header("Location: index.php");
            exit;
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="https://img.pokemondb.net/sprites/heartgold-soulsilver/back-normal/pikachu.png">
</head>
<body>
    
    <nav class="auth-nav">
        <a href="index.php">Back to Map</a>
    </nav>

    <div class="auth-container">
        <h2 class="auth-title">Login</h2>
        
        <form method="POST">
            <label>Username:</label>
            <input type="text" name="username" class="form-input" required>
            
            <label>Password:</label>
            <input type="password" name="password" class="form-input" required>

            <button type="submit" class="btn-submit">Login</button>
        </form>
        
        <p class="error-msg"><?php echo $error; ?></p>
        
        <div class="auth-footer">
            <a href="register_form.php">Don't have an account? Register</a>
        </div>
    </div>
</body>

</html>
