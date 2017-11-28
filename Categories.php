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
	  
		<div class="list-group" id="categoryList">
		  <a href="#" class="list-group-item list-group-item-action active">
			All Categories
		  </a>
			<?php
				$getCategoryStmt = $db->query("SELECT * FROM category");
				while ($categories = $getCategoryStmt->fetch(PDO::FETCH_ASSOC)) {
				$CategoryName = $categories['CategoryName'];
				
				$getCategoryCount = $db->prepare("SELECT count(*) FROM article_category WHERE CategoryID = ?");
				$getCategoryCount->bindValue(1, $categories['CategoryID']);
				$getCategoryCount->execute(); 
                $categoryAmount = $getCategoryCount->fetch(PDO::FETCH_ASSOC);
			?>
				<a href="#" class="list-group-item list-group-item-action"><?php echo $CategoryName;?> <span class="badge badge-primary badge-pill" style="float: right;"><?php echo $categoryAmount['count(*)']; ?></span></a>
				<?php } ?>
		</div>
	  
	  </div>
  
  
      <!-- This is the center column -->
      <div class="col-md-6">
        <div style = "margin-top: 40px; margin-bottom: 40px;">
          <hr>
            <center><h1>Browse Categories</h1></center>
          <hr>
        </div>  

		
		
      </div>
    
  
      <!-- This is the right column -->
      <div class="col-md-2"></div>
	  <div class="col-md-1"></div>
    </div>
  
  </body>
</html>