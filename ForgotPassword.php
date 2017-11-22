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

      $username = $email = $message = "";
      $succes = true;
      if ($_SERVER["REQUEST_METHOD"] == "POST") {

        header("Location: SendMailTest.php");
        // if(!empty($_POST['inputUsername'])){
        //   $username = $_POST['inputUsername'];
        // }else{
        //   $succes = false;
        //   $message = "Username can't be empty";
        // }
        // if(!empty($_POST['inputEmail'])){
        //   $email = $_POST['inputEmail'];
        // }else{
        //   $succes = false;
        //   $message = "Email can't be empty";
        // }
        // if($succes == true){
        //   $stmt = $db->prepare("SELECT * FROM user WHERE UserName = ? AND UserEmail = ?");
        //   $stmt->bindValue(1, $username);
        //   $stmt->bindValue(2, $email);
        //   $stmt->execute();
        //   $result = $stmt->fetch(PDO::FETCH_NUM);
        //   if($result){
        //     $passwordDB = $result[2];
        //     $hashedww = password_hash($password, PASSWORD_DEFAULT);
        //     }else{
        //       $error = "If the username and email are correct an email has been sent";
        //     }
        //   }else{
        //     $error = "If the username and email are correct an email has been sent";
        //   }
        //}
      }



    ?>

    <div class="row">
  
      <!-- This is the left column -->
      <div class="col-md"></div>
  
  
      <!-- This is the center column -->
      <div class="col-md-6">
        <div style = "margin-top: 40px; margin-bottom: 40px;">
          <hr>
            <center><h1>Reset your password</h1></center>
          <hr>
        </div>
        <p>Enter your username and email and an email will be sent with a new password.</p>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            
            <div class="form-group row">
                <label for="inputUsername" class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="inputUsername" placeholder="Username" value=<?php echo $username?>>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-5">
                    <input type="password" class="form-control" name="inputPassword" placeholder="Password" value=<?php echo $email?>>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-5">
                    <span><?php echo $message ?></span>
                    <button type="submit" class="btn btn-primary pull-right" style="float: right">Sent password </button>
                </div>
            </div>
            
        </form> 
      </div>

      <!-- This is the right column -->
      <div class="col-md"></div>
  
    </div>
  
  </body>
</html>