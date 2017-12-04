<?php
	
	include "DBConnection.php";


	if(!empty($_GET['key'])){
		$key=$_GET["key"];
		
		$Users = $db->query("SELECT DISTINCT * FROM User WHERE UserName LIKE '%".$key."%' ORDER BY UserName ");
        $Users1 = $db->query("SELECT DISTINCT COUNT(UserName) FROM User WHERE UserName LIKE '%".$key."%' ORDER BY UserName ");

        $Articles = $db->query("SELECT DISTINCT * FROM Article WHERE ArticleTitle LIKE '%".$key."%' ORDER BY Articletitle ");
        $Articles1 = $db->query("SELECT DISTINCT COUNT(ArticleTitle) FROM Article WHERE ArticleTitle LIKE '%".$key."%' ORDER BY Articletitle");
        
        $num_rows1 = $Users1->fetchColumn();
        $num_rows2 = $Articles1->fetchColumn();

		if($num_rows1 > 0) {
	        $vorige = '';
	  		echo '<h1>Users</h1>';
	        echo '<table>';
	        while($row = $Users->fetch(PDO::FETCH_ASSOC)) {
	            

	            if ($vorige !== ucfirst(substr($row['UserName'],0,1))){
	                if (ctype_digit(substr($row['UserName'],0,1)) == true) {
	                    echo'
	                        <tr>
	                            <th>
	                                <h1>#</h1>
	                            </th>
	                        </tr>';
	                } else {
	                    echo'
	                        <tr>
	                            <th class="contact">
	                                <h3>'.substr($row['UserName'],0,1).'</h3>
	                            </th>
	                        </tr>';
	                }
	            }
	            echo '
	                <tr>
	                    <th>
	                        <a href="Profile.php?link='.$row['UserID'].'">
	                        '.$row['UserName'].'
	                        </a>
	                    </th>
	                </tr>';
	            $vorige = ucfirst(substr($row['UserName'],0,1));
	        } echo '</table>'; 
	    }

	    if($num_rows2 > 0) {
	        $vorige = '';
	  		echo '<h1>Articles</h1>';
	        echo '<table>';
	        while($row = $Articles->fetch(PDO::FETCH_ASSOC)) {

	            if ($vorige !== ucfirst(substr($row['ArticleTitle'],0,1))){
	                if (ctype_digit(substr($row['ArticleTitle'],0,1)) == true) {
	                    echo'
	                        <tr>
	                            <th>
	                                <h1>#</h1>
	                            </th>
	                        </tr>';
	                } else {
	                    echo'
	                        <tr>
	                            <th class="contact">
	                                <h3>'.substr($row['ArticleTitle'],0,1).'</h3>
	                            </th>
	                        </tr>';
	                }
	            }
	            echo '
	                <tr>
	                    <th>
	                        <a href="ArticlePage.php?link='.$row['ArticleID'].'">
	                        '.$row['ArticleTitle'].'
	                        </a>
	                    </th>
	                </tr>';
	            $vorige = ucfirst(substr($row['ArticleTitle'],0,1));
	        } echo '</table>'; 
	    }






	}
?>