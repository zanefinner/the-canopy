<?php require 'partials/header.php';?></head><body>
<?php require 'partials/nav.php'?>

<div class="container">
  <div class="row">
    <div class="user-profile-col col-12 col-sm-12 col-md-12 col-lg-2">
        <div class='inner'>
            <h1>Profile</h1>
            <h3><?=$data['alias']?></h3>
            <p>id: <span><?=$data['id']?></span></p>
            <hr>
            <a href="/follow/<?=$data['id']?>">Follow</a>
        </div>
    </div>

    <div class="posts-col col-12 col-sm-12 col-md-12 col-lg-6">
    <h3>Posts by <?=$data['alias']?></h3>
      <?php
        foreach($data2 as $key){
          echo<<<ND
          <div class="post">
            <div class="origin">
              <a href="/">{$key['author']}</a> at {$key['posted_at']}
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
