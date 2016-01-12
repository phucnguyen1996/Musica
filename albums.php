<?php
    include_once("layout_top.php");
?>	
	    </div>
   </div>
</div>
<!--header end here-->
<!--gallery-starts-->
<div class="gallery">
		<div class="container">
			<div class="gallery-top heading">
                <?php
                    include 'check_param_for_albums.php';
                    echo '<h2>'.$h2.'</h2>';
                ?>    
				<p>Cliquez sur l'image pour voir le playlist!</p>
                
                <br>
                <form medthod="get" action="albums.php" id="search-form" >
                    
                    <?php
                        // hidden input pour get code_pays dans URL pour limiter la recherche
                        if($nameInput!='' && $valueInput!='') {
                            echo '<input type="hidden" name="'.$nameInput.'" value="'.$valueInput.'">';
                        }
                    ?>
                    <input type="text" placeholder="Entrez ici..." name="key"/>
                    <input type="submit" value="Recherche" />
                </form>
			</div>
			<div class="row">
                <?php
                    $page_url = 'albums.php';
                    
                    if($pagination==TRUE) {
                        $queryCount = "SELECT (SELECT COUNT(*) FROM Album ".$condition. ")" ;
                    
                        include 'pagination.php' ;
                    
                        $query = "SELECT Code_Album, Titre_Album, Année_Album 
                                    FROM ( 
                                    SELECT *, ROW_NUMBER() OVER (ORDER BY Titre_Album) as row 
                                    FROM Album "
                                    .$condition. ")
                                a WHERE row > $position and row <= $endPosition" ;  
                    }                                              
                    
                    foreach ($pdo->query($query) as $row) {
                        echo '<div class="item item-type-move">'.
                                $row['Titre_Album'].
                             '  <a class="item-hover" href="playlist.php?code_album='.$row['Code_Album'].'" target="_blank">' .
                             '      <div class="item-info">'.
                             '          <div class="headline">'.
                                        $row['Titre_Album'].
                             '          </div>'.
                             '      </div>'.
                             '      <div class="mask"></div>'.
                             '  </a>'.
                             '  <div class="item-img"><img src="pochette.php?Code='.$row['Code_Album'].'" alt="" /></div>'.              
                             '</div>';
                    }
                   
                ?>
	       </div>
           <?php
                if($pagination) { 
                    echo '<div id="pagnation" style="text-align: center;">'.
                         '  <div class="container">'.
                         '      <ul class="pagination">'.
                         '          <li><a href="#">Page '.$curr_page. '/'. $total_pages .'</a></li>';
                    if(isset($total_pages))
                    {
                        if($total_pages>1)
                        {
                            // first page
                            if($curr_page>$num_links)
                                echo '<li><a href="'.$page_url.'?'.$paramPagination.'page=1"><<</a></li>' ;
                        
                            // previous page
                            if($curr_page>1)
                                echo '<li><a href="'.$page_url.'?'.$paramPagination.'page='.($curr_page-1).'"><</a></li>' ;
                    
                            for($pages = $start ; $pages <= $end ;$pages++)
                            {
                                if($pages == $curr_page)
                                    echo '<li class="active"><a href="'.$page_url.'?'.$paramPagination.'page='.$pages.'">'.$pages.'</a></li>';
                  
                                else
                                    echo '<li><a href="'.$page_url.'?'.$paramPagination.'page='.$pages.'">'.$pages.'</a></li>';
                            }
                        
                            // next page
                            if($curr_page < $total_pages )  
                                echo '<li><a href="'.$page_url.'?'.$paramPagination.'page='.($curr_page+1).'">></a></li>';
                
                            // last page
                            if(($curr_page + $num_links) <$total_pages )
                                echo '<li><a href="'.$page_url.'?'.$paramPagination.'page='.$total_pages.'">>></a> </li>';
                        
                        }
                    }
                    $pdo = NULL;
                    echo '      </ul>'.
                         '  </div>'.
                         '</div>';
                }
           ?>
<?php
    include_once("layout_bot.php");
?>