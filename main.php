<?php
include './database.php';


$db = new PDO('mysql:host=localhost;dbname=weather_oy_database;charset=utf8mb4', 'taitaja2023', 'b3E1APd9iR9Iyr3j');

// Registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $conn = connect();
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_ARGON2ID);

    $stmt = mysqli_prepare($conn, 'INSERT INTO users (name, password) VALUES (?, ?)');
    mysqli_stmt_bind_param($stmt, 'ss', $username, $password);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

// Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $conn = connect();
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = mysqli_prepare($conn, 'SELECT * FROM users WHERE name = ?');
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        ob_start();
        echo '<div class="user-container">';
        echo '<h1>Welcome ' . $user['name'] . '</h1>';
        echo '</div>';
        $userData = ob_get_clean();
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

// Logout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    $_SESSION = array();

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]  
        );
    }

    session_destroy();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Weather Oy</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Registration Form</h2>
    <form method="post" action="./main.php"> 
        <label for="username">Username:</label>
        <input type="text" id="reg-username" name="username" placeholder="Username" />
        <label for="password">Password:</label>
        <input type="password" id="reg-password" name="password" />
        <input type="submit" name="register" value="Register" />
    </form>

    <h2>Registration Form</h2>
    <form method="post" action="./main.php"> 
        <label for="username">Username:</label>
        <input type="text" id="log-username" name="username" placeholder="Username" />
        <label for="password">Password:</label>
        <input type="password" id="log-password" name="password" />
        <input type="submit" name="login" value="Login" />
    </form>
    <?php echo $userData; ?>
    <form method="post" action="">
        <input type="submit" name="logout" value="Logout" />
    </form>
</body>