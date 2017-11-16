<!doctype html>
<html lang="en">
  <head>
    <title>Publishing Lab</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  
  </head>
  <body>
  
		<?php 
			include "files/DBConnection.php";
			include "files/Navbar.php";
			include "files/Css.php";
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
				
				<p style="margin-left: 10%;"><?php $myfile = fopen("files/loremipsum.txt", "r") or die("Unable to open file!");
					echo fread($myfile,filesize("files/loremipsum.txt"));
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
	
  
  </body>
</html>