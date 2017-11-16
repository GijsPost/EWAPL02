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
		$getArticleDataStmt = $db->query("SELECT * FROM Article WHERE ArticleID = 1");
		$ArticleData = $getArticleDataStmt->fetch(PDO::FETCH_ASSOC);
		$ArticleID = $ArticleData['ArticleID'];
		$ArticleText = $ArticleData['ArticleText'];
		
		$getArticleImageStmt = $db->query("select FileName from file f left join article_file af ON af.File_FileID = f.FileID left join article a on af.Articles_ArticleID = a.ArticleID where a.ArticleID = $ArticleID limit 1 ");
		$ArticleImage = $getArticleImageStmt->fetch(PDO::FETCH_ASSOC);
	?>
	
	<!-- This is the center column -->
    <div class="col-lg-8">
			<div style = "margin-top: 4%; margin-bottom: 4%;">
				<hr>
					<center><h1> 
						<?php
							echo $ArticleData["ArticleTitle"];
						?>
					</h1></center>
				<hr>
			</div>
			
			<!-- Article body -->
			<div class="row">
				<div class="col-md">
					<img src="<?php echo $ArticleImage['FileName'] ?>" id="ArticleImage">
				</div>
				<div class="col-md">
					<p class="lead" style="font-size: 1.0rem; margin-left: 5%;"><?php 
					
						echo $ArticleText;
					
					?></p>
				</div>
			</div>
			
			<hr>
			
			<!-- Footer -->
			
			<div class="alert alert-primary" role="alert">
				To read the full article, download it <a href="#" class="alert-link">here</a>.
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