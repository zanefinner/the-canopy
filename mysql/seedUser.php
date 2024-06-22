<?php
// Database connection parameters
require_once("./database_vars.php");

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create users table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password_hash VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // Seed users table with initial data
    $stmt = $pdo->prepare("
        INSERT INTO users (username, email, password_hash) VALUES
        ('john_doe', 'john.doe@example.com', '" . password_hash('password123', PASSWORD_DEFAULT) . "'),
        ('jane_smith', 'jane.smith@example.com', '" . password_hash('password456', PASSWORD_DEFAULT) . "')
    ");
    $stmt->execute();

    echo "Users table seeded successfully\n";
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>