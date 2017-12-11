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
    
    $stmt = $db->query("SELECT * FROM user");
    echo '<table class="table-striped table-condensed"> 
            <thead>
              <tr>
                <th>UserID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Profilepicture</th>
                <th>Member since</th>
                <th>Type</th>
                <th>Institution</th>
                <th>Bio</th>
                <th>Delete</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
          ';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {   
      echo'    
          <tr>
          <td>'.$row['UserID'].'</td>
          <td>'.$row['UserName'].'</td>
          <td>'.$row['UserEmail'].'</td>
          <td>'.$row['UserProfilePicture'].'</td>
          <td>'.$row['UserDateCreated'].'</td>
          <td>'.$row['UserType'].'</td>
          <td>'.$row['UserInstitution'].'</td>
          <td>'.$row['UserBio'].'</td>
          <td><a href="AdminDeleteUser.php?link='.$row['UserID'].'">Delete</a></td> 
          <td><a href="AdminAdjustUser.php?link='.$row['UserID'].'">Edit</a></td>   
          </tr>
      ';    
       


      
    }

    echo ' </tbody>
      </table>';
    ?>
  

  
  </body>
</html>