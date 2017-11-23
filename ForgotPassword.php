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

      //all needed for sending email
      use PHPMailer\PHPMailer\PHPMailer;
      use PHPMailer\PHPMailer\Exception;
      require 'Mail/Exception.php';
      require 'Mail/PHPMailer.php';
      require 'Mail/SMTP.php';

      $done = false;
      $username = $email = $message = "";
      $succes = true;
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $loading = true;
        if(!empty($_POST['inputUsername'])){
          $username = $_POST['inputUsername'];
        }else{
          $succes = false;
          $loading = false;
          $message = "Username can't be empty";
        }
        if(!empty($_POST['inputEmail'])){
          $email = $_POST['inputEmail'];
        }else{
          $succes = false;
          $loading = false;
          $message = "Email can't be empty";
        }
        if($succes == true){
          $stmt = $db->prepare("SELECT * FROM user WHERE UserName = ? AND UserEmail = ?");
          $stmt->bindValue(1, $username);
          $stmt->bindValue(2, $email);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_NUM);
          if($result){
            //create random password
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $newPass = array();
            $alphaLength = strlen($alphabet) - 1; 
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $newPass[] = $alphabet[$n];
            }
            $newPassFull = implode("", $newPass);
            $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
            try {
                //Server settings
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'smtp.live.com';                        // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = 'ariaspassreset@outlook.com';          // SMTP username
                $mail->Password = 'GijsenTim02';                      // SMTP password
                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;                                    // TCP port to connect to

                //Recipients
                $mail->setFrom('ariaspassreset@outlook.com', 'Arias');
                $mail->addAddress(''.$email.'');                      // Add a recipient

                //Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Password reset';
                $mail->Body    = 'Hello '.$username.',<br><br>This is your new password <b>'.$newPassFull.'</b><br><br> Yours sincerely, ARIAS';
                $mail->send();
                $message = "If the username and email are correct an email has been sent";
                $done = true;
                $stmt = $db->prepare("UPDATE user SET UserPassword = ? WHERE UserName = ?");
                
                
                $hashedpass = password_hash($newPassFull, PASSWORD_DEFAULT);
                $stmt->bindValue(1, $hashedpass);
                $stmt->bindValue(2, $username);
                $stmt->execute();

            } catch (Exception $e) {
              $message = "If the username and email are correct an email has been sent";
              $done = true;
            }
            }else{
              $message = "If the username and email are correct an email has been sent";
              $done = true;
            }
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
                    <input type="email" class="form-control" name="inputEmail" placeholder="Email" value=<?php echo $email?>>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">
                </div>
                <div class="col-sm-5">
                    <button type="submit" class="btn btn-primary" style="margin-left: 10px; float: right">Sent password </button>
                    <?php if($done == true){
                      ?>
                        <button type="reset" class="btn btn-primary" style="float: right;" onclick="location.href='LogIn.php'">Go back</button>
                    <?php } ?>
                </div>
                   
                    
            </div>
            <div class="row">
              <div class="col-sm-8">
                <span><?php echo $message ?></span>
              </div>
            </div>
            


        </form> 
        </div>
     
      <!-- This is the right column -->
      <div class="col-md"></div>
      </div>
    
  
  </body>
</html>