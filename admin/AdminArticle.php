<!doctype html>
<html lang="en">
  <head>
    <title>Admin Overview</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>

    table{
      width: 100%;
      text-align: left;
    }

    td {
    max-width: 100px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    }
    </style>
    
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
          <center><h3>Admin overview - Users</h3></center>
        <hr>
    </div>

    <?php 
    
    $stmt = $db->query("SELECT * FROM article");
    echo '<table class="table-striped table-condensed"> 
            <thead>
              <tr>
                <th>ArticleID</th>
                <th>Title</th>
                <th>Text</th>
                <th>Date Posted</th>
                <th>Publisher</th>
                <th>Delete</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
          ';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $articleID = $row['ArticleID'];
      $row2 = $db->query("SELECT UserName FROM user INNER JOIN user_article ON user.UserID = user_article.Users_UserID WHERE Articles_ArticleID = $articleID LIMIT 1")->fetch();   
      echo'    
          <tr>
          <td>'.$row['ArticleID'].'</td>
          <td>'.$row['ArticleTitle'].'</td>
          <td>'.$row['ArticleText'].'</td>
          <td>'.$row['ArticleDate'].'</td>
          <td>'.$row2['UserName'].'</td>
          <td><a href="../DeleteArticle.php?articleToDelete='.$row['ArticleID'].'">Delete</a></td> 
          <td><a href="../EditArticle.php?articleToEdit='.$row['ArticleID'].'">Edit</a></td>   
          </tr>
      ';    
       


      
    }

    echo ' </tbody>
      </table>';
    ?>
  

  
  </body>
</html>