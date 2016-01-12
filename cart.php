<?php
    session_start();
    include_once("config.php");
    
    if(!isset($_COOKIE['login'])) {
        header ("Location: login.php");
    }
?>
<?php
    include_once("layout_top.php");
?>		
	    </div>
   </div>
</div>
<!--header end here-->
<!--contact start here-->
<div class="contact">
		<div class="container">
			<div class="gallery-top heading">
				<h2>PANIER</h2>
			</div>	
			<div class="contact-form">
				<?php
    
    
                if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    echo'<table class="table table-hover">'.
                        '   <thead>'.
                        '       <tr>'.          
                        '           <th>Numero</th>'.
                        '           <th>Titre</th>'.
                        '           <th>Prix</th>'.
                        '           <th>Delete</th>'.
                        '       </tr>'.
                        '   </thead>'.
                        '   <tbody>';
                $count=0;
        
                while (list ($key, $val) = each ($_SESSION['cart'])) { 
                    $count++;
                    $query = "SELECT Enregistrement.Code_Morceau, Enregistrement.Titre, Enregistrement.Prix
                            FROM Enregistrement   
                            WHERE Enregistrement.Code_Morceau='".$val."'";
                      
                    foreach($pdo->query($query) as $row) {
                        echo '<tr>'.
                             '  <td>'.$count.'</td>'.
                             '  <td>'.$row['Titre'].'</td>'.
                             '  <td>'.$row['Prix'].
                             '  <td>'.
                             '      <form method="post" action="cart_remove.php">'.
                             '          <button type="submit" name="item[]" value="'.$key.'"'.$row['Code_Morceau'].'">Supprimer</button>'.
                             '      </form>'.
                             '  </td>'.
                             '</tr>';
                    } 
                }
        
                echo '   <tbody>';
                     '</table>';
                echo '<h5>Total: <span class="label label-default">'.sizeof($_SESSION['cart']).'</span></h5>'.
                     '<div class="row">'.
                     '<div class="col-md-3"><button onclick="history.go(-1);" class="btn btn-info" role="button">Ajouter encore</button></div>'.
                     '<div class="col-md-3"><a href="cart_remove_all.php" class="btn btn-info" role="button">Supprimer tous</a></div>'.
                     '<div class="col-md-3"><a href="cart_buy.php" class="btn btn-info" role="button">Acheter</a></div>'.
                     '</div>';
            }
            else echo 'Cart est nulle';
            ?>
			</div>
			
		</div>
	</div>
</body>
</html>