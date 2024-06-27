<?php
require_once("mysql/database_vars.php");
$dbname = $database;
try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL query to create the images table
    $sql = "CREATE TABLE IF NOT EXISTS images (
                id INT AUTO_INCREMENT PRIMARY KEY,
                filename VARCHAR(255) NOT NULL,
                user_id INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id)
            )";

    // Execute the query
    $pdo->exec($sql);

    echo "Images table created successfully.";
} catch (PDOException $e) {
    echo "Error creating images table: " . $e->getMessage();
}
?>