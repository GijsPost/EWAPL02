<!doctype html>
<html lang="en">
  <head>
    <title>Sign up</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<link rel="stylesheet" href="css/testing.css">
  </head>
  <body>
    
  		<?php
  			include "DBConnection.php";
			include "Navbar.php";
  			$username = $usernameErr = "";
  			$password = $passwordErr = "";
  			$confirmPassword = $confirmPasswordErr = "";
  			$email = $emailErr = ""; 
  			$termsErr = "";
  			$error = "";



  			if ($_SERVER["REQUEST_METHOD"] == "POST") {
  				$error = "";
  				$username = strip_tags($_POST["inputUsername"]);
	  			if (empty($_POST["inputUsername"])) {
	                $usernameErr = "Username can not be empty";
	            } else {
	                $username = strip_tags($_POST["inputUsername"]);
	                if (strlen($username) < 6) {
	                    $usernameErr = "Username must be at least 6 characters long"; 
	                }
	            }
	            $password = strip_tags($_POST["inputPassword"]);
	            if(empty($_POST["inputUsername"])){
	            	$passwordErr = "Password can not be empty";
	            } else{
	            	$password =  strip_tags($_POST["inputPassword"]);
	            	if(strlen($password) < 7){
	            		$passwordErr = "Password must be at least 7 characters long";
	            	}
	            }
	            $confirmPassword = strip_tags($_POST["inputConfirmPassword"]);
	            if(empty($_POST["inputConfirmPassword"])){
	            	$confirmPasswordErr = "Confirm password can not be empty";
	            }else{
	            	$confirmPassword = strip_tags($_POST["inputConfirmPassword"]);
	            	if(strlen($confirmPassword) < 7){
	            		$confirmPasswordErr = "Confirm password must be at least 7 characters long";
	            	}
	            	if(strcmp($password, $confirmPassword) !== 0){
	            		$confirmPasswordErr = "Passwords do not match";
	            	}
	            }
	            $email = strip_tags($_POST["inputEmail"]);
	            if(empty($_POST["inputEmail"])){
	            	$emailErr = "Email can not be empty";
	            }else{
	            	$email = strip_tags($_POST["inputEmail"]);
	                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	                    $emailErr = "Invalid email"; 
	                }
	            }
	            if(!isset($_POST['terms'])){
	            	$termsErr = "You need to accept the terms of service.";
	            }

	            $stmt1 = $db->query("select count(*) from user where UserName = '$username'");
	            $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
	            if($row1['count(*)'] > 0){
	            	$usernameErr = "Username already exists";
	            }
	            $stmt1 = $db->query("select count(*) from user where UserEmail = '$email'");
	            $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
	            if($row1['count(*)'] > 0){
	            	$emailErr = "Email already exists";
	            }

	            if(empty($usernameErr) && empty($passwordErr) && empty($confirmPasswordErr) && empty($emailErr) && isset($_POST['terms'])){
	            
	            	$stmt = $db->prepare('INSERT INTO user (UserName, UserPassword, UserEmail, UserType) 
	                VALUES (?,?,?,?)');
	                $stmt->bindValue(1, $username, PDO::PARAM_STR);
	                $stmt->bindValue(2, $password, PDO::PARAM_STR);
	                $stmt->bindValue(3, $email, PDO::PARAM_STR);
	                $stmt->bindValue(4, 'user', PDO::PARAM_STR);
	                $stmt->execute();
	                $stmt1 = $db->query("select UserID from user where UserEmail = '$email' ");
	            	$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
	            	echo $row1['UserID'];

	            	header("Location: additionalInfo.php?link=".$row1['UserID']."");
               	 	exit();
	            }else{
	            	$error = "Something went wrong try again";
	            }

			}
  		?>	

	<div class="row">
	
	<!-- This is the left column -->
    <div class="col-md">
      
    </div>
	
	
	<!-- This is the center column -->
    <div class="col-md-6">
		<div style = "margin-top: 40px; margin-bottom: 40px;">
			<hr>
				<center><h1>Sign up</h1></center>
			<hr>
		</div>		

		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="form-group row">
                <label for="inputUsername" class="col-sm-3 col-form-label">Username</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="inputUsername" placeholder="Username" value=<?php echo $username?>>
                   <span style="color:red"><?php echo $usernameErr ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" name="inputPassword" placeholder="Password" value=<?php echo $password?>>
                    <span style="color:red"><?php echo $passwordErr ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputConfirmPassword" class="col-sm-3 col-form-label">Confirm password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" name="inputConfirmPassword" placeholder="Confirm password" value=<?php echo $confirmPassword?>>
                    <span style="color:red"><?php echo $confirmPasswordErr ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9	">
                    <input type="text" class="form-control" name="inputEmail" placeholder="Email" value=<?php echo $email?>>
                    <span style="color:red"><?php echo $emailErr ?>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-9	">
                    <input type="checkbox" name="terms"> 
                    <span>
                        I accept the Terms of Service.</a>
                    </span>
                    <span style="color:red"><?php echo $termsErr ?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Create account</button>
            <span style="color:red"><?php echo $error ?>
        </form>	
    </div>
	
	
	<!-- This is the right column -->
    <div class="col-md">
		<div id="right_block">
			
		</div>
    </div>
	
	</div>
	
    
  </body>
</html>