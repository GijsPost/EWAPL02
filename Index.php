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
                        <img class="card-img-top" src="images/articleImages/<?php echo $row2['FileName'] ?>" alt="File Image Missing" style="height:30%;width:100%;">
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
	
   
  </body>
</html>
