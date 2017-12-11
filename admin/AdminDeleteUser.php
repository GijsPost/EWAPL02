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
      session_start();
      if(strcmp($_SESSION['UserType'], "Admin") !== 0){
        header("Location: ../index.php");
        exit();
      }
      $deleteID = $_GET['link'];
      $db->query("DELETE FROM user WHERE UserID = ".$deleteID);
      header("Location: AdminUser.php");
    ?>

    
  

  
  </body>
</html>