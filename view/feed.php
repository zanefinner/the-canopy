<?php require 'partials/header.php';?></head><body>
<?php require 'partials/nav.php'?>

<div class="container">
  <div class="row">
    <?php require 'partials/user-profile-col.php'?>
    <div class="posts-col col-12 col-sm-12 col-md-12 col-lg-6">
      <form class="new-post" method="post" action='/post-something'>
        Post Something<input type="text" name="content">
      </form>
      <?php
        $data=[
          [
            'author'=>'Zane',
            'content'=>'Welcome to my dummy text',
            'posted_at'=>'24:01 Pacific Time',
            'comments'=>[
              'author'=>'John',
              'content'=>'lol so dummb'
            ]
          ],
        ];
        foreach($data as $key){
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
