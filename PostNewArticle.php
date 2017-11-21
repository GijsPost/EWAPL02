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
			
			$ArticleTitle = $ArticleTitleError = "";
			$ArticleSummary = $SummaryError = "";
			$error = "";
			
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
  				$error = "";
				
  				$ArticleTitle = strip_tags($_POST["inputArticleTitle"]);
	  			if (empty($_POST["inputArticleTitle"])) {
	                $ArticleTitleError = "Article title cannot be empty";
	            } else {
	                $ArticleTitle = strip_tags($_POST["inputArticleTitle"]);
	                if (strlen($ArticleTitle) < 10) {
	                    $ArticleTitleError = "Article Title must be at least 10 characters long"; 
	                }
	            }
				$ArticleSummary = strip_tags($_POST["inputSummary"]);
	  			if (empty($_POST["inputSummary"])) {
	                $SummaryError = "Summary cannot be empty";
	            } else {
	                $ArticleSummary = strip_tags($_POST["inputSummary"]);
	                if (strlen($ArticleSummary) > 500) {
	                    $SummaryError = "Summary is too long, shorten it to 500 characters or less"; 
	                }
	            }

				$stmt1 = $db->query("select count(*) from article where ArticleTitle = '$ArticleTitle'");
	            $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
	            if($row1['count(*)'] > 0){
	            	$ArticleTitleError = "An article with this title already exists";
				}

	            if(empty($ArticleTitleError) && empty($SummaryError)){
	            
	            	$stmt = $db->prepare('INSERT INTO article (ArticleTitle, ArticleText) 
	                VALUES (?,?)');
	                $stmt->bindValue(1, $ArticleTitle, PDO::PARAM_STR);
	                $stmt->bindValue(2, $ArticleSummary, PDO::PARAM_STR);
	                $stmt->execute();
					
					$stmt2 = $db->query("SELECT ArticleID FROM article ORDER BY ArticleID DESC LIMIT 0, 1;");
					$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
					$PresumedID = ($row2['ArticleID']);
						            	

	            	header("Location: ArticlePage.php?link=".$PresumedID."");
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
    <div class="col-lg-6 col-md-8">
			<div style = "margin-top: 40px; margin-bottom: 40px;">
				<hr>
					<center><h1>Upload new Article</h1></center>
				<hr>
			</div>
			
		<form method="post" action="">
            <div class="form-group row">
                <label for="inputArticleTitle" class="col-sm-3 col-form-label">Article title</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="inputArticleTitle" placeholder="Give your article a name">
					<span style="color:red"><?php echo $ArticleTitleError ?></span>
                </div>
            </div>
			<div class="form-group row">
				<label for="inputImage" class="col-sm-3 col-form-label">Upload image</label>
                <label class="btn btn-secondary" style="margin-left:15px;">
					Browse <input type="file" hidden accept="image/png,image/jpg,image/bmp">
				</label>
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
                <label class="btn btn-secondary" style="margin-left:15px;">
					Browse <input type="file" hidden accept="application/pdf,application/msword">
				</label>
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
	
	</div>
	
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>
