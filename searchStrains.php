<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Strains</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Search Cannabis Strains</h1>
    <form method="GET" action="search_strain.php" class="mt-4">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Strain Title">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" class="form-control" id="description" name="description" placeholder="Strain Description">
        </div>
        <div class="mb-3">
            <label for="flowering_time" class="form-label">Flowering Time</label>
            <input type="text" class="form-control" id="flowering_time" name="flowering_time" placeholder="e.g., 8 weeks">
        </div>
        <div class="mb-3">
            <label for="potency" class="form-label">Potency</label>
            <input type="text" class="form-control" id="potency" name="potency" placeholder="e.g., 20%">
        </div>
        <div class="mb-3">
            <label for="aroma" class="form-label">Aroma</label>
            <input type="text" class="form-control" id="aroma" name="aroma" placeholder="e.g., Citrus">
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Database connection
        $host = 'localhost';
        $dbname = 'test';
        $username = 'zane';
        $password = '5245';

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Construct the query
            $query = "SELECT s.name, s.description, sc1.value AS flowering_time, sc2.value AS potency, sc3.value AS aroma
                      FROM strains s
                      LEFT JOIN strain_characteristics sc1 ON s.strain_id = sc1.strain_id AND sc1.characteristic_id = 3
                      LEFT JOIN strain_characteristics sc2 ON s.strain_id = sc2.strain_id AND sc2.characteristic_id = 1
                      LEFT JOIN strain_characteristics sc3 ON s.strain_id = sc3.strain_id AND sc3.characteristic_id = 4
                      WHERE 1=1";

            $params = [];

            // Add filters
            if (!empty($_GET['title'])) {
                $query .= " AND s.name LIKE :title";
                $params[':title'] = '%' . $_GET['title'] . '%';
            }
            if (!empty($_GET['description'])) {
                $query .= " AND s.description LIKE :description";
                $params[':description'] = '%' . $_GET['description'] . '%';
            }
            if (!empty($_GET['flowering_time'])) {
                $query .= " AND sc1.value LIKE :flowering_time";
                $params[':flowering_time'] = '%' . $_GET['flowering_time'] . '%';
            }
            if (!empty($_GET['potency'])) {
                $query .= " AND sc2.value LIKE :potency";
                $params[':potency'] = '%' . $_GET['potency'] . '%';
            }
            if (!empty($_GET['aroma'])) {
                $query .= " AND sc3.value LIKE :aroma";
                $params[':aroma'] = '%' . $_GET['aroma'] . '%';
            }

            $stmt = $pdo->prepare($query);
            $stmt->execute($params);

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($results) {
                echo "<h2 class='mt-5'>Search Results</h2>";
                echo "<div class='table-responsive'><table class='table table-bordered mt-3'>";
                echo "<thead><tr><th>Name</th><th>Description</th><th>Flowering Time</th><th>Potency</th><th>Aroma</th></tr></thead>";
                echo "<tbody>";
                foreach ($results as $row) {
                    echo "<tr><td>{$row['name']}</td><td>{$row['description']}</td><td>{$row['flowering_time']}</td><td>{$row['potency']}</td><td>{$row['aroma']}</td></tr>";
                }
                echo "</tbody></table></div>";
            } else {
                echo "<p class='mt-5'>No results found.</p>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
