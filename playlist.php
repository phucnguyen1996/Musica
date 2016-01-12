<?php
    session_start();
    include_once("config.php");
    //current URL of the Page. cart_update.php redirects back to this URL
    $current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
?>
<?php
    include_once("layout_top.php");
?>	
	    </div>
   </div>
</div>
<!--header end here-->
<!--Panier-->
<div class="gallery">
	<div class="container">
	    <div class="gallery-top heading">
		    <h2>PLAYLIST</h2>
		    <p>Site internet consacré à la découverte de la musique classique</p>
        </div>
        <div>
            <img src="images/retro-music.gif" alt="" style="width:730px; margin-left: 17em;"/>
        </div>
        <div class="col-sm-12">
            <table class="table table-striped">
                <tr>
                    <th>Titre</th>
                    <th>Extrait</th>
                    <th>Prix</th>
                    <th>Achat</th>
                </tr>
            <?php    
                if(isset($_GET['code_album'])) {
                                
                    $codeAlbum=$_GET['code_album'];
                                
                    $query="SELECT DISTINCT Enregistrement.Titre, Enregistrement.Prix, Album.Code_Album, Enregistrement.Code_Morceau
                        FROM Oeuvre 
                        INNER JOIN ((Composition 
                        INNER JOIN (((Album 
                        INNER JOIN Disque ON Album.Code_Album = Disque.Code_Album) 
                        INNER JOIN Composition_Disque ON Disque.Code_Disque = Composition_Disque.Code_Disque) 
                        INNER JOIN Enregistrement ON Composition_Disque.Code_Morceau = Enregistrement.Code_Morceau) ON Composition.Code_Composition = Enregistrement.Code_Composition) 
                        INNER JOIN Composition_Oeuvre ON Composition.Code_Composition = Composition_Oeuvre.Code_Composition) ON Oeuvre.Code_Oeuvre = Composition_Oeuvre.Code_Oeuvre
                        WHERE (((Album.Code_Album)='".$codeAlbum."'));";
                                
                                
                    foreach ($pdo->query($query) as $row) {
                        echo '<tr>'.
                            '  <td>'.$row['Titre'].'</td>'.
                            '  <td>'.
                            '      <audio controls><source src="extrait.php?Code='.$row['Code_Morceau'].'" type="audio/mpeg"></audio>'.
                            '  </td>'.
                            '  <td>'.$row['Prix'].'</td>'.
                            '  <td>'.
                            '      <form method="post" action="cart_add.php">'.
                            '          <button type="submit" name="code_item" value="'.$row['Code_Morceau'].'">Ajouter</button>'.
                            '      </form>'.
                            '  </td>'.
                            '</tr>';
                    } 
                }
                            
                
            ?>
        </div>
    </div>
</div>
</body>
</html>