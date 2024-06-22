<?php
$host = 'localhost';
$dbname = 'test';
$username = 'zane';
$password = '5245';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $title = isset($_GET['title']) ? $_GET['title'] : '';
    $description = isset($_GET['description']) ? $_GET['description'] : '';
    $flowering_time = isset($_GET['flowering_time']) ? $_GET['flowering_time'] : '';
    $potency = isset($_GET['potency']) ? $_GET['potency'] : '';
    $aroma = isset($_GET['aroma']) ? $_GET['aroma'] : '';

    $query = "SELECT strains.name, strains.description, 
              GROUP_CONCAT(characteristics.name SEPARATOR ', ') AS characteristics_list, 
              GROUP_CONCAT(strain_characteristics.values_list SEPARATOR ', ') AS values_list 
              FROM strains 
              LEFT JOIN strain_characteristics ON strains.strain_id = strain_characteristics.strain_id 
              LEFT JOIN characteristics ON strain_characteristics.characteristic_id = characteristics.characteristic_id 
              WHERE strains.name LIKE :title 
              AND strains.description LIKE :description 
              AND (characteristics.name LIKE :flowering_time 
              OR strain_characteristics.values_list LIKE :potency 
              OR strain_characteristics.values_list LIKE :aroma) 
              GROUP BY strains.strain_id";

    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':title' => '%' . $title . '%',
        ':description' => '%' . $description . '%',
        ':flowering_time' => '%' . $flowering_time . '%',
        ':potency' => '%' . $potency . '%',
        ':aroma' => '%' . $aroma . '%'
    ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Strains</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="mt-5 mb-4">Search Cannabis Strains</h1>
    <form method="GET" action="search_strain.php" class="mb-4">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="title">Strain Name</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Strain Name" value="<?php echo htmlspecialchars($title); ?>">
            </div>
            <div class="form-group col-md-6">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="<?php echo htmlspecialchars($description); ?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="flowering_time">Flowering Time</label>
                <input type="text" class="form-control" id="flowering_time" name="flowering_time" placeholder="Flowering Time" value="<?php echo htmlspecialchars($flowering_time); ?>">
            </div>
            <div class="form-group col-md-4">
                <label for="potency">Potency</label>
                <input type="text" class="form-control" id="potency" name="potency" placeholder="Potency" value="<?php echo htmlspecialchars($potency); ?>">
            </div>
            <div class="form-group col-md-4">
                <label for="aroma">Aroma</label>
                <input type="text" class="form-control" id="aroma" name="aroma" placeholder="Aroma" value="<?php echo htmlspecialchars($aroma); ?>">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <?php if (!empty($results)): ?>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Characteristics</th>
                <th>Values</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($results as $result): ?>
                <tr>
                    <td><?php echo htmlspecialchars($result['name']); ?></td>
                    <td><?php echo htmlspecialchars($result['description']); ?></td>
                    <td><?php echo htmlspecialchars($result['characteristics_list']); ?></td>
                    <td><?php echo htmlspecialchars($result['values_list']); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No results found.</p>
    <?php endif; ?>
</div>
</body>
</html>

<?php
$pdo = null;
?>
