<!doctype html>
<html lang="en">
  <head>
    <title>Sign up</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    
  </head>
  <body>
    
    <?php
    include "../files/DBConnection.php";
    include "../files/Css.php";

    session_start();
      if(strcmp($_SESSION['UserType'], "Admin" !== 0)){
        header("Location: ../index.php");
        exit();
      }
    

    if($_SERVER["REQUEST_METHOD"] == "POST") {
      $userID = $_POST['userID'];
      $userName = $_POST['inputUsername'];
      $userEmail = $_POST['inputEmail'];
      $userProfilePicture = $_POST['inputProfilePicture'];
      $userRole = $_POST['inputRole'];
      $userInstitution = $_POST['inputInstitution'];
      $userBio = $_POST['inputBio'];
      $stmt = $db->prepare("UPDATE user SET UserName = ?, UserEmail = ?, UserProfilePicture = ?, UserType = ?, UserInstitution = ?, UserBio = ? WHERE UserID = ?");
      $stmt->bindValue(1, $userName);
      $stmt->bindValue(2, $userEmail);
      $stmt->bindValue(3, $userProfilePicture);
      $stmt->bindValue(4, $userRole);
      $stmt->bindValue(5, $userInstitution);
      $stmt->bindValue(6, $userBio);
      $stmt->bindValue(7, $userID);
      $stmt->execute(); 
      
      header("Location: AdminUser.php");
      exit();

    }else{
    $link = $_GET['link'];
    $UserData = $db->query("SELECT * FROM user WHERE UserID = ".$link."")->fetch(PDO::FETCH_ASSOC);
    $userID = $UserData['UserID'];
    $userName = $UserData['UserName'];
    $userEmail = $UserData['UserEmail'];
    $userProfilePicture = $UserData['UserProfilePicture']; 
    $userRole = $UserData['UserType'];
    $userInstitution = $UserData['UserInstitution'];
    $userBio = $UserData['UserBio'];
  }
      
      


    ?>

    <div class="row">
  
      <!-- This is the left column -->
      <div class="col-md"></div>
  
  
      <!-- This is the center column -->
      <div class="col-md-6">
        <div style = "margin-top: 40px; margin-bottom: 40px;">
          <hr>
            <center><h1>Admin adjust user</h1></center>
          <hr>
        </div>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="username" class="col-sm-3 col-form-label">Username</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="inputUsername" placeholder="Username" value="<?php echo $userName;?>"> 
                </div>
            </div>
            <input type="hidden"  class="form-control"  name="userID" value="<?php echo $userID ?>">
            <div class="form-group row">
                <label for="username" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                    <input type="email" class="form-control" name="inputEmail" placeholder="Email" value="<?php echo $userEmail;?>"> 
                </div>
            </div>
             <div class="form-group row">
                <label for="username" class="col-sm-3 col-form-label">Profile picture path</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="inputProfilePicture" placeholder="Path" value="<?php echo $userProfilePicture;?>"> 
                </div>
            </div>

            <div class="form-group row">
              <label for="sel1" class="col-sm-3 col-form-label">Role</label>
              <div class="col-sm-9  ">
                <select class="form-control" name="inputRole">
                  <option value="Admin" <?php if($userRole=="Admin") echo 'selected="selected"'; ?> >Admin </option>
                  <option value="Publisher" <?php if($userRole=="Publisher") echo 'selected="selected"'; ?> >Publisher </option>
                  <option value="User" <?php if($userRole=="User") echo 'selected="selected"'; ?> >User </option>
              </select>
              </div>
            </div>
            
            
            <div class="form-group row">
              <label for="sel1" class="col-sm-3 col-form-label">Institution</label>
              <div class="col-sm-9  ">
                <select class="form-control" name="inputInstitution">
                  <option value="Amsterdam University of the Arts" <?php if($userInstitution=="Amsterdam University of the Arts") echo 'selected="selected"'; ?> >Amsterdam University of the Arts</option>
                  <option value="Amsterdam University of Applied Sciences" <?php if($userInstitution=="Amsterdam University of Applied Sciences") echo 'selected="selected"'; ?> >Amsterdam University of Applied Sciences</option>
                  <option value="Gerrit Rietveld Academy" <?php if($userInstitution=="Gerrit Rietveld Academy") echo 'selected="selected"'; ?> >Gerrit Rietveld Academy</option>
                  <option value="University of Amsterdam" <?php if($userInstitution=="University of Amsterdam") echo 'selected="selected"'; ?> >University of Amsterdam</option>
                  <option value="Vrije Universiteit Amsterdam" <?php if($userInstitution=="Vrije Universiteit Amsterdam") echo 'selected="selected"'; ?> >Vrije Universiteit Amsterdam</option>
              </select>
              </div>
            </div>
            
            <div class="coll-sm-9">
              <label class="col-form-label">Bio</label>
              <textarea class="form-control" rows="5" name="inputBio" placeholder="Biography"><?php echo $userBio?></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="float: right; margin-top: 5px;">Update</button>

        </form> 
    </div>


  
    
  
      <!-- This is the right column -->
      <div class="col-md"></div>
  
    </div>
  
  </body>
</html>