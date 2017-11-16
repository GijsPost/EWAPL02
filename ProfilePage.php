<!doctype html>
<html lang="en">
  <head>
    <title>Publishing Lab</title>
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
		?>

	<div class="row">
	
	<!-- This is the left column -->
    <div class="col-md">
      
    </div>
	
	<?php
		$getUserDataStmt = $db->query("SELECT * FROM User WHERE UserID = 1");
		
		$UserData = $getUserDataStmt->fetch(PDO::FETCH_ASSOC);
		
		if(is_null($UserData['UserProfilePicture']))
			$UserProfilePicture = "PROFILE_PICTURE_TEMPLATE";
		else
			$UserProfilePicture = $UserData['UserProfilePicture'];
	?>
	
	<!-- This is the center column -->
    <div class="col-lg-6">
			<div style = "margin-top: 40px; margin-bottom: 40px;">
				<hr>
					<center><h1> 
						<?php
							echo $UserData['UserName'];
						?>
					<span class="badge badge-success">Publisher</span></h1></center>
				<hr>
			</div>
			
			<div class="row"> 
			
			<div class="col-md">
			
				<h3 style="margin-left: 10%;">Bio</h3>
				
				<p style="margin-left: 10%;"><?php $myfile = fopen("loremipsum.txt", "r") or die("Unable to open file!");
					echo fread($myfile,filesize("loremipsum.txt"));
					fclose($myfile);?>
				</p>
			</div>

			<div class="col-md">
				<center><img src="images/<?php echo $UserProfilePicture;?>.jpg" style="width: 70%; height: 100%;"></center>
			</div>
			
			</div>
    </div>
	
	
	<!-- This is the right column -->
    <div class="col-lg">
		<div id="right_block">
			
		</div>
    </div>
	
	</div>
	
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>