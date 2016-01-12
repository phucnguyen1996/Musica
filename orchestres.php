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
                    $page_url = 'orchestres.php';
                    
                    $count = 0;
                    
                    $codeInstrument='';
                    $queryCodeInstrument='';
                    if(isset($_GET['code_instrument'])) {
                        $codeInstrument=$_GET['code_instrument'];
                        
                        $queryName="SELECT Instrument.Code_Instrument, Instrument.Nom_Instrument
                                    FROM Instrument
                                    WHERE Instrument.Code_Instrument='".$codeInstrument."'";
                        
                        foreach($pdo->query($queryName) as $row) {
                            $nomInstrument= $row['Nom_Instrument'];
                        }         
                        
                        $queryCodeInstrument="Instrument.Code_Instrument='".$codeInstrument."'";   
                    }
                    
                    $key='';
                    $queryKey='';
                    if(isset($_GET['key'])) {
                        $key = $_GET['key'];
                        
                        $queryKey="Orchestres.Code_Orchestre LIKE'%".$key."%'  
                                    OR Orchestres.Nom_Orchestre LIKE'%".$key."%' 
                                    OR  Musicien.Nom_Musicien LIKE'%".$key."%' 
                                    OR Musicien.Prénom_Musicien LIKE'%".$key."%'";
                                    
                    } 
                    
                    $h2='ORCHESTRES'; // titre h2 par defaut
                    $condition=''; 
                    $paramURL='';
                    if($codeInstrument!='')
                    {
                        if($key!='') {
                            $condition= "WHERE ".$queryCodeInstrument." AND (".$queryKey.")"; 
                            $paramURL="code_instrument=".$codeInstrument."&key=".$key."&";
                            $h2='RECHERCHE DES ORCHESTRES <br>Instrument: [ '.$nomInstrument.'] <br> Mots clés: [ '.$key.' ]';
                            
                        } 
                        else {
                            $condition= "WHERE ".$queryCodeInstrument;
                            $paramURL="code_instrument=".$codeInstrument."&";
                            $h2='RECHERCHE DES ORCHESTRES <br>Instrument: [ '.$nomInstrument.']';
                        }
                    }
                    else{
                        if($key!='') {
                            $condition= "WHERE ".$queryKey;
                            $paramURL="key=".$key."&";
                            $h2='RECHERCHE DES ORCHESTRES <br>Mots clés: [ '.$key.' ]';
                        }
                    }
                    
                    echo '<h2>'.$h2.'</h2>'; 
                ?>
				<br>
                <form medthod="get" action="orchestres.php" id="search-form" >
                    
                    <?php
                        // hidden input pour get code_instrument dans URL pour limiter la recherche
                        if($codeInstrument!=''){
                            echo '<input type="hidden" name="code_instrument" value="'.$codeInstrument.'">';
                        }
                    ?>
                    <input type="text" placeholder="Entrez ici..." name="key"/>
                    <input type="submit" value="Recherche" />
                </form>
			</div>
			<div class="row">
                <?php
                
                    if($codeInstrument=='') {
                        // compter total de lignes              
                        $queryCount = 'SELECT COUNT(DISTINCT Orchestres.Code_Orchestre) FROM (Orchestres 
                                INNER JOIN Direction ON Orchestres.Code_Orchestre = Direction.Code_Orchestre )
                                INNER JOIN Musicien ON Direction.Code_Musicien = Musicien.Code_Musicien '.$condition ;

                        include_once 'pagination.php' ;
                        
                        $query = "SELECT distinct Code_Orchestre, Nom_Orchestre, Nom_Musicien, Prénom_Musicien FROM 
                                    (
                                    SELECT DENSE_RANK() OVER (ORDER BY Orchestres.Nom_Orchestre ASC) AS RowNumber, Orchestres.Code_Orchestre, Orchestres.Nom_Orchestre, Musicien.Nom_Musicien, Musicien.Prénom_Musicien
                                    FROM (Orchestres INNER JOIN Direction ON Orchestres.Code_Orchestre = Direction.Code_Orchestre )
                                                     INNER JOIN Musicien ON Direction.Code_Musicien = Musicien.Code_Musicien ".$condition."
                                    ) a
                                    WHERE RowNumber >= $position and RowNumber <= $endPosition
                                    ORDER BY Nom_Orchestre ASC ";
                    }
                    else {
                        // compter total de lignes              
                        $queryCount = 'SELECT COUNT(DISTINCT Orchestres.Code_Orchestre) FROM Instrument INNER JOIN ((Musicien INNER JOIN (Orchestres INNER JOIN Direction ON Orchestres.Code_Orchestre = Direction.Code_Orchestre) ON Musicien.Code_Musicien = Direction.Code_Musicien) INNER JOIN Interpréter ON Musicien.Code_Musicien = Interpréter.Code_Musicien) ON Instrument.Code_Instrument = Interpréter.Code_Instrument '.$condition ;

                        include_once 'pagination.php' ;
                        
                        $query = "SELECT DISTINCT Code_Orchestre, Nom_Orchestre, Nom_Musicien, Prénom_Musicien, Code_Instrument, Nom_Instrument
                                    FROM 
                                    (
                                    SELECT distinct DENSE_RANK() OVER (ORDER BY Orchestres.Nom_Orchestre asc) AS RowNumber, Orchestres.Code_Orchestre, Orchestres.Nom_Orchestre, Musicien.Nom_Musicien, Musicien.Prénom_Musicien, Instrument.Code_Instrument, Instrument.Nom_Instrument
                                    FROM (((Orchestres INNER JOIN Direction ON Orchestres.Code_Orchestre = Direction.Code_Orchestre)
                                        INNER JOIN Musicien ON Musicien.Code_Musicien = Direction.Code_Musicien) 
                                        INNER JOIN Interpréter ON Musicien.Code_Musicien = Interpréter.Code_Musicien) 
                                        INNER JOIN Instrument ON Instrument.Code_Instrument = Interpréter.Code_Instrument ".$condition."
                                    ) a
                                    WHERE RowNumber >= $position and RowNumber <= $endPosition 
                                    order BY Nom_Orchestre asc";
                    }
                                                                                  
                    echo '<ul class="profile">';
                
                    foreach ($pdo->query($query) as $row) {
                        echo '<li class="new-item" id="new-item'. $count .'">' .
                            '  <div class="profile-right">' .
                            '      <p><i class="fa fa-toggle-right"></i><strong>'.$row['Nom_Orchestre'].'</strong></p>'.
                            '  </div>' .
                            '  <div class="profile-bottom">' . 
                            '      <div class="button-wrapper">' .
                            '          <a class="connect-action"><i class="fa fa-child"></i><span class="follow">'.$row['Nom_Musicien']." ".$row[utf8_decode('Prénom_Musicien')].'</span></a>'.
                            '          <a href="albums.php?code_orchestre='.$row['Code_Orchestre'].'" class="dismiss-action"><i class="fa fa-book"></i><span class="dismiss">Albums</span></a>'.
                            '      </div>'.
                            '  </div>'.
                            '</li>';
                        $count++;
                    }
                    
                    echo '</ul>';
                    $pdo=NULL;
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
<!--gallery end here-->
<?php
    include_once("layout_bot.php");
?>