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
		?>
	
    	<div class="row">
	
	<!-- This is the left column -->
    <div class="col-md">
      
    </div>
	
	
	<!-- This is the center column -->
    <div class="col-lg-6 col-md-8">
			<div style = "margin-top: 40px; margin-bottom: 40px;">
				<hr>
					<center><h1>Latest Articles</h1></center>
				<hr>
			</div>
			
			<!-- Start of Articles -->
			
			<?php
                $stmt1 = $db->query("SELECT * FROM article");
                while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                    $test = $row1['ArticleID'];
					
					$linkToArticlePage = "ArticlePage.php?link= $test";
					
                    $stmt2 = $db->query("select FileName from file f left join article_file af ON af.File_FileID = f.FileID left join article a on af.Articles_ArticleID = a.ArticleID where a.ArticleID = $test limit 1 ");
                    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <div class="card" style="width:100%; margin-bottom: 100px; overflow: hidden;">
                        <img class="card-img-top" src="images/<?php echo $row2['FileName'] ?>" alt="File Image Missing" style="height:30%;width:100%;">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $row1['ArticleTitle']; ?></h4>
                            <p class="card-text"><?php echo $row1['ArticleText']; ?></p>
                            <a href="<?php echo $linkToArticlePage; ?>" class="btn btn-primary">Read Article</a>
                        </div>
                    </div>
                <?php } ?>
			
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
