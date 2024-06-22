<?php
$host = 'localhost';
$dbname = 'test';
$username = 'zane';
$password = '5245';
$pdo = null;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Pagination settings
    $results_per_page = 10;
    $stmt = $pdo->query("SELECT COUNT(*) FROM strains");
    $total_results = $stmt->fetchColumn();
    $total_pages = ceil($total_results / $results_per_page);

    // Get current page number from the URL, if not set default to page 1
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start_limit = ($page - 1) * $results_per_page;

    // Fetch the strains for the current page
    $stmt = $pdo->prepare("SELECT * FROM strains LIMIT :start_limit, :results_per_page");
    $stmt->bindParam(':start_limit', $start_limit, PDO::PARAM_INT);
    $stmt->bindParam(':results_per_page', $results_per_page, PDO::PARAM_INT);
    $stmt->execute();
    $strains = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php require_once "frontend/html/head.php"?>

    <meta charset="UTF-8">
    <title>Strain List</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?PHP require_once "frontend/html/nav.php" ?>

<div class="container">
    <h1 class="mt-5 mb-4">Cannabis Strains</h1>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($strains as $strain): ?>
            <tr>
                <td><?php echo htmlspecialchars($strain['strain_id']); ?></td>
                <td><?php echo htmlspecialchars($strain['name']); ?></td>
                <td><?php echo htmlspecialchars($strain['description']); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php if ($page == $i) echo 'active'; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
<?php require_once "frontend/html/footer.php"?>

</body>
</html>

<?php
$pdo = null;
?>
