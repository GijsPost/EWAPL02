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
		$link = $_GET['link'];

		$getArticleDataStmt = $db->query("SELECT * FROM Article WHERE ArticleID = $link");
		$ArticleData = $getArticleDataStmt->fetch(PDO::FETCH_ASSOC);
		$ArticleID = $ArticleData['ArticleID'];
		$ArticleText = $ArticleData['ArticleText'];

		$getArticleImageStmt = $db->query("select FileName from file f left join article_file af ON af.File_FileID = f.FileID left join article a on af.Articles_ArticleID = a.ArticleID where a.ArticleID = $ArticleID limit 1 ");
		$ArticleImage = $getArticleImageStmt->fetch(PDO::FETCH_ASSOC);

		$getArticlePublisherStmt = $db->query("select * from user s left join user_article ua ON ua.Users_UserID = s.UserID left join article a ON ua.Articles_ArticleID = a.ArticleID where a.ArticleID = $ArticleID");
		$ArticlePublisher = $getArticlePublisherStmt->fetch(PDO::FETCH_ASSOC);
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
				<div class="col-md-4">
					<img src="images/articleImages/<?php echo $ArticleImage['FileName'] ?>" id="ArticleImage">
				</div>
				<div class="col-md-8">
					<p class="lead" style="font-size: 1.0rem; margin-left: 5%;"><?php

						echo $ArticleText;

					?></p>
				</div>
			</div>

			<hr>

			<!-- Midden download balk -->

			<div class="alert alert-primary" role="alert">

				<h4>Publisher</h4>

				<div class="row">
				<div class="col-fixed-100">
					<img src="images/userProfilePicture/<?php

						if($ArticlePublisher['UserProfilePicture'] == null){
								echo "PROFILE_PICTURE_TEMPLATE";
						} else{
							echo $ArticlePublisher['UserProfilePicture'];
						}

					?>" style="width:60px;height:60px;margin-left:20%;">
				</div>
				<div class="col">
					<h5 style="margin-left:10px;"><?php echo $ArticlePublisher['UserName'];

						if($ArticlePublisher['UserType'] == 'publisher'){
							?><span class="badge badge-success" style="margin-left: 2%;">Publisher</span><?php
						}
						if($ArticlePublisher['UserType'] == 'admin'){
							?><span class="badge badge-danger" style="margin-left: 2%;">Administrator</span><?php
						}
					?></h5>
					<p style="margin-left:10px;"><?php echo $ArticlePublisher['UserInstitution']?></p>
				</div>
				</div>
				<button type="button" class="btn btn-primary">Go to profile</button>
				<button type="button" class="btn btn-secondary">Download Article</button>
			</div>

			<hr>

			<!-- Comment section -->

      <h3>Comments</h3>
      <h6>Sort by</h6>

      <!-- ?link=%203 -->
      <ul class="nav nav-tabs" style="margin-bottom: 2%;">
        <li class="nav-item">
        <a class="nav-link active" href="ArticlePage.php">Most recent</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="#">Oldest</a>
        </li>
      </ul>


      <?php
        $stmt1 = $db->query("SELECT * FROM ewapl02.comment WHERE Article_ArticleID = $link ORDER BY CommentDate ASC");

        while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
            $stmt2 = $db->query("SELECT UserName,UserProfilePicture FROM ewapl02.user WHERE UserID = $row1[User_UserID];");
            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="card" style="margin-bottom: 2%;">
      			  <div class="card-header">
              <img src="images/userProfilePicture/<?php
        					if($row2['UserProfilePicture'] == null){
        							echo "PROFILE_PICTURE_TEMPLATE";
        					} else{
        						echo $row2['UserProfilePicture'];
        					}
        			?>" style="width:50px;height:50px; margin-right: 15px;">
      				<b><?php echo $row2['UserName'] ?></b>
              <b ><span style="float:right;">Date posted: <?php echo $row1['CommentDate'] ?></b>
      			  </div>
      			  <div class="card-body">
      				<p class="card-text">
                <?php echo $row1['CommentText'] ?>
      				</p>
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
