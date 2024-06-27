<?php require 'partials/header.php';?></head><body>
<?php require 'partials/nav.php'?>

<div class="container">
  <div class="row">
    <?php require 'partials/user-profile-col.php'?>
    <div class="posts-col col-12 col-sm-12 col-md-12 col-lg-6">

      <h1>Posts By <?=$_SESSION['alias']?></h1>
      <?php
        foreach ($data as $key){
          echo<<<ND
          <div class="post">
            <div class="origin">
              <a href="/">{$_SESSION['alias']}</a> at {$key['posted_at']}
            </div>
            <p>{$key['content']}</p>
          </div>
ND;
        }
      ?>

    </div>
    <?php require 'partials/discover-col.php'?>
  </div>
</div>
<?php require 'partials/footer.php';?>
