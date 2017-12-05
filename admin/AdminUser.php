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
    ?>

    <div class="col-md">
        <hr>
          <center><h3>Admin overview - Users</h3></center>
        <hr>
    </div>

    <?php 
    
    $stmt = $db->query("SELECT * FROM user");
    echo '<table class="table table-striped" style="width: 100%;"> 
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

          </tr>
      ';    
       


      
    }

    echo ' </tbody>
      </table>';
    ?>
  

  
  </body>
</html>