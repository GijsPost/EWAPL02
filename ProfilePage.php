<!doctype html>
<html lang="en">
  <head>
    <title>Profile Page</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    
  </head>
  <body>
    
  	<?php
      include "files/DBConnection.php";
      include "files/Navbar.php";
      include "files/Css.php";

      $link = $_GET['link'];
      $UserData = $db->query("SELECT * FROM user WHERE UserID = ".$link."")->fetch(PDO::FETCH_ASSOC);
      $UserArticles = $db->query("SELECT * from article a left join user_article u on a.ArticleID = u.Articles_ArticleID where u.Users_UserID = ".$link);
      $UserArticlesCount = $db->query("SELECT count(*) from article a left join user_article u on a.ArticleID = u.Articles_ArticleID where u.Users_UserID = ".$link);
      $amoutOfArticles = $UserArticlesCount->fetchColumn();
      $date = strtotime($UserData['UserDateCreated']);
      $dat = date('d/m/y', $date);
    ?>

    <div class="row"> 
  
      <!-- This is the left column -->
      <div class="col-md"></div>
  
  
      <!-- This is the center column -->
      <div class="col-md-6">
        <div style = "margin-top: 40px; margin-bottom: 40px;">
          <hr>
            <center>
              <h1>
                <?php 
                  echo $UserData['UserName']; 
                  if($UserData['UserType'] == "Publisher"){
                    echo '<span class="badge badge-success" style="margin-left:2px">Publisher</span>';
                  }
                
                  if($UserData['UserType'] == "Admin"){
                    echo '<span class="badge badge-danger" style="margin-left:2px">Admin</span>';
                  }
                ?>    
              </h1>
            </center>
          <hr>
        </div>    
        <div class="row">

          
          <div class="col-md">
          
          <h3 >Institution</h3>
            
            <p><?php echo $UserData['UserInstitution'] ?>
            </p>

            <h3>Bio</h3>
            
            <p><?php 
            if(is_null($UserData['UserBio'])){
                echo 'This person has no personal information';
              }else{
                echo $UserData['UserBio']; 
              }
            ?>
            </p>
          </div>
          <div class="col-md">
            <?php 
              if(is_null($UserData['UserProfilePicture'])){
                $UserProfilePicture = "PROFILE_PICTURE_TEMPLATE.jpg";
              }else{
                $UserProfilePicture = $UserData['UserProfilePicture'];
              }
            ?>
            <center><img src="images/UserProfilePicture/<?php echo $UserProfilePicture;?>" style="width: 70%; height: 100%;"></center>
            <p style="padding-left: 15%">Member since: <?php echo $dat?> </p>
          </div>
        </div>
            
        <?php
          if($amoutOfArticles > 0){
            echo '
              <div class="row">
                <div class="col-md">
                  <h3> Articles </h3>
                </div>
              </div>
            ';

            while ($row = $UserArticles->fetch(PDO::FETCH_ASSOC)) {
              echo '<div class="row">
                      <div class="col-md">
                        <a href="ArticlePage.php?link='.$row['ArticleID'].'" style="color: inherit; text-decoration:none;">
                          '.$row['ArticleTitle'].'
                          </a>
                      </div>
                    </div> 
              ';
            }
          }
        ?>  
          
      </div>
    
  
      <!-- This is the right column -->
      <div class="col-md"></div>
  
    </div>
  
  </body>
</html>