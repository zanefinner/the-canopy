<?php
require_once("./database_vars.php");

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get user IDs for reference
    $stmt = $pdo->query("SELECT id FROM users");
    $userIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Seed the posts table with random data
    $titles = ['Lorem Ipsum', 'Random Title', 'Test Post', 'Hello World', 'Sample Post'];
    $contents = ['Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                 'Nullam ac lectus nec magna laoreet fermentum.',
                 'Fusce hendrerit, elit non consequat convallis.',
                 'Etiam in nunc sit amet turpis ultricies pulvinar.',
                 'Pellentesque habitant morbi tristique senectus et netus.'];

    foreach ($userIds as $userId) {
        $title = $titles[array_rand($titles)];
        $content = $contents[array_rand($contents)];

        $pdo->exec("INSERT INTO posts (user_id, title, content, created_at) VALUES
            ($userId, '$title', '$content', NOW())
        ");
    }

    echo "Posts seeded successfully.";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>