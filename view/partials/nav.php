
<nav class="navbar fixed-top navbar-expand-lg navbar-dark">
  <a style="text-shadow: 0 0 8px pink;"class="navbar-brand" href="/feed">Social Media</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <?php
        if(isset ($_SESSION['id']) ){
          echo<<<ENDD
          <li class="nav-item">
          <a class="nav-link" href="/account-settings">Account Settings</a>
          </li>
          <li class="nav-item">
          <a class="nav-link" href="/add">Add Friends</a>
          </li>
          <li class="nav-item">
          <a class="nav-link" href="/discover">Discover</a>
          </li>
          <li class="nav-item">
          <a class="nav-link" href="/logout">Logout</a>
          </li>

ENDD;
        }else{
          echo<<<ENDD
          <li class="nav-item">
          <a class="nav-link" href="/login">Log In</a>
          </li>
          <li class="nav-item">
          <a class="nav-link" href="/signup">Sign Up</a>
          </li>
ENDD;
        }
      ?>
    </ul>
    <form action="/search" class="search form-inline my-2 my-lg-0">
      <input name ="search_term" style="color:white;outline: 0; box-shadow: none; highlight: 0;" class="form-control mr-sm-2" type="search" placeholder="Search a User's ID" aria-label="Search">
      <button class="btn btn-secondary my-2 my-sm-0" type="submit">Go</button>
    </form>
  </div>
</nav>

<div class="nav-placeholder"></div>
