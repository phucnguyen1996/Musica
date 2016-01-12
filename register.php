<?php
    if(isset($_COOKIE['login'])) {
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
				<h2>S'incrire</h2>
				<p>S'incrire pour decouvrir notre meilleure service</p>
			</div>
            <div class="form-group">
                <div class="col-xs-4">
                    <label>* Requis</label>
                    <label for="nom">* Nom</label>
                    <input class="form-control" id="nom" type="text" name="nom">
                    <?php 
                        if(isset($_GET['nomErr'])) {
                            
                            if($_GET['nomErr']=='used') {
                                echo '<div class="alert alert-danger">'.
                                    '  <strong>Nom: </strong> Veuillez changer le nom, celui-ci est utilisé!'.
                                    '</div>';
                            }
                            else if($_GET['nomErr']=='empty') {
                                echo '<div class="alert alert-danger">'.
                                    '  <strong>Nom: </strong> Nom est requis!'.
                                    '</div>';
                            }
                        }
                    ?>
                    <br>
            
                    <label for="prenom">* Prenom </label>
                    <input class="form-control" id="prenom" type="text" name="prenom">
                    <?php 
                        if(isset($_GET['prenomErr'])) { 
                            if($_GET['prenomErr']=='used') {
                                echo '<div class="alert alert-danger">'.
                                    '  <strong>Prénom: </strong> Veuillez changer le prénom, celui-ci est utilisé!'.
                                    '</div>';
                            }
                            else if($_GET['prenomErr']=='empty') {
                                echo '<div class="alert alert-danger">'.
                                    '  <strong>Prenom: </strong> Prenom est requis!'.
                                    '</div>';
                            }
                        }
                    ?>
                    <br>
            
                    <label for="login">* Login</label>
                    <input class="form-control" id="login" type="text" name="login">
                    <?php 
                        if(isset($_GET['loginErr'])) { 
                            if($_GET['loginErr']=='used') {
                                echo '<div class="alert alert-danger">'.
                                    '  <strong>Login: </strong> Veuillez changer le login, celui-ci est utilisé!'.
                                    '</div>';
                            }
                            else if($_GET['loginErr']=='empty') {
                                echo '<div class="alert alert-danger">'.
                                    '  <strong>Login: </strong> Login est requis!'.
                                    '</div>';
                            }
                        }
                    ?>
                    <br>
            
                    <label for="password">* Mots de passe</label>
                    <input class="form-control" id="password" type="password" name="password">
                    <?php 
                        if(isset($_GET['passwdErr'])) { 
                            if($_GET['passwdErr']=='empty') {
                                echo '<div class="alert alert-danger">'.
                                    '  <strong>Mots de passe: </strong> Mots de passe est requis!'.
                                    '</div>';
                            }
                        }
                    ?>
                    <br>
            
                    <label for="adresse">Adresse</label>
                    <input class="form-control" id="adresse" type="text" name="adresse">
                    <br>
                    
                    <label for="ville">Ville</label>
                    <input class="form-control" id="ville" type="text" name="ville">
                    <br>
                    
                    <label for="codePostal">Code Postal</label>
                    <input class="form-control" id="codePostal" type="text" name="codePostal">
                    <br>
                    
                    <label for="pays">* Pays</label><br>
                    <!-- select box Pays-->
                    <select class="form-control" id="pays" name="codePays">
                        <option value="">...</option>
                        <?php
                            include 'config.php' ;
                            
                            $query="SELECT Code_Pays, Nom_Pays 
                                    FROM Pays
                                    ORDER BY Nom_Pays";
                                    
                            foreach ($pdo->query($query) as $row) {
                                echo '<option value="'.$row['Code_Pays'].'">'.$row[utf8_decode('Nom_Pays')].'</option>';
                            } 
                        ?>
                    </select>
                    <?php 
                        if(isset($_GET['paysErr'])) { 
                            if($_GET['paysErr']=='empty') {
                                echo '<div class="alert alert-danger">'.
                                    '  <strong>Pays: </strong> Pays est requis!'.
                                    '</div>';
                            }
                        }
                    ?>
                    <br>
                    
                    <label for="email">Email</label>
                    <input class="form-control" id="email" type="email" name="email"><br>
                    
		            <button type="submit" class="btn btn-primary">Envoyer</button>
	               <button type="reset" class="btn btn-danger">Annuler</button>
                </div>
            </div>
		</div>	
    </form>
</div>
<!--contact end here-->
<?php
    include_once("layout_bot.php");
?>	