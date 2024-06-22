<?php
$host = 'localhost';
$dbname = 'test';
$username = 'zane';
$password = '5245';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Seed the 'strains' table
    $strains = [
        ['name' => 'OG Kush', 'description' => 'A popular strain known for its strong effects and unique aroma.'],
        ['name' => 'Sour Diesel', 'description' => 'A sativa strain known for its energizing effects and diesel-like aroma.'],
        ['name' => 'Blue Dream', 'description' => 'A hybrid strain known for its balanced effects and blueberry aroma.'],
        ['name' => 'Girl Scout Cookies', 'description' => 'A hybrid strain known for its euphoric effects and sweet, earthy aroma.'],
        ['name' => 'White Widow', 'description' => 'A hybrid strain known for its potent effects and white, crystal-covered buds.'],
    ];

    $stmt = $pdo->prepare("INSERT INTO strains (name, description) VALUES (:name, :description)");
    foreach ($strains as $strain) {
        $stmt->execute($strain);
    }

    // Seed the 'characteristics' table
    $characteristics = [
        ['name' => 'Potency', 'description' => 'The strength of the strain.'],
        ['name' => 'Aroma', 'description' => 'The smell of the strain.'],
        ['name' => 'Flowering Time', 'description' => 'The time it takes for the strain to flower.'],
    ];

    $stmt = $pdo->prepare("INSERT INTO characteristics (name, description) VALUES (:name, :description)");
    foreach ($characteristics as $characteristic) {
        $stmt->execute($characteristic);
    }

    // Seed the 'strain_characteristics' table
    $strain_characteristics = [
        ['strain_id' => 1, 'characteristic_id' => 1, 'value' => 'High'],
        ['strain_id' => 1, 'characteristic_id' => 2, 'value' => 'Earthy, Pine'],
        ['strain_id' => 1, 'characteristic_id' => 3, 'value' => '8-9 weeks'],
        
        ['strain_id' => 2, 'characteristic_id' => 1, 'value' => 'High'],
        ['strain_id' => 2, 'characteristic_id' => 2, 'value' => 'Diesel, Pungent'],
        ['strain_id' => 2, 'characteristic_id' => 3, 'value' => '10-11 weeks'],
        
        ['strain_id' => 3, 'characteristic_id' => 1, 'value' => 'Medium'],
        ['strain_id' => 3, 'characteristic_id' => 2, 'value' => 'Blueberry, Sweet'],
        ['strain_id' => 3, 'characteristic_id' => 3, 'value' => '9-10 weeks'],
        
        ['strain_id' => 4, 'characteristic_id' => 1, 'value' => 'High'],
        ['strain_id' => 4, 'characteristic_id' => 2, 'value' => 'Sweet, Earthy'],
        ['strain_id' => 4, 'characteristic_id' => 3, 'value' => '9-10 weeks'],
        
        ['strain_id' => 5, 'characteristic_id' => 1, 'value' => 'High'],
        ['strain_id' => 5, 'characteristic_id' => 2, 'value' => 'Earthy, Woody'],
        ['strain_id' => 5, 'characteristic_id' => 3, 'value' => '8-9 weeks'],
    ];

    $stmt = $pdo->prepare("INSERT INTO strain_characteristics (strain_id, characteristic_id, value) VALUES (:strain_id, :characteristic_id, :value)");
    foreach ($strain_characteristics as $strain_characteristic) {
        $stmt->execute($strain_characteristic);
    }

    echo "Data seeded successfully.";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$pdo = null;
?>