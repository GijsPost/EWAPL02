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
	        while($row = $Users->fetch(PDO::FETCH_ASSOC)) {
	            if ($vorige !== ucfirst(substr($row['UserName'],0,1))){
	                    echo'
	                       	<div class="row">
	                       		<div class="col-sm-6"> 
	                                <h3>'.ucfirst(substr($row['UserName'],0,1)).'</h3>
	                        	</div>
	                        </div>
	                        ';  
	            }
	            echo '
	                <div class="row">
	                	<div class="col-sm-6">
	                        <a href="Profile.php?link='.$row['UserID'].'" style="margin-left:1em; color: inherit; text-decoration:none;" >
	                        '.$row['UserName'].'
	                        </a>
	                    </div>
	                </div>';
	            $vorige = ucfirst(substr($row['UserName'],0,1));
	        }; 
	    }

	    if($num_rows2 > 0) {
	        $vorige = '';
	  		echo '<h1>Articles</h1>';
	        while($row = $Articles->fetch(PDO::FETCH_ASSOC)) {
	            if ($vorige !== ucfirst(substr($row['ArticleTitle'],0,1))){   
	                echo'
	                    <div class="row">
	                   		<div class="col-sm-6"> 
	                            <h3>'.ucfirst(substr($row['ArticleTitle'],0,1)).'</h3>
	                       	</div>
	                    </div>
	                    ';  
	            }

	            $Creator = $db->query( "SELECT * FROM user WHERE UserID = (SELECT Users_UserID FROM user_article WHERE Articles_ArticleID = ".$row['ArticleID']." LIMIT 1)");
	            $CreatorRows = $Creator->fetch();
	            echo '
	                <div class="row">
	                   	<div class="col-sm-8"> 
	                        <a href="ArticlePage.php?link='.$row['ArticleID'].'" style="margin-left:1em; color: inherit; text-decoration:none;">
	                        '.$row['ArticleTitle'].'
	                        </a>
	                  	</div>
	                  	<div class="col-sm-4">
	                  		By: 
	                  		<a href="Profile.php?link='.$CreatorRows['UserID'].'" style="color: inherit; text-decoration:none;" >
	                        '.$CreatorRows['UserName'].'
	                        </a>
	                  	</div> 

                    </div>
                    ';  
	            $vorige = ucfirst(substr($row['ArticleTitle'],0,1));
	        }
	    }
	    if($num_rows1 == 0 && $num_rows2 == 0){
	    	echo'
	    		<div class="row">
	    			<div class="col-sm-8"> 
	    				<h1>No results</h1> 
	    			</div>
	    		</div> 
	    	';
	    }





	}
?>