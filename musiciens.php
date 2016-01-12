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
                    $page_url = 'musiciens.php';
                    
                    $codePays='';
                    $queryCodePays='';
                    if(isset($_GET['code_pays']))
                    {
                        $codePays = $_GET['code_pays'];
                        
                        // get nom pays pour afficher
                        $queryName="SELECT Pays.Code_Pays, Pays.Nom_Pays
                                    FROM Pays       
                                    WHERE Pays.Code_Pays='".$codePays."'";
        
                        foreach($pdo->query($queryName) as $row) {
                            $h2 = $row['Nom_Pays'].': les compositeurs';
                            $nomPays= $row['Nom_Pays'];
                        }
                            
                        // condition pour la commande principale
                        $queryCodePays="Code_Pays='". $codePays."'" ;
                        
                    } 
                    
                    $key='';
                    $queryKey='';
                    if(isset($_GET['key'])) {
                        $key = $_GET['key'];
                        
                        // comparer key avec les attributs du musicien
                        $queryKey="Code_Musicien LIKE'%".$key."%'  
                                    OR Nom_Musicien LIKE'%".$key."%' 
                                    OR Prénom_Musicien LIKE'%".$key."%' 
                                    OR Année_Naissance LIKE'%".$key."%' 
                                    OR Année_Mort LIKE'%".$key."%'";
                    } 
                    
                    
                    $h2='MUSICIENS'; // titre h2 par defaut
                    $condition=''; 
                    $paramURL='';
                    if($codePays!='')
                    {
                        if($key!='') {
                            $condition= "WHERE ".$queryCodePays." AND (".$queryKey.")"; 
                            $paramURL="code_pays=".$codePays."&key=".$key."&";
                            $h2='RECHERCHE DES MUSICIENS <br>Pays: [ '.$nomPays.'] <br> Mots clés: [ '.$key.' ]';
                            
                        } 
                        else {
                            $condition= "WHERE ".$queryCodePays;
                            $paramURL="code_pays=".$codePays."&";
                            $h2='RECHERCHE DES MUSICIENS <br>Pays: [ '.$nomPays.']';
                        }
                    }
                    else{
                        if($key!='') {
                            $condition= "WHERE ".$queryKey;
                            $paramURL="key=".$key."&";
                            $h2='RECHERCHE DES MUSICIENS <br>Mots clés: [ '.$key.' ]';
                        }
                    }
                    
                    echo '<h2>'.$h2.'</h2>'; 
                ?>
				<p>Cliquez sur l'image pour voir la liste des albums auquel le musicien asssocié!</p>
                
                <br>
                <form medthod="get" action="musiciens.php" id="search-form" >
                    
                    <?php
                        // hidden input pour get code_pays dans URL pour limiter la recherche
                        if($codePays!=''){
                            echo '<input type="hidden" name="code_pays" value="'.$codePays.'">';
                        }
                    ?>
                    <input type="text" placeholder="Entrez ici..." name="key"/>
                    <input type="submit" value="Recherche" />
                </form>
                        
			</div>
			<div class="row">
                <?php
                    
                    // compter total de lignes              
                    $queryCount = 'SELECT COUNT(*) FROM Musicien '.$condition ;
                                    
                    include_once 'pagination.php' ;
                                    
                    $query = "SELECT Code_Musicien, Nom_Musicien, Prénom_Musicien, Année_Naissance, Année_Mort 
                                FROM ( 
                                    SELECT *, ROW_NUMBER() OVER (ORDER BY Nom_Musicien) as row 
                                    FROM Musicien "
                                    .$condition.") 
                                a WHERE row > $position and row <= $endPosition" ;
                    
                    foreach ($pdo->query($query) as $row) {
                        echo '<div class="item item-type-move">'.
                             '  <a class="item-hover" href="albums.php?code_musicien='.$row['Code_Musicien'].'" target="_blank">' .
                             '      <div class="item-info">'.
                             '          <div class="headline">'.
                                        $row['Nom_Musicien'].' '.$row[utf8_decode('Prénom_Musicien')].
                             '              <div class="line"></div>'.           
                             '          </div>'.
                             '          <div class="date">'.$row[utf8_decode('Année_Naissance')].'-'.$row[utf8_decode('Année_Mort')].'</div>'. 
                             '      </div>'.
                             '      <div class="mask"></div>'.
                             '  </a>'.
                             '  <div class="item-img"><img src="photo_musicien.php?Code='.$row['Code_Musicien'].'" alt="" /></div>'.              
                             '</div>';
                    }
                ?>                
			</div>
            <div id="pagnation" style="text-align: center;">
                <div class="container">
                    <ul class="pagination">
                    <?php
                        echo '<li><a href="#">Page '.$curr_page. '/'. $total_pages .'</a></li>';
                        if(isset($total_pages))
                        {
                            if($total_pages>1)
                            {
                                // first page
                                if($curr_page>$num_links)
                                    echo '<li><a href="'.$page_url.'?'.$paramURL.'page=1"><<</a></li>' ;
                        
                                // previous page
                                if($curr_page>1)
                                    echo '<li><a href="'.$page_url.'?'.$paramURL.'page='.($curr_page-1).'"><</a></li>' ;
                    
                                for($pages = $start ; $pages <= $end ;$pages++)
                                {
                                    if($pages == $curr_page)
                                        echo '<li class="active"><a href="'.$page_url.'?'.$paramURL.'page='.$pages.'">'.$pages.'</a></li>';
                  
                                    else
                                        echo '<li><a href="'.$page_url.'?'.$paramURL.'page='.$pages.'">'.$pages.'</a></li>';
                                }
                        
                                // next page
                                if($curr_page < $total_pages )  
                                    echo '<li><a href="'.$page_url.'?'.$paramURL.'page='.($curr_page+1).'">></a></li>';
                
                                // last page
                                if(($curr_page + $num_links) <$total_pages )
                                    echo '<li><a href="'.$page_url.'?'.$paramURL.'page='.$total_pages.'">>></a> </li>';
                            }
                        }
                        $pdo = NULL;
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php
    include_once("layout_bot.php");
?>