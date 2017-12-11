<?php

    include "files/DBConnection.php";
	include "files/Navbar.php";
    include "files/Css.php";
	
	$ArticleID = $_GET['articleToDelete'];
	
	$LoggedInUserID = $_SESSION['UserID'];
	$LoggedInUserType = $_SESSION['UserType'];
	
	$getArticlePublisherStmt = $db->query("SELECT * FROM user_article WHERE Articles_ArticleID = $ArticleID");
	
	while($ArticlePublisherID = $getArticlePublisherStmt->fetch(PDO::FETCH_ASSOC)){
		if($LoggedInUserType != "Admin"){
			if($LoggedInUserID != $ArticlePublisherID['Users_UserID']){
				echo "You are not authorised to delete this article.";
			} else{ echo "You are the owner of this article, welcome. Deleting Article...";
				deleteArticle();
			}
		} else{ echo "You are an admin, welcome. Deleting Article...";
			deleteArticle();
		}
	}
	
	function deleteArticle(){
		$ArticleID = $_GET['articleToDelete'];
		include "files/DBConnection.php";
		
		$deleteArticleStmt = $db->query("DELETE FROM article WHERE ArticleID = $ArticleID");
		$deleteArticleStmt->execute();
		
		if(strcmp($_SESSION['UserType'], "Admin") == 0){
			header("Location: Admin/AdminArticle.php");
			exit();
		}

		header("Location: YourArticles.php");
		exit();
	}
?>