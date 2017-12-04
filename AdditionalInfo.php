<!doctype html>
<html lang="en">
  <head>
    <title>Hello, world!</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    
  </head>
  <body>
  
		<?php 
			include "files/DBConnection.php";
			include "files/Navbar.php";
            include 'files/Css.php';
            include 'ImageResize.php';
            
		?>

	<div class="row">
	
	<!-- This is the left column -->
    <div class="col-md">
      
    </div>
	
	
	<!-- This is the center column -->
    <div class="col-md-6">
			

            <div style = "margin-top: 40px; margin-bottom: 40px;">
				<hr>
					<center><h1>Add some personal information <?php echo $_SESSION['UserName']?> </h1></center>
				<hr>
			</div>
			
		
			
			<?php
                ob_start();
                $UserPrefix = "U";
                $bio = $imgLink = "";
                $bioErr = $error = $imgError = "";
                if($_SERVER["REQUEST_METHOD"] == "POST") {
                    
                    if(isset($_POST["addPersonalInfo"])) {
                        $uploadOk = 1;
                        $target_dir = "images/userProfilePicture/";
                        $target_file = $UserPrefix.$target_dir.basename($_FILES["fileToUpload"]["name"]);
                        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

                        // Check if image file is a actual image or fake image
                        if(!empty($_FILES["fileToUpload"]["name"]) && $uploadOk!= 0) {
                            // Check file size
                            if ($_FILES["fileToUpload"]["size"] > 500000) {
                                $imgError = "Sorry, your file is too large.";
                                $uploadOk = 0;
                            }
                            // Allow certain file formats
                            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                                $imgError = "Sorry, only JPG, JPEG & PNG files are allowed.";
                                $uploadOk = 0;
                            }

                            $bio = $_POST['inputBio'];
                            if(strlen($bio) > 500) {
                                $uploadOk = 0;
                                $bioErr = "Too long";
                            } 
                            // Check if $uploadOk is set to 0 by an error
                            if ($uploadOk == 1) { 
                                $target_file = $UserPrefix.$_SESSION['UserID'].".".$imageFileType;
                                $stmt1 = $db->prepare("UPDATE user SET UserProfilePicture = ?, UserBio = ? WHERE UserID = ?");
                                $stmt1->bindValue(1, $UserPrefix.$_SESSION['UserID'].".".$imageFileType);
                                $stmt1->bindValue(2, $bio);
                                $stmt1->bindValue(3, $_SESSION['UserID']);
                                $stmt1->execute(); 
                                $_SESSION['UserBio'] = $bio;
                                $_SESSION['UserProfilePicture'] = $target_file;


                                $target_dir = "images/userProfilePicture/";
                                $image = new SimpleImage();
                                $image->load($_FILES["fileToUpload"]['tmp_name']);
                                $image->resize(500,500);
                                $image->save($target_dir.$target_file);  

                                header( "Location: index.php");
                                exit();
                                
                            }
                        } else {
                            $imgError = "Something went wrong try again.";
                            $uploadOk = 0;
                        }
                    }else{
                        header("Location: index.php");
                    }

                    
                }


                
            ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
                <div class="form-group row">
                    
                        <label class="col-form-label">Write something about yourself (max 500 characters)</label>
                    
                        <textarea class="form-control" rows="5" name="inputBio" placeholder="Biography" value=<?php echo $bio?>></textarea>
                       <span style="color:red"><?php echo $bioErr ?></span>
                    
                </div>
                <div class="row">
                <label class="col-form-label">Upload a profile picture</label>
                </div>
                <div class="form-group row">        
                        <label class="custom-file">
                            <input type="file" name="fileToUpload" id="fileToUpload">
                        </label>
                        <span style="color:red"><?php echo $imgError ?></span>
                </div>
                <div class="row">
                <button type="submit" name="addPersonalInfo" class="btn btn-primary" style="width: 210px">Add personal information</button>
                <span style="color:red"><?php echo $error ?></span>
                </div>
                <div class="row">
                </div>
                <div class="row" style="padding-top: 10px">
                <button type="submit" name="skip" class="btn btn-primary" style="width: 210px">Skip</button>
                </div>


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
