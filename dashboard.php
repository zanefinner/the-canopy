<?php session_start()?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Canopy - Dashboard</title>
    <?php require_once "frontend/html/head.php"?>

</head>
<body>
<?PHP require_once "frontend/html/nav.php" ?>
<div class="container">
    <div class="spacer-top"></div>
        <h1>Welcome back, <?php echo $_SESSION['username']?></h1>
    <div class="spacer-top"></div>

        <div class="row">
            <div class="col-md-4">
                <h2>Feed</h2>
                some feed stuff here
            </div>
            <div class="col-md-4">
                <h2>Your Current Grows</h2>
            </div>
            <div class="col-md-4">
                <h2>Friends</h2>
            </div>
        </div>
    </div>
</div>
<?php require_once "frontend/html/footer.php"?>
    
</body>
</html>