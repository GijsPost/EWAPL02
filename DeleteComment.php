<?php
      include "files/DBConnection.php";
      session_start();
      if(strcmp($_SESSION['UserType'], "Admin") !== 0){
      	$id = $_GET['id'];
        header("Location: ArticlePage.php?link=$id&sort=new");
        exit();
      }else{
       	$commentID = $_GET['link'];
       	$articleID = $_GET['id'];
       	$db->query("DELETE FROM comment WHERE CommentID = $commentID");
       	header("Location: ArticlePage.php?link=$articleID&sort=new");
       	exit();
      }
    ?>