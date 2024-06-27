<?php require 'partials/header.php';?></head><body>
<?php require 'partials/nav.php';?>
<div class="container">
  <form method="post">
    <h2 class="text-center"> Log In </h2>
    <hr>
    <div class="form-group">

      <input name='email' placeholder="email"><br>
    </div>
    <div class="form-group">

      <input name='password' type='password' placeholder="password"><br>
    </div>
    <button type='submit' class="btn btn-link btn-block">Log In</button>
  </form>
</div>
