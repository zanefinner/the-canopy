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

    // Handle post deletion
    if (isset($_POST['delete_post_id'])) {
        $post_id = $_POST['delete_post_id'];
        $stmt = $pdo->prepare("DELETE FROM posts WHERE id = :post_id AND user_id = :user_id");
        $stmt->bindParam(':post_id', $post_id);
        $stmt->bindParam(':user_id', $_SESSION['id']);
        $stmt->execute();
        header("Location: dashboard.php");
        exit;
    }

    // Handle post editing
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_post_id'])) {
        $post_id = $_POST['edit_post_id'];
        $title = $_POST['title'];
        $content = $_POST['content'];

        $stmt = $pdo->prepare("UPDATE posts SET title = :title, content = :content WHERE id = :post_id AND user_id = :user_id");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':post_id', $post_id);
        $stmt->bindParam(':user_id', $_SESSION['id']);
        $stmt->execute();
        header("Location: dashboard.php");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $user_id = $_SESSION['id'];

        $stmt = $pdo->prepare("INSERT INTO posts (title, content, user_id) VALUES (:title, :content, :user_id)");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        header("Location: dashboard.php");
        exit;
    }

    // Fetch your posts
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE user_id = :user_id ORDER BY created_at DESC");
    $stmt->bindParam(':user_id', $_SESSION['id']);
    $stmt->execute();
    $your_posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch posts by other users
    $stmt = $pdo->prepare("SELECT posts.*, users.username FROM posts
                           JOIN users ON posts.user_id = users.id
                           WHERE posts.user_id != :user_id
                           ORDER BY posts.created_at DESC");
    $stmt->bindParam(':user_id', $_SESSION['id']);
    $stmt->execute();
    $other_posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch only photos uploaded by the current user
    $stmt = $pdo->prepare("SELECT * FROM images WHERE user_id = :user_id ORDER BY created_at DESC");
    $stmt->bindParam(':user_id', $_SESSION['id']);
    $stmt->execute();
    $photos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT username FROM users WHERE id != :user_id");
    $stmt->bindParam(':user_id', $_SESSION['id']);
    $stmt->execute();
    $friends = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <?php require_once "frontend/html/head.php" ?>
    
    <style>
 

 body {
      background-color: #343a40;
      color: white;
    }

    .card {
      background-color: #424242;
      border-color: #757575;
    }

    .card-header {

      border-bottom: 1px solid #757575;
      color: white;
    }
    .card-body{
        color: white;
    }

    .btn-primary {
      background-color: #2196f3;
      border-color: #2196f3;
    }

    .btn-primary:hover {
      background-color: #0d47a1;
      border-color: #0d47a1;
    }

    @media (min-width: 992px) {
        .feed-column {
            flex: 0 0 66.666667%;
            max-width: 66.666667%;
        }
    }
    </style>
</head>

<body>
    <?php require_once "frontend/html/nav.php" ?>
    <div class="container">
        <div class="spacer-top"></div>
        <h1 class="mb-4">Welcome back, <?php echo htmlspecialchars($_SESSION['username']) ?></h1>

        <!-- Add Post Form -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Add a Post</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" name="title" placeholder="Title" required>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="content" rows="3"
                                    placeholder="What's on your mind?" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Post</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row mt-4">
            <!-- Feed Column -->
            <div class="col-lg-8 feed-column">
                <h2>Feed</h2>
                <!-- Posts by other users -->
                <?php foreach ($other_posts as $post) : ?>
                <div class="card post-card">
                    <div class="card-header">
                        <h5 class="mb-1"><?php echo htmlspecialchars($post['title']); ?></h5>
                        <small>Posted by <?php echo htmlspecialchars($post['username']); ?> on
                            <?php echo htmlspecialchars($post['created_at']); ?></small>
                    </div>
                    <div class="card-body post-content">
                        <p class="mb-1"><?php echo htmlspecialchars($post['content']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Your Profile -->
                <h2>Your Profile</h2>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-1"><?php echo htmlspecialchars($_SESSION['username']); ?></h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
                        <p><strong>Joined:</strong> <?php echo htmlspecialchars($_SESSION['created_at']); ?></p>
                        <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
                    </div>
                </div>

                <!-- Your Posts -->
                <h2 class="mt-4">Your Posts</h2>
                <!-- Display your posts -->
                <?php foreach ($your_posts as $post) : ?>
                <div class="card post-card">
                    <div class="card-header">
                        <h5 class="mb-1"><?php echo htmlspecialchars($post['title']); ?></h5>
                        <small>Posted on <?php echo htmlspecialchars($post['created_at']); ?></small>
                    </div>
                    <div class="card-body post-content">
                        <p class="mb-1"><?php echo htmlspecialchars($post['content']); ?></p>
                        <!-- Edit and Delete buttons -->
                        <div class="d-flex justify-content-end mt-3">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <input type="hidden" name="edit_post_id" value="<?php echo $post['id']; ?>">
                                <button type="submit" class="btn btn-primary mr-2">Edit</button>
                            </form>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <input type="hidden" name="delete_post_id" value="<?php echo $post['id']; ?>">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>


            </div>
        </div>
        <div class="row">
            <!-- Your Photos -->
            <h2 class="mt-4">Your Photos</h2>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="file" id="file">
                    <input type="submit" value="Upload File" name="submit">
                </form>
            <!-- Display user's photos -->
            <?php foreach ($photos as $photo) : ?>
            <div class="card col-lg-2 post-card">
                <div class="card-header">
                    <small>Uploaded on <?php echo htmlspecialchars($photo['created_at']); ?></small>
                </div>
                <a target="_blank" href="/uploads/<?php echo htmlspecialchars($photo['filename'])?>">
                    <div class="card-body post-content">
                        <img src="/uploads/<?php echo htmlspecialchars($photo['filename']); ?>" alt="Photo"
                            class="img-fluid">
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>