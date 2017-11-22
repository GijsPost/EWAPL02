<?php 
	session_start();
	session_unset($_SESSION);
	header("Location: Index.php");
?>