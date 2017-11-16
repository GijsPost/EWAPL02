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
		$getArticleDataStmt = $db->query("SELECT * FROM Article WHERE ArticleID = 1");
		$ArticleData = $getArticleDataStmt->fetch(PDO::FETCH_ASSOC);
		$ArticleID = $ArticleData['ArticleID'];
		$ArticleText = $ArticleData['ArticleText'];
		
		$getArticleImageStmt = $db->query("select FileName from file f left join article_file af ON af.File_FileID = f.FileID left join article a on af.Articles_ArticleID = a.ArticleID where a.ArticleID = $ArticleID limit 1 ");
		$ArticleImage = $getArticleImageStmt->fetch(PDO::FETCH_ASSOC);
	?>
	
	<!-- This is the center column -->
    <div class="col-lg-8 col-md-10">
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
			
			<!-- Midden download balk -->
			
			<div class="alert alert-primary" role="alert">
				To read the full article, download it <a href="#" class="alert-link">here</a>.
			</div>
			
			<hr>
			
			<!-- Comment section -->
			
			<h3>Comments</h3>
			<h6>Sort by</h6>
			<ul class="nav nav-tabs" style="margin-bottom: 2%;">
			  <li class="nav-item">
				<a class="nav-link active" href="#">Most recent</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="#">Oldest</a>
			  </li>
			</ul>
			
			<div class="card" style="margin-bottom: 5%;">
			  <div class="card-header">
				<img src="images/pfp.jpg" style="width:50px;height:50px; margin-right: 15px;">
				<b>Username</b>
			  </div>
			  <div class="card-body">
				<p class="card-text"><?php
					$myfile = fopen("files/loremipsum_small.txt", "r") or die("Unable to open file!");
					echo fread($myfile,filesize("files/loremipsum_small.txt"));
					fclose($myfile);
					?>
				</p>
			  </div>
			</div>
    </div>
	
	
	<!-- This is the right column -->
    <div class="col-md">
		<div id="right_block">
			
		</div>
    </div>
	
	</div>
	
    
  </body>
</html>