<?php
	include "files/DBConnection.php";
	$articleID = $_GET['link'];
	$articleName = $db->query('SELECT ArticleTitle FROM article WHERE ArticleID = '.$articleID)->fetch()['ArticleTitle'];
	$stmt = $db->query('SELECT FileName  from file f inner join article_file af on f.FileID = af.File_FileID inner join article ar on  af.Articles_ArticleID = ar.ArticleID where ArticleID = '.$articleID.' AND FileName like "%.pdf"');
	$stmt2 = $db->query('SELECT FileName  from file f inner join article_file af on f.FileID = af.File_FileID inner join article ar on  af.Articles_ArticleID = ar.ArticleID where ArticleID = '.$articleID.' AND FileName NOT LIKE "%.pdf"');
	
	$articleName = substr($articleName, 0, 9);
	$zip = new ZipArchive();
	if ($zip->open(''.$articleName.'Download.zip', ZIPARCHIVE::CREATE) === TRUE ) {
	 	//add pdf's 
	 	while ($row = $stmt->fetch()) {
			$zip->addFile('articles/'.$row['FileName'], 'Article'.$row['FileName']);
	 	}
	 	//add images
		while ($row2 = $stmt2->fetch()) {
			$zip->addFile('images/articleImages/'.$row2['FileName'], 'Image'.$row2['FileName']);
	 	}
	 	$zip->close();
	}
	//download the zip file
	header("Content-disposition: attachment; filename=".$articleName."Download.zip");
	header("Content-type: application/zip");
	readfile("".$articleName."Download.zip");
	//and delete the zip file
	unlink("".$articleName."Download.zip");
	?>


