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
                    $page_url = 'instruments.php';
                    
                    $count = 0;
                    $h2='INSTRUMENTS'; // titre h2 par defaut
                    
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
                        
                        $queryKey="Instrument.Code_Instrument LIKE'%".$key."%'  
                                    OR Instrument.Nom_Instrument LIKE'%".$key."%'";
                    } 
                    
                    
                    $condition=''; 
                    $paramURL='';
                    if($codeInstrument!='')
                    {
                        if($key!='') {
                            $condition= "WHERE ".$queryCodeInstrument." AND (".$queryKey.")"; 
                            $paramURL="code_instrument=".$codeInstrument."&key=".$key."&";
                            $h2='RECHERCHE DES INSTRUMENTS <br>Instrument: [ '.$nomInstrument.'] <br> Mots clés: [ '.$key.' ]';
                            
                        } 
                        else {
                            $condition= "WHERE ".$queryCodeInstrument;
                            $paramURL="code_instrument=".$codeInstrument."&";
                            $h2='RECHERCHE DES INSTRUMENTS <br>Instrument: [ '.$nomInstrument.']';
                        }
                    }
                    else{
                        if($key!='') {
                            $condition= "WHERE ".$queryKey;
                            $paramURL="key=".$key."&";
                            $h2='RECHERCHE DES INSTRUMENTS <br>Mots clés: [ '.$key.' ]';
                        }
                    }
                    echo '<h2>'.$h2.'</h2>'; 
                ?>
				<br>
                <form medthod="get" action="instruments.php" id="search-form" >
                    
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
                $page_url = 'instruments.php';

                $count = 0;

                $queryCount = "SELECT (SELECT COUNT(*) FROM Instrument )" ;

                include_once('pagination.php');

                $query = "SELECT Code_Instrument, Nom_Instrument, Image 
                                FROM (  SELECT *, ROW_NUMBER() OVER (ORDER BY Nom_Instrument) as row 
                                        FROM Instrument ".$condition." ) 
                                a WHERE row > $position and row <= $endPosition" ;

                echo '<ul class="profile">';
                foreach ($pdo->query($query) as $row) {
                    echo '<li class="new-item-inst" id="new-item-inst'. $count .'">' .
                         '  <div class="item-inst item-type-move-inst">'.
                         '      <a class="item-hover-inst" >' .
                         '          <div class="item-info-inst">'.
                         '              <div class="headline-inst">'.
                                            $row['Nom_Instrument'].
                         '              </div>'.
                         '          </div>'.
                         '          <div class="mask-inst"></div>'.
                         '      </a>'.
                         '      <div class="item-img-inst"><img src="photo_instrument.php?Code='.$row['Code_Instrument'].'" alt="" /></div>'.     
                         '  </div>'.
                         '  <div class="profile-bottom">' . 
                         '      <div class="button-wrapper">' .
                         '          <a class="connect-action-inst" href="albums.php?code_instrument='.$row['Code_Instrument'].'" target="_blank"><i class="fa fa-book"></i><span class="follow">Albums de <span style="font-family: "Comic Sans MS", cursive, sans-serif">'.$row['Nom_Instrument'].'</span></span></a>'.
                         '          <a  class="dismiss-action-inst" href="orchestres.php?code_instrument='.$row['Code_Instrument'].'" target="_blank"><i class="fa fa-music"></i><span class="dismiss">Orchestres</span></a>'.
                         '      </div>'.
                         '  </div>'.
                         '</li>';
                    $count++;
                }
                echo '</ul>';
                $pdo=NULL;
            ?>
       </div>
    </div>
</div>
<!--gallery end here-->
<!--pagination-starts-->
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
                            echo '<li><a href="'.$page_url.'?page=1"><<</a></li>' ;
                        
                        // previous page
                        if($curr_page>1)
                            echo '<li><a href="'.$page_url.'?page='.($curr_page-1).'"><</a></li>' ;
                    
                        for($pages = $start ; $pages <= $end ;$pages++)
                        {
                            if($pages == $curr_page)
                                echo '<li class="active"><a href="'.$page_url.'?page='.$pages.'">'.$pages.'</a></li>';
                  
                            else
                                echo '<li><a href="'.$page_url.'?page='.$pages.'">'.$pages.'</a></li>';
                        }
                        
                        // next page
                        if($curr_page < $total_pages )  
                            echo '<li><a href="'.$page_url.'?page='.($curr_page+1).'">></a></li>';
                
                        // last page
                        if(($curr_page + $num_links) <$total_pages )
                            echo '<li><a href="'.$page_url.'?page='.$total_pages.'">>></a> </li>';
                        
                    }
                }
                ?>
                </ul>
            </div>
        </div>
<!--pagination end here-->
<?php
    include_once("layout_bot.php");
?>