<!doctype html>
<html lang="en">
  <head>
    <title>Sign up</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="css/testing.css">
    
  </head>
  <body>
    
  	<?php
      include "files/DBConnection.php";
      include "files/Navbar.php";
      include "files/Css.php";
    ?>

    <div class="row">
  
      <!-- This is the left column -->
	  <div class="col-md-1"></div>
      <div class="col-md-2">
	  
		<div class="list-group" id="categoryList" >
		  <a href="Categories.php" class="list-group-item list-group-item-action active">
			All Categories
		  </a>
			<?php
				$getCategoryStmt = $db->query("SELECT * FROM category");
				while ($categories = $getCategoryStmt->fetch(PDO::FETCH_ASSOC)) {
				$CategoryID = $categories['CategoryID'];
				$CategoryName = $categories['CategoryName'];
				
				$getCategoryCount = $db->prepare("SELECT count(*) FROM article_category WHERE CategoryID = ?");
				$getCategoryCount->bindValue(1, $categories['CategoryID']);
				$getCategoryCount->execute(); 
                $categoryAmount = $getCategoryCount->fetch(PDO::FETCH_ASSOC);
			?>
				<a href="Categories.php<?php echo "?category=$CategoryID" ?>" class="list-group-item list-group-item-action"><?php echo $CategoryName;?> <span class="badge badge-primary badge-pill" style="float: right;"><?php echo $categoryAmount['count(*)']; ?></span></a>
				<?php } ?>
		</div>
	  
	  </div>
  
  
      <!-- This is the center column -->
	  
		<?php
			$categoryName = "Browse Categories";
			$categoryColor = "#ffffff";
			if(!empty($_GET['category'])){
				$categoryID = $_GET['category'];
				$getCategoryStmt = $db->query("SELECT * FROM category WHERE CategoryID = $categoryID");
				$Category = $getCategoryStmt->fetch(PDO::FETCH_ASSOC);
				$categoryName = $Category['CategoryName'];
				
				$categoryColor = $Category['CategoryColor'];
			}
			
		?>
	  
      <div class="col-md-6">
        <div style = "margin-top: 40px; margin-bottom: 40px; background-color:<?php echo $categoryColor;?>;">
          <hr>		  					
            <center><h1><?php echo $categoryName;?></h1></center>
          <hr>
        </div>  

		<?php
			$CurrentCategory = null;
			$stmt1 = null;
			$articlesInCategory = null;
			
				if (empty($_GET['category'])){
					$stmt1 = $db->query("SELECT * FROM article");
					$checkStmt = $db->query("SELECT count(*) FROM article");
					$articlesAmount = $checkStmt->fetch(PDO::FETCH_ASSOC);
					$articlesInCategory = $articlesAmount['count(*)'];
				}else{
					$CurrentCategory = $_GET['category'];
					$stmt1 = $db->query("SELECT * FROM article a LEFT JOIN article_category ac ON ac.ArticleID = a.ArticleID LEFT JOIN category c ON ac.CategoryID = c.CategoryID WHERE c.CategoryID = $CurrentCategory");				
					$checkStmt = $db->query("SELECT count(*) FROM article a LEFT JOIN article_category ac ON ac.ArticleID = a.ArticleID LEFT JOIN category c ON ac.CategoryID = c.CategoryID WHERE c.CategoryID = $CurrentCategory");
					$articlesAmount = $checkStmt->fetch(PDO::FETCH_ASSOC);
					$articlesInCategory = $articlesAmount['count(*)'];
				
				}
				if($articlesInCategory <= 0){echo "No articles found in this category...";}
				else{
				
				
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
				<?php } }
		?>
		
      </div>
    
  
      <!-- This is the right column -->
      <div class="col-md-2"></div>
	  <div class="col-md-1"></div>
    </div>
  
  </body>
</html>