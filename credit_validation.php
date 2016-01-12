<?php
include 'config.php';

if(isset($_COOKIE['login'])){
    $login = $_COOKIE['login'];
    
	if(isset($_POST['valeur'])) {
        $valeur=$_POST['valeur'];
        
        if(empty($valeur) || $valeur<1 || $valeur>100 ) {
            header('Location: credit.php?erreur=invalide');
        }
        else {
            $query = "UPDATE Abonné SET Credit='".$valeur."' WHERE Login='".$login."'";
            $pdo->query($query);
            header('Location: cart.php');
        }
	}
}
else {
    header('Location: login.php');
}
    
    $pdo = NULL;
?>