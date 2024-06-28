<?php require 'partials/header.php';?></head><body>
<?php require 'partials/nav.php'?>

<div class="container">
  <div class="row">
    <?php require 'partials/user-profile-col.php'?>
    <div class="posts-col col-12 col-sm-12 col-md-12 col-lg-6">
      <form class="new-post" method="post" action='/post-something'>
        Post Something<input type="text" name="content">
      </form>

    <div class="posts-col col-12 col-sm-12 col-md-12 col-lg-6">

      <h1>For You</h1>
      <?php
// Assuming $data holds your array of posts

foreach ($data as $post) {
    echo '<div class="post">';
    echo '<p><strong>' . htmlspecialchars($post['author_alias']) . '</strong></p>';
    echo '<p>' . htmlspecialchars($post['content']) . '</p>';
    echo '<p><small>Posted on ' . htmlspecialchars($post['created_at']) . '</small></p>';
    echo '</div>';
}
?>


    </div>
    <?php require 'partials/discover-col.php'?>
  </div>
</div>
<?php require 'partials/footer.php';?>

