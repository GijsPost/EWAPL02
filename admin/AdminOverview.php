<!doctype html>
<html lang="en">
  <head>
    <title>Admin Overview</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    
  </head>
  <body>
    
  	<?php
      
      include "../files/DBConnection.php";
      include "../files/Css.php";

      session_start();
      if(strcmp($_SESSION['UserType'], "Admin") !== 0){
        header("Location: ../index.php");
        exit();
      }
      

    ?>

    <div class="col-md">
        <hr>
          <center><h3>Admin overview</h3></center>
        <hr>
    </div>

    <div class="row">
      <div class="col-md">
        <a href="AdminUser.php">Users</a>    
      </div>
    </div>
    <div class="row">
      <div class="col-md">  
        <a href="AdminArticle.php">Articles</a>
      </div>
    </div>    
    <div class="row">
      <div class="col-md">  
        <a href="../index.php">Go back to normal site</a>
      </div>
    </div>  
  

  
  </body>
</html>