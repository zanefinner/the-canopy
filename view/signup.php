<?php require 'partials/header.php';?></head><body>
<?php require 'partials/nav.php';?>
<div class="container">
  <form method="post">
    <h2 class="text-center">Create an Account</h2>
    <hr>
    <div class="form-group">
      <input placeholder="email" name='email'><br>
    </div>
    <div class="form-group">
      <input placeholder="full name"  name='name'><br>
    </div>
    <div class="form-group">

      <input  placeholder="alias" name='alias'><br>
    </div>
    <div class="form-group">

      <input  placeholder="password" name='password' type='password'>
      <?php echo $errors;?>
<br>
    </div>
    <button type='submit' class="btn btn-link btn-block">Register</button>
  </form>
</div>
