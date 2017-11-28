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


      
      $bio = $_SESSION['UserBio'];  
      $username = $_SESSION['UserName'];  
      $institution = $_SESSION['UserInstitution'];
      $email = $_SESSION['UserEmail'];
      $usernameErr = $emailErr = $error = "";
      $password = $passwordErr = "";
      $confirmPassword = $confirmPasswordErr = "";
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

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" name="inputPassword" placeholder="Password" value=<?php echo $password?>>
                    <span style="color:red"><?php echo $passwordErr ?></span>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputConfirmPassword" class="col-sm-3 col-form-label">Confirm password</label>
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

            
            <button type="submit" class="btn btn-primary" style="float: right">Create account</button>
            <span style="color:red"><?php echo $error ?></span>
        </form> 
    </div>


  
    
  
      <!-- This is the right column -->
      <div class="col-md"></div>
  
    </div>
  
  </body>
</html>