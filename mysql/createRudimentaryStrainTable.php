<?php
$host = 'localhost';
$dbname = 'test';
$username = 'zane';
$password = '5245';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the 'strains' table
    $createStrainsTable = "
        CREATE TABLE IF NOT EXISTS strains (
            strain_id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            description TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ";
    $pdo->exec($createStrainsTable);

    // Create the 'strain_parents' table
    $createStrainParentsTable = "
        CREATE TABLE IF NOT EXISTS strain_parents (
            child_strain_id INT,
            parent_strain_id INT,
            relationship VARCHAR(50),
            PRIMARY KEY (child_strain_id, parent_strain_id),
            FOREIGN KEY (child_strain_id) REFERENCES strains(strain_id),
            FOREIGN KEY (parent_strain_id) REFERENCES strains(strain_id)
        );
    ";
    $pdo->exec($createStrainParentsTable);

    // Create the 'characteristics' table
    $createCharacteristicsTable = "
        CREATE TABLE IF NOT EXISTS characteristics (
            characteristic_id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            description TEXT
        );
    ";
    $pdo->exec($createCharacteristicsTable);

    // Create the 'strain_characteristics' table
    $createStrainCharacteristicsTable = "
        CREATE TABLE IF NOT EXISTS strain_characteristics (
            strain_id INT,
            characteristic_id INT,
            values_list VARCHAR(255),
            PRIMARY KEY (strain_id, characteristic_id),
            FOREIGN KEY (strain_id) REFERENCES strains(strain_id),
            FOREIGN KEY (characteristic_id) REFERENCES characteristics(characteristic_id)
        );
    ";
    $pdo->exec($createStrainCharacteristicsTable);

    echo "Tables created successfully.";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$pdo = null;
?>