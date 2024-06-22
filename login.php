<?php
session_start();

// Database connection parameters
$host = 'localhost';
$database = 'test';
$username = 'zane';
$password = '5245';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if username and password are set
    if (isset($_POST['username']) && isset($_POST['password'])) {
        try {
            // Create a PDO instance
            $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare a select statement
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(':username', $_POST['username']);
            $stmt->execute();
            $user = $stmt->fetch();

            // Verify password
            if ($user && password_verify($_POST['password'], $user['password_hash'])) {
                // Password is correct, start a session
                session_regenerate_id();
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['username'] = $user['username'];
                $_SESSION['id'] = $user['id'];
                header("Location: dashboard.php");
                exit;
            } else {
                // Password is not correct
                $login_err = "Invalid username or password.";
            }
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
    <?php if (isset($login_err)) { ?>
        <p><?php echo $login_err; ?></p>
    <?php } ?>
</body>
</html>
