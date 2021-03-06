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
		$userid = $_SESSION['UserID'];
		$getUserDataStmt = $db->query("SELECT * FROM User WHERE UserID = $userid");
		$UserData = $getUserDataStmt->fetch(PDO::FETCH_ASSOC);
		
		if(is_null($UserData['UserBio'])){
			$UserBio = 'This person has no personal information';
		}else{
			$UserBio = $UserData['UserBio'];
		}

		if(is_null($UserData['UserProfilePicture'])){ 
			$UserProfilePicture = "PROFILE_PICTURE_TEMPLATE.jpg";
		}
		else{
			$UserProfilePicture = $UserData['UserProfilePicture'];
		}
	?>
	
	<!-- This is the center column -->
    <div class="col-lg-6">
			<div style = "margin-top: 40px; margin-bottom: 40px;">
				
				<hr>
					<center><h1> 
						<?php
							echo $UserData['UserName'];
							if($UserData['UserType'] == "Publisher"){
								echo '<span class="badge badge-success" style="margin-left:2px">Publisher</span>';
							}
						
							if($UserData['UserType'] == "Admin"){
								echo '<span class="badge badge-danger" style="margin-left:2px">Admin</span>';
							}
						?>
					</h1></center>
				<hr>
			</div>
			
			<div class="row"> 
			
			<div class="col-md">
			
			<h3 style="margin-left: 10%;">Institution</h3>
				
				<p style="margin-left: 10%;"><?php echo $_SESSION['UserInstitution'] ?>
				</p>

				<h3 style="margin-left: 10%;">Bio</h3>
				
				<p style="margin-left: 10%;"><?php echo $UserBio ?>
				</p>
			</div>
			<div class="col-md">
				<center><img src="images/UserProfilePicture/<?php echo $UserProfilePicture;?>" style="width: 70%; height: 100%;"></center>
				<button type="reset" class="btn btn-primary" style="margin-top: 10px; margin-left:15%;" onclick="location.href='EditProfile.php'">Edit profile</button>
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