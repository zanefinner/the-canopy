<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}
require_once("mysql/database_vars.php");
$dbname = $database;
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Seed the posts table with sample data
    $stmt = $pdo->query("SELECT posts.*, users.username FROM posts
                         JOIN users ON posts.user_id = users.id");
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);



} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Canopy - Dashboard</title>
    <?php require_once "frontend/html/head.php"?>

</head>

<body>
    <?PHP require_once "frontend/html/nav.php" ?>
    <div class="container">
        <div class="spacer-top"></div>
        <h1>Welcome back, <?php echo $_SESSION['username']?></h1>
        <div class="spacer-top"></div>

        <div class="row">
            <div class="col-md-4">
                <h2>Feed</h2>
                <div class="list-group"style="background-color: transparent;">
                    <?php foreach ($posts as $post): ?>
                    <div class="list-group-item"style="color: white; background-color: rgba(148, 0, 211, 0.3);"  >
                        <h5 class="mb-1"><?php echo htmlspecialchars($post['title']); ?></h5>
                        <p class="mb-1"><?php echo htmlspecialchars($post['content']); ?></p>
                        <small><?php echo htmlspecialchars($post['created_at']); ?></small>
                        <small>Posted by <?php echo htmlspecialchars($post['username']); ?> on <?php echo htmlspecialchars($post['created_at']); ?></small>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-4">
                <h2>Your Current Grows</h2>
            </div>
            <div class="col-md-4">
                <h2>Friends</h2>
            </div>
        </div>
    </div>
    </div>
    <?php require_once "frontend/html/footer.php"?>
                        
</body>

</html>