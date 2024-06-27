<div class="user-profile-col col-12 col-sm-12 col-md-12 col-lg-2">
  <div class='inner'>
    <h1>Profile</h1>
    <h3><?=$_SESSION['alias']?></h3>
    <p>id: <span><?=$_SESSION['id']?></span></p>
    <hr>
    <a href="/user-posts/<?=$_SESSION['id']?>">User Posts</a><br>

    <a href="/">Home</a><br>


    <hr>
  </div>
</div>
