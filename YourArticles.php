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

			if(empty($_SESSION['UserID'])){
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
				$getArticlesStmt = $db->query("SELECT * from article a left join user_article u on a.ArticleID = u.Articles_ArticleID where u.Users_UserID = ".$UserID."");
				// $article = $getArticlesStmt->fetch();
				// if(is_null($article['ArticleTitle'])){
				// 	echo'
				// 		<div class="row">
				// 			<div class="col-sm-8">
				// 				<h4> You have no articles yet, <a href="PostNewArticle.php">post a article!</a></h4>
				// 			</div>
				// 		</div>
				// 	';
				// }else{
        if ($getArticlesStmt->execute() && $getArticlesStmt->rowCount() > 0) {
				      while($article = $getArticlesStmt->fetch(PDO::FETCH_ASSOC)){
  			?>
  				<div class="alert alert-primary clearfix" role="alert">
  					<div class="row">
  					<div class="col-sm-6">
  					<b><?php echo $article['ArticleTitle'];?></b>
  					</div>
  					<div class="col-sm-6">
  					<a  href="ArticlePage.php?link=<?php echo $article['ArticleID'];?>&sort=new"><button type="button" class="btn btn-success">View</button></a>
  					<a  href="EditArticle.php?articleToEdit=<?php echo $article['ArticleID'];?>"><button type="button" class="btn btn-warning">Edit</button></a>
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
      }else { ?>
        <div style = "margin-top: 40px; margin-bottom: 40px;">
          <hr>
            <center><p>No results found</p></center>
          <hr>
        </div>
        <?php
      } ?>
      </div>


	<!-- This is the right column -->
    <div class="col-md">
		<div id="right_block">

		</div>
    </div>
	<?php } ?>
	</div>

  </body>
</html>
