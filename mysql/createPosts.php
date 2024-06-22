<?php
require_once("./database_vars.php");
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create tables here
    // Example:
    $pdo->exec("CREATE TABLE IF NOT EXISTS posts (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        content TEXT,
        user_id INT(11) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )");

    echo "Tables created successfully.";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>