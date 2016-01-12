<?php
    include_once("layout_top.php");
?>		
	    </div>
   </div>
</div>
<!--header end here-->
<!--contact start here-->
<div class="contact">
    <form method="post" action="login_validation.php">
		<div class="container">
			<div class="contact-top">
				<h2>S'incrire</h2>
				<p>S'incrire pour decouvrir notre meilleure service</p>
			</div>
            <div class="form-group"
            <div>
                <div class="col-xs-4">
                    <?php 
                        if(isset($_GET['erreur'])) { 
                            if($_GET['erreur']=='invalide') {
                                echo '<div class="alert alert-danger">'.
                                    '  <strong>Login out mots de passe invalide!'.
                                    '</div>';
                            }
                        }
                    ?>
                    <label for="login">Identifiant</label>
                    <input class="form-control" id="login" type="text" name="login"><br>
                    
                    <label for="password">Mots de passe</label>
                    <input class="form-control" id="password" type="password" name="password"><br>
                    
                    <input type="checkbox" name="remember" value="true">
                    <label>Souvenez moi!</label><br><br>
                    
		            <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
            </div>    
            </div>
		</div>	
    </form>
</div>
<!--contact end here-->
<?php
    include_once("layout_bot.php");
?>