<?php
    if(!isset($_COOKIE['login'])) {
        header('Location: index.php');
    }
    include_once("layout_top.php");
?>			
	    </div>
   </div>
</div>
<!--header end here-->
<!--contact start here-->
<div class="contact">
    <form method="post" action="register_validation.php">
		<div class="container">
			<div class="contact-top">
				<h2>AJOUTER CREDIT</h2>
				<p>S'il vous plaît recharger au maximum 100 credits</p>
			</div>
            <div class="form-group" style="text-align: center;"> 
                <form method="post" action="credit_validation.php">
                 <input type="text" placeholder="Entrez ici..." name="valeur"/>
                 <input type="submit" value="Recharger" />
                 <?php 
                    if(isset($_GET['erreur']) && $_GET=='invalide') {
                        echo '<div class="alert alert-danger">'.
                             '  <strong>Erreur: </strong> Valeur invalide, maximum 100!'.
                             '</div>';
                    }
                 ?>
                 
                 </form>
            </div>
		</div>	
    </form>
</div>
<!--contact end here-->
<?php
    include_once("layout_bot.php");
?>	