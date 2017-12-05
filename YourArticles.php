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
			include "files/Css.php";
			
			if(empty($_SESSION['UserType']) || $_SESSION['UserType'] != "Publisher"){
			?>
			<div style = "margin-top: 40px; margin-bottom: 40px;">
				<hr>
					<center><h1>Please log in to view your articles</h1></center>
				<hr>
			</div>
			<?php } else{				
			?>
	
    <div class="row">
	
	<!-- This is the left column -->
    <div class="col-md">
      
    </div>
	
	
	<!-- This is the center column -->
    <div class="col-lg-6 col-md-8">
			<div style = "margin-top: 40px; margin-bottom: 40px;">
				<hr>
					<center><h1>Your Articles</h1></center>
				<hr>
			</div>		
			
			<!-- Start of your articles-->
			<?php
				$UserID = $_SESSION['UserID'];
				$getArticlesStmt = $db->query("SELECT * from article a left join user_article u on a.ArticleID = u.Articles_ArticleID where u.Users_UserID = $UserID");
				while($article = $getArticlesStmt->fetch(PDO::FETCH_ASSOC)){
			?>
				<div class="alert alert-primary clearfix" role="alert">
					<div class="row">
					<div class="col-sm-6">
					<b><?php echo $article['ArticleTitle'];?></b>
					</div>
					<div class="col-sm-6">
					<a  href="ArticlePage.php?link=<?php echo $article['ArticleID'];?>"><button type="button" class="btn btn-success">View</button></a>
					<a  href="ArticlePage.php?link=<?php echo $article['ArticleID'];?>"><button type="button" class="btn btn-warning">Edit</button></a>
					<button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-target="#M<?php echo $article['ArticleID'];?>">Delete</button>
					</div>
					</div>
				</div>
				
				<!-- Modal -->
				<div class="modal fade" id="M<?php echo $article['ArticleID'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Are you sure you want to delete this article?</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <div class="modal-body">
						Deleting this article will remove it from the database and will delete all pictures and files attached.
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
						<a href="DeleteArticle.php?articleToDelete=<?php echo $article['ArticleID'];?>"><button type="button" class="btn btn-primary">Delete</button></a>
					  </div>
					</div>
				  </div>
				</div>
				
			<?php
			}
			

			?>
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
