<?php
session_start();
include "files/Search.php";
?>

<script>

function showResult(str) {
  if (str.length==0) { 
    document.getElementById("result").innerHTML=""; 
    return;
  }
  xmlhttp=new XMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("result").innerHTML=this.responseText;
    }
  }
  xmlhttp.open("GET","files/Search.php?key="+str);
  xmlhttp.send();
}
</script>

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
              <a class="dropdown-item" href="OwnProfilePage.php">Your profile</a>
			  <?php if($_SESSION['UserType'] == "Publisher" || $_SESSION['UserType'] == "Admin"){ ?> 
        <a class="dropdown-item" href="YourArticles.php">Your Articles</a>
        <a class="dropdown-item" href="PostNewArticle.php">Post a new article</a> <?php }?>
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
      <?php if(isset($_SESSION['UserType']) && $_SESSION['UserType'] === "Admin"){
        ?>
      <li class="nav-item active">
        <a class="nav-link" href="Admin/AdminOverview.php">Admin</a>
      </li> <?php ; } ?>

    </ul>
    <form>
      <input type="text" size="30" onkeyup="showResult(this.value)" placeholder="Search" > 
    </form>
    </div>
</nav>




<div class="row">
  
  <!-- This is the left column -->
    <div class="col-md"></div>

  <!-- This is the center column -->
    <div class="col-lg-6 col-md-8">
      <div id="result"></div>
    </div>

  <!-- This is the right column -->
    <div class="col-md"></div>  
</div>
