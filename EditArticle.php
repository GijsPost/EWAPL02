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
			include "files/DBConnection.php";
			include "files/Navbar.php";
			
			$ArticleID = null;
			if(!empty($_GET['articleToEdit'])){ $ArticleID = $_GET['articleToEdit']; }
			$ErrorMsg = "Error. Provide article ID to edit.";
			$LoggedInUserID = $_SESSION['UserID'];
			$LoggedInUserType = $_SESSION['UserType'];
			
			$editOK = false;
			
			if(!empty($ArticleID)){	
			$getArticlePublisherStmt = $db->query("SELECT * FROM user_article WHERE Articles_ArticleID = $ArticleID");
			
			while($ArticlePublisherID = $getArticlePublisherStmt->fetch(PDO::FETCH_ASSOC)){
				if($LoggedInUserType != "Admin"){
					if($LoggedInUserID != $ArticlePublisherID['Users_UserID']){
						$ErrorMsg = "You are not authorized to edit this article";
					} else{
						$editOK = true;
					}
				} else{
					$editOK = true;
				}
			}
			} 
			
			if(!$editOK){
			?>
			<div style = "margin-top: 40px; margin-bottom: 40px;">
				<hr>
					<center><h1><?php echo $ErrorMsg; ?></h1></center>
				<hr>
			</div>
			<?php } else {
			
			$ArticleTitle = $ArticleTitleError = "";
			$ArticleSummary = $SummaryError = "";
			$error = "";
			$imgError = "";
			$ArticlePrefix = "A";
			$fileEndStatus = false;
			$imageEndStatus = false;
			$articleEndStatus = false;
			
			//Get the current Article
			$sql = "SELECT * FROM article WHERE ArticleID = $ArticleID";
			$result=$db->query($sql);
			$row = $result->fetch(PDO::FETCH_ASSOC);
			
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
  				$error = "";			
				
  				$newArticleTitle = strip_tags($_POST["inputArticleTitle"]);
	  			if (empty($_POST["inputArticleTitle"])) {
	                $ArticleTitleError = "Article title cannot be empty";
	            } else {
	                $newArticleTitle = strip_tags($_POST["inputArticleTitle"]);
	                if (strlen($newArticleTitle) < 10) {
	                    $ArticleTitleError = "Article Title must be at least 10 characters long"; 
	                }
	            }
				
				$newArticleSummary = strip_tags($_POST["inputSummary"]);
	  			if (empty($_POST["inputSummary"])) {
	                $SummaryError = "Summary cannot be empty";
	            } else {
	                $newArticleSummary = strip_tags($_POST["inputSummary"]);
	                if (strlen($newArticleSummary) > 500) {
	                    $SummaryError = "Summary is too long, shorten it to 500 characters or less"; 
	                }
	            }

				if($newArticleTitle != $row['ArticleTitle']){
					$stmt1 = $db->query("select count(*) from article where ArticleTitle = '$ArticleTitle'");
					$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
					if($row1['count(*)'] > 0){
						$ArticleTitleError = "An article with this title already exists";
					}
				} else{
				
				}

	            if(empty($ArticleTitleError) && empty($SummaryError)){
					
					$uploadOk = 1;
                    $target_dir_images = "images/articleImages";
					$target_dir_articles = "articles/";
                    $target_file_image = $target_dir_images . basename($_FILES["imageToUpload"]["name"]);
					$target_file_article = $target_dir_articles . basename($_FILES["fileToUpload"]["name"]);
                        
                    $imageFileType = pathinfo($target_file_image,PATHINFO_EXTENSION);
					$articleFileType = pathinfo($target_file_article,PATHINFO_EXTENSION);

					
                        // Check if image file is a actual image or fake image
                        
                    $checkImage = empty($_FILES["imageToUpload"]["tmp_name"]);
					
					if (!$checkImage){

                            // Allow certain file formats
                            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                                $imgError = "Sorry, only JPG, JPEG & PNG files are allowed.";
                                $uploadOk = 0;
                            }
					}		
							// Check if article file is a actual pdf or fake
                        
                    $checkFile = empty($_FILES["fileToUpload"]["tmp_name"]);
					
					if(!$checkFile){

                            // Allow certain file formats
                            if($articleFileType != "pdf") {
                                $imgError = "Sorry, only PDF files are allowed.";
                                $uploadOk = 0;
                            }
					}		
                            // Check if $uploadOk is set to 0 by an error
                            if ($uploadOk == 1) { 
                                $target_file_image = $ArticlePrefix.$ArticleID.".".$imageFileType;
								$target_file_article = $ArticlePrefix.$ArticleID.".".$articleFileType;
							
							
								//Override title and summary
								$stmt = $db->prepare('UPDATE article SET ArticleTitle=? WHERE ArticleID = ?');  
								$stmt->bindValue(1, $newArticleTitle, PDO::PARAM_STR);
								$stmt->bindValue(2, $ArticleID, PDO::PARAM_STR);
								$stmt->execute();
								
								$stmt = $db->prepare('UPDATE article SET ArticleText=? WHERE ArticleID = ?');  
								$stmt->bindValue(1, $newArticleSummary, PDO::PARAM_STR);
								$stmt->bindValue(2, $ArticleID, PDO::PARAM_STR);
								$stmt->execute();
								
								//Resetting all categories
								$stmt = $db->prepare("DELETE FROM article_category WHERE ArticleID = ?");
								$stmt->bindValue(1, $ArticleID, PDO::PARAM_STR);
								
								//Check for categories
								$getCategoryStmt = $db->query("SELECT * FROM category");
								while ($categories = $getCategoryStmt->fetch(PDO::FETCH_ASSOC)) {
									$CategoryID = $categories['CategoryID'];
									if(isset($_POST[$CategoryID])){
										$insertStmt = $db->prepare("INSERT INTO article_category (ArticleID, CategoryID) VALUES (?,?);");
										$insertStmt->bindValue(1, $ArticleID);
										$insertStmt->bindValue(2, $categories['CategoryID']);
										$insertStmt->execute();
									}
								}
								//Gives a sign that the article is uploaded OK
								$articleEndStatus = true;
								
								//INSERT IMAGE
								if(!$checkImage){
                                if (move_uploaded_file($_FILES["imageToUpload"]["tmp_name"], "images/articleImages/{$target_file_image}")) {
									
									$stmt1 = $db->prepare("INSERT INTO file (FileName) VALUES(?);");
                                    $stmt1->bindValue(1, $target_file_image);
                                    $stmt1->execute(); 
									
									$stmt1 = $db->prepare("UPDATE article_file SET File_FileID=(SELECT FileID FROM file ORDER BY FileID DESC LIMIT 0, 1))WHERE Articles_ArticleID = ?");
                                    $stmt1->bindValue(1, $ArticleID);
                                    $stmt1->execute(); 
									//Gives a sign that the image is uploaded ok.
									$imageEndStatus = true;
									
                                    while (ob_get_status()) 
                                    {
                                        ob_end_clean();
                                    }
                                } else {
                                    $imgError = "Sorry, there was an error uploading your image.";
                                }
								}
								
								//INSERT PDF FILE
								if(!$checkFile){
								if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "articles/{$target_file_article}")) {
                                    
									$stmt1 = $db->prepare("INSERT INTO file (FileName) VALUES(?);");
                                    $stmt1->bindValue(1, $target_file_article);
                                    $stmt1->execute(); 
									
									$stmt1 = $db->prepare("UPDATE article_file SET File_FileID=(SELECT FileID FROM file ORDER BY FileID DESC LIMIT 0, 1) WHERE Articles_ArticleID =?");
                                    $stmt1->bindValue(1, $ArticleID);
                                    $stmt1->execute();
									//Gives a sign that the pdf file is uploaded ok.
									$fileEndStatus = true;
                                    while (ob_get_status()) 
                                    {
                                        ob_end_clean();
                                    }
                                } else {
                                    $imgError = "Sorry, there was an error uploading your pdf file.";
                                }
								}
                            }
					if($articleEndStatus && $imageEndStatus && $fileEndStatus){
						
						//header("Location: ArticlePage.php?link=".$ArticleID."&sort=new");
						//exit();
						
					} else{

					}
	            }           
			}
			
		?>
	
    <div class="row">
	
	<!-- This is the left column -->
    <div class="col-md">
      
    </div>
	
	
	<!-- This is the center column -->
    <div class="col-lg-6 col-md-8">
			<div style = "margin-top: 40px; margin-bottom: 40px;">
				<hr>
					<center><h1>Edit Article</h1></center>
				<hr>
			</div>
			
		<form method="post" action="" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="inputArticleTitle" class="col-sm-3 col-form-label">Article title</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="inputArticleTitle" placeholder="Give your article a name">
					<span style="color:red"><?php echo $ArticleTitleError ?></span>
                </div>
            </div>
			<div class="form-group row">
				<label for="inputImage" class="col-sm-3 col-form-label">Upload image</label>
				<label class="custom-file">
                    <input type="file" name="imageToUpload" id="imageToUpload" style="margin-left:5%;">
                </label>
                <span style="color:red"><?php echo $imgError ?></span>
            </div>
            <div class="form-group row">
                <label for="inputSummary" class="col-sm-3 col-form-label">Summary</label>
                <div class="col-sm-9">
                    <textarea class="form-control" rows="5" name="inputSummary" placeholder="Write a summary for your article of max 500 words"></textarea>
					<span style="color:red"><?php echo $SummaryError ?></span>
				</div>
            </div>
            <div class="form-group row">
				<label for="inputFile" class="col-sm-3 col-form-label" >Upload (pdf)</label>
                <label class="custom-file">
                    <input type="file" name="fileToUpload" id="fileToUpload" style="margin-left:5%;">
                </label>
            </div>
			<div class="form-group row">
				
			  	<label for="sel1" class="col-sm-3 col-form-label">Category</label>
			  	<div class="col-sm-9	">
					    <?php
							$getCategoryStmt = $db->query("SELECT * FROM category");
							while ($categories = $getCategoryStmt->fetch(PDO::FETCH_ASSOC)) {
							$CategoryName = $categories['CategoryName'];
						?>
						
							<label class="custom-control custom-checkbox">
							  <input type="checkbox" class="custom-control-input" name="<?php echo $categories['CategoryID']?>">
							  <span class="custom-control-indicator"></span>
							  <span class="custom-control-description"><?php echo $CategoryName;?></span>
							</label>
						
						<?php } ?>
			  	</div>
			</div>
            <button type="submit" class="btn btn-primary">Upload Article</button>
			<span style="color:red"><?php echo $error ?></span>
        </form>
			
			
			
    </div>
	
	
	<!-- This is the right column -->
    <div class="col-md">
		<div id="right_block">
			
		</div>
    </div>
	<?php } ?>
	</div>
	
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>
