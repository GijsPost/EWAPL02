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
    $ArticlePublisherID = $ArticlePublisher['UserID'];

    /** handle insert comment, un/follow user post requests **/
    $input = $articleId = $userId = "";
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
      $articleId = $link;
      $userId = $_SESSION["UserID"];

      if (empty($_POST["input"])) {
        $nameErr = "Empty comment.";
      } else {
        $input = $_POST["input"];

        $stmt = $db->prepare("INSERT INTO `ewapl02`.`comment` (`CommentText`, `User_UserID`, `Article_ArticleID`) VALUES (?, ?, ?);");
          $stmt->bindValue(1, $input);
          $stmt->bindValue(2, $userId);
          $stmt->bindValue(3, $articleId);
          $stmt->execute();
      }
    }elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['follow'])) {
      $follower = $_POST["follower"];
      $following = $_POST["following"];

      $stmt = $db->prepare("INSERT INTO `ewapl02`.`user_follow` (`Follower_UserID`, `Following_UserID`) VALUES (?, ?);");
        $stmt->bindValue(1, $follower);
        $stmt->bindValue(2, $following);
        $stmt->execute();
    }elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['unfollow'])) {
      $follower = $_POST["follower"];
      $following = $_POST["following"];

      $stmt = $db->prepare("DELETE FROM `ewapl02`.`user_follow` WHERE `Follower_UserID`=? and`Following_UserID`=?;");
        $stmt->bindValue(1, $follower);
        $stmt->bindValue(2, $following);
        $stmt->execute();
    }?>

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


      <!-- downloadfiles select FileName  from file f inner join article_file af on f.FileID = af.File_FileID inner join article ar on  af.Articles_ArticleID = ar.ArticleID where ArticleID = 54 AND FileName like "%.pdf" -->
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

						if($ArticlePublisher['UserType'] == 'Publisher'){
							?><span class="badge badge-success" style="margin-left: 1ex;">Publisher</span><?php
						}
						if($ArticlePublisher['UserType'] == 'Admin'){
							?><span class="badge badge-danger" style="margin-left: 1ex;">Admin</span><?php
						}
					?></h5>
					<p style="margin-left:10px;"><?php echo $ArticlePublisher['UserInstitution']?></p>
				</div>
				</div>
        <div class="row">
  				<a href="ProfilePage.php?link= <?php echo $ArticlePublisherID;?> " class="btn btn-primary" style="margin-left:5px;">Profile</a>
  				<a href="DownloadArticle.php?link=<?php echo $_GET['link'];?>" class="btn btn-secondary" style="color: white; margin-left:5px;">Download</a>
          <!-- if user is logged in and show un/follow button -->
          <?php
          if(isset($_SESSION["UserID"])){
            if($_SESSION["UserID"] != $ArticlePublisher['UserID']){
              $getFollowingStatusStmt = $db->prepare("SELECT * FROM ewapl02.user_follow WHERE Follower_UserID=? AND Following_UserID=?;");
              $getFollowingStatusStmt->bindParam(1, $_SESSION["UserID"]);
              $getFollowingStatusStmt->bindParam(2, $ArticlePublisher['UserID']);
              $getFollowingStatusStmt->execute();
              $followingStatus = $getFollowingStatusStmt->fetch(PDO::FETCH_ASSOC);


              if(!empty($_SESSION['UserType']) && !$followingStatus){
              ?>
                <form method="POST" action="">
                  <input type="hidden" name="follower" value="<?php echo $_SESSION["UserID"] ?>">
                  <input type="hidden" name="following" value="<?php echo $ArticlePublisher['UserID'] ?>">
                  <button type="submit" class="btn btn-secondary" value="follow" name="follow" style="margin-left:5px;">Follow</button>
                </form>
            <?php
              }elseif ($followingStatus) {
                ?>
                <form method="POST" action="">
                  <input type="hidden" name="follower" value="<?php echo $_SESSION["UserID"] ?>">
                  <input type="hidden" name="following" value="<?php echo $ArticlePublisher['UserID'] ?>">
                  <button type="submit" class="btn btn-secondary" value="unfollow" name="unfollow" style="margin-left:5px;" title="Click to unsubscribe.">&#10004; Following</button>
                </form>
                <?php
              }
            }
          }?>
        </div>
			</div>

			<hr>

			<!-- Comment section -->

      <h3>Comments</h3>
      <!-- insert comment into database -->
      <?php
  			if(!isset($_SESSION['UserType'])){
  			?>
  			<div style = "margin-top: 40px; margin-bottom: 40px;">
  				<hr>
  					<center><p>Please  <a href="Login.php">log in</a> to post an comment</p></center>
  				<hr>
  			</div>
      <?php } else{ ?>

      <form method="post" action="">
        <div class="form-group">
          <label for="comment">Leave a comment:</label>
          <textarea class="form-control" rows="3" id="comment" name="input"></textarea>
        </div>
        <button type="submit" class="btn btn-default" style="float: right" value="comment" name="comment">Submit</button>
      </form>
    <?php }?>


      <h6>Sort by</h6>



      <ul class="nav nav-tabs" style="margin-bottom: 2%;">
        <li class="nav-item">
        <a class="nav-link active" href="ArticlePage.php<?php echo "?link=$link&sort=new" ?>">Most recent</a>
        </li>
        <li class="nav-item">
      <a class="nav-link active" href="ArticlePage.php<?php echo "?link=$link&sort=old" ?>">Oldest</a>
        </li>
      </ul>

      <!-- Get comments from database. -->
      <?php
        $sort = $_GET['sort'];

        if($sort == "old"){
          $stmt1 = $db->query("SELECT * FROM comment WHERE Article_ArticleID = $link ORDER BY CommentDate ASC");
        }else{
          $stmt1 = $db->query("SELECT * FROM comment WHERE Article_ArticleID = $link ORDER BY CommentDate DESC");
        }

        while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
            $stmt2 = $db->query("SELECT UserName, UserProfilePicture FROM user WHERE UserID = $row1[User_UserID];");
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
      				<b><?php echo $row2['UserName']; if(isset($_SESSION['UserType']) && $_SESSION['UserType'] == "Admin"){ echo'<a class="btn btn-default" href="DeleteComment.php?link='.$row1['CommentID'].'&id='.$_GET['link'].'">Delete comment</a> ';  } ?></b>
              <b><span style="float:right;">Date posted: <?php echo date("d-m-Y", strtotime($row1['CommentDate'])); ?></b>
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
