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
      include "files/DBConnection.php";
      include "files/Navbar.php";
      include "files/Css.php";
      include 'ImageResize.php';



      $bio = $_SESSION['UserBio'];  
      $username = $_SESSION['UserName'];  
      $institution = $_SESSION['UserInstitution'];
      $email = $_SESSION['UserEmail'];
      $usernameErr = $emailErr = $error = "";
      $password = $passwordErr = "";
      $confirmPassword = $confirmPasswordErr = "";
      $bioErr = $imgError = "";
      $UserPrefix = "U";
      $update = 1;

      if($_SERVER["REQUEST_METHOD"] == "POST") {
        $update = 1;
        if(strlen($_POST['inputPassword']) > 0){
          if(strlen($_POST['inputPassword']) < 7 ){
            $error = "Password must be at least 7 characters long";
            $update = 0;
          }
          if(strcmp($_POST['inputPassword'], $_POST['inputConfirmPassword']) !== 0){
            $error = "Passwords don't match";
            $update = 0;
          }
          if($update == 1){
            $hashedww = password_hash($_POST['inputPassword'], PASSWORD_DEFAULT); 
            $stmt1 = $db->prepare("UPDATE user SET UserPassword = ? WHERE UserID = ?");
            $stmt1->bindValue(1, $hashedww);
            $stmt1->bindValue(2, $_SESSION['UserID']);
            $stmt1->execute(); 
            $update = 1;
            $_SESSION['UserPassword'] = $hashedww;
          }
        }
      if(empty($_POST["inputEmail"])){
        $error = "Email can't be empty";
        $update = 0;
      }else{
        $email = strip_tags($_POST["inputEmail"]);
        $update = 1;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email"; 
            $update = 0;
        }
      }
      $bio = strip_tags($_POST['inputBio']);
      
      if($update == 1){
        $institution = $_POST["institutionInput"];
        $stmt1 = $db->prepare("UPDATE user SET UserEmail = ?, UserBio = ?, UserInstitution = ? WHERE UserID = ?");
        $stmt1->bindValue(1, $email);
        $stmt1->bindValue(2, $bio);
        $stmt1->bindValue(3, $institution);
        $stmt1->bindValue(4, $_SESSION['UserID']);
        $stmt1->execute(); 
        $update = 1;
        $_SESSION['UserEmail'] = $email;
        $_SESSION['UserBio'] = $bio;
        $_SESSION['UserInstitution'] = $institution;
      }

      
      if(!empty($_FILES["fileToUpload"]["name"]) && $update == 1){
        $target_dir = "images/userProfilePicture/";
        $target_file = $UserPrefix.$target_dir.basename($_FILES["fileToUpload"]["name"]);
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
       
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $imgError = "Sorry, only JPG, JPEG & PNG files are allowed.";
            $update = 0;
        }

        

        // Check if $uploadOk is set to 0 by an error
        if ($update == 1) { 
            $target_file = $UserPrefix.$_SESSION['UserID'].".".$imageFileType;
            $stmt1 = $db->prepare("UPDATE user SET UserProfilePicture = ? WHERE UserID = ?");
            $stmt1->bindValue(1, $UserPrefix.$_SESSION['UserID'].".".$imageFileType);
            $stmt1->bindValue(2, $_SESSION['UserID']);
            $stmt1->execute();
            $target_dir = "images/userProfilePicture/";
            $image = new SimpleImage();
            $image->load($_FILES["fileToUpload"]['tmp_name']);
            $image->resize(500,500);
            $image->save($target_dir.$target_file);
            
        }
      }
      if($update == 1){
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");
        header("Location: OwnProfilePage.php");
      }
      
      }
    
      


    ?>

    <div class="row">
  
      <!-- This is the left column -->
      <div class="col-md"></div>
  
  
      <!-- This is the center column -->
      <div class="col-md-6">
        <div style = "margin-top: 40px; margin-bottom: 40px;">
          <hr>
            <center><h1>Edit your profile</h1></center>
          <hr>
        </div>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-3 col-form-label">New password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" name="inputPassword" placeholder="Password" value=<?php echo $password?>>
                    <span style="color:red"><?php echo $passwordErr ?></span>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputConfirmPassword" class="col-sm-3 col-form-label">Confirm new password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" name="inputConfirmPassword" placeholder="Confirm password" value=<?php echo $confirmPassword?>>
                    <span style="color:red"><?php echo $confirmPasswordErr ?></span>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9  ">
                    <input type="text" class="form-control" name="inputEmail" placeholder="Email" value=<?php echo $email?>>
                    <span style="color:red"><?php echo $emailErr ?></span>
                </div>
            </div>

            
            <div class="form-group row">
              <label for="sel1" class="col-sm-3 col-form-label">Institution</label>
              <div class="col-sm-9  ">
                <select class="form-control" name="institutionInput">
                  <option value="Amsterdam University of the Arts" <?php if($institution=="Amsterdam University of the Arts") echo 'selected="selected"'; ?> >Amsterdam University of the Arts</option>
                  <option value="Amsterdam University of Applied Sciences" <?php if($institution=="Amsterdam University of Applied Sciences") echo 'selected="selected"'; ?> >Amsterdam University of Applied Sciences</option>
                  <option value="Gerrit Rietveld Academy" <?php if($institution=="Gerrit Rietveld Academy") echo 'selected="selected"'; ?> >Gerrit Rietveld Academy</option>
                  <option value="University of Amsterdam" <?php if($institution=="University of Amsterdam") echo 'selected="selected"'; ?> >University of Amsterdam</option>
                  <option value="Vrije Universiteit Amsterdam" <?php if($institution=="Vrije Universiteit Amsterdam") echo 'selected="selected"'; ?> >Vrije Universiteit Amsterdam</option>
              </select>
              </div>
            </div>
            <div class="coll-sm-9">
                      <label class="col-form-label">Write something about you (max 500 characters)</label>
                      <textarea class="form-control" rows="5" name="inputBio" placeholder="Biography"><?php echo $bio?></textarea>
                      <span style="color:red"><?php echo $bioErr ?></span>
            </div>
            <div class="coll-sm-9">
                <label class="col-form-label">Upload a new profile picture</label>
                </div>
                <div class="coll-sm-9">        
                        <label class="custom-file">
                            <input type="file" name="fileToUpload" id="fileToUpload">
                        </label>
                        <span style="color:red"><?php echo $imgError ?></span>
                </div>
            <button type="submit" class="btn btn-primary" style="float: right; margin-top: 5px;">Update profile</button>
            <span style="color:red"><?php echo $error ?></span>
        </form> 
    </div>


  
    
  
      <!-- This is the right column -->
      <div class="col-md"></div>
  
    </div>
  
  </body>
</html>