<?php
session_start();
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="index.php">A.R.I.A.S. Publishing Lab</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="Categories.php">Categories</a>
      </li>
	  <li class="nav-item active">
        <a class="nav-link" href="index.php">Latest Articles</a>
      </li>
      <li class="nav-item dropdown active">
        <?php  
          if(isset($_SESSION['UserID'])){
            ?>
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo $_SESSION['UserName']?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="ProfilePage.php">Your profile</a>
              <a class="dropdown-item" href="ProfilePage.php">Your Articles</a>
              <a class="dropdown-item" href="LogOut.php">Log out</a>
            </div>
            <?php
          }else{
            ?><li class="nav-item active">
                <a class="nav-link" href="LogIn.php">Log in</a>
              </li>
          <?php
          }
          ?>
       
        
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button type="submit" class="btn btn-light my-2 my-sm-0">Search</button>
    </form>
  </div>
</nav>
