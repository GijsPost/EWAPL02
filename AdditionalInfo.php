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
		?>

	<div class="row">
	
	<!-- This is the left column -->
    <div class="col-md">
      
    </div>
	
	
	<!-- This is the center column -->
    <div class="col-md-6">
			<div style = "margin-top: 40px; margin-bottom: 40px;">
				<hr>
					<center><h1>Add some personal information</h1></center>
				<hr>
			</div>
			
		
			
			<?php
                $userID = $_GET['link'];
                $bio = $imgLink = "";
                $bioErr = $error = "";
                

                // Check if image file is a actual image or fake image
                if($_SERVER["REQUEST_METHOD"] == "POST") {
                    $target_dir = "images/";
                    $target_file = $target_dir . basename($_FILES["file"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

                    $check = getimagesize($_FILES["file"]["tmp_name"]);
                    if($check !== false) {
                        echo "File is an image - " . $check["mime"] . ".";
                        $uploadOk = 1;
                    } else {
                        echo "File is not an image.";
                        $uploadOk = 0;
                    }
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                    }
                }


                
            ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
                <div class="form-group row">
                    
                        <label class="col-form-label">Write something about you (max 500 characters)</label>
                    
                        <textarea class="form-control" rows="5" name="inputBio" placeholder="Biography" value=<?php echo $bio?>></textarea>
                       <span style="color:red"><?php echo $bioErr ?></span>
                    
                </div>
                <div class="row">
                <label class="col-form-label">Upload a profile picture</label>
                </div>
                <div class="form-group row">        
                        <label class="custom-file">
                            <input type="file" name="file" id="file">
                        </label>
                </div>
                <button type="submit" class="btn btn-primary">Add personal information</button>
                <span style="color:red"><?php echo $error ?></span>



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
