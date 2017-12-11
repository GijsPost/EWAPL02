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

      $username = $password = "";
      $error = "";
      $succes = true;

      if ($_SERVER["REQUEST_METHOD"] == "POST") {
          
        if(!empty($_POST['inputUsername'])){
          $username = $_POST['inputUsername'];
        }else{
          $succes = false;
          $error = "Username can't be empty";
        }
        if(!empty($_POST['inputPassword'])){
          $password = $_POST['inputPassword'];
        }else{
          $succes = false;
          $error = "Password can't be empty";
        }
        if($succes == true){
          $stmt = $db->prepare("SELECT * FROM user WHERE UserName = ?");
          $stmt->bindValue(1, $username);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_NUM);
          if($result){
            $passwordDB = $result[2];
            if(password_verify($password, $passwordDB) == true){
              $_SESSION["UserID"] = $result[0];
              $_SESSION["UserName"] = $result[1];
              $_SESSION["UserPassword"] = $result[2];
              $_SESSION["UserEmail"] = $result[3];
              $_SESSION["UserProfilePicture"] = $result[4];
              $_SESSION["UserDateCreated"] = $result[5];
              $_SESSION["UserType"] = $result[6];
              $_SESSION["UserInstitution"] = $result[7];
              $_SESSION["UserBio"] = $result[8];
              header("Location: Index.php");
            }else{
              $error = "Username password combination doesn't exist";
            }
          }else{
            $error = "Username doesn't exist";
          }
        }
      }




    ?>
    
    <div class="row">
  
      <!-- This is the left column -->
      <div class="col-md"></div>
  
  
      <!-- This is the center column -->
      <div class="col-md-6" >

        <div style = "margin-top: 40px; margin-bottom: 40px;">
          <hr>
            <center><h1>Log in</h1></center>
          <hr>
        </div> 
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            
            <div class="form-group row">
                <label for="inputUsername" class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="inputUsername" placeholder="Username" value=<?php echo $username?>>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-5">
                    <input type="password" class="form-control" name="inputPassword" placeholder="Password" value=<?php echo $password?>>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-5">
                    <span style="color:red"><?php echo $error ?></span>
                    <button type="submit" class="btn btn-primary pull-right" style="float: right">log in </button>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-2"></div>
                <div class="col-sm-5">
                    <span>No account yet? <a href="Registration.php">Sign up</a></span>
                </div>
            </div>
             <div class="form-group row">
                <div class="col-sm-2"></div>
                <div class="col-sm-5">
                    <span style="font-size: 14px">Forgot your password? <a href="ForgotPassword.php">Click here</a></span>
                </div>
            </div>
        </form> 
      </div>
   

      <!-- This is the right column -->
      <div class="col-md"></div>
  
    </div>
    
  </body>
</html>