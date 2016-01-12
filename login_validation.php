<?php
    include 'config.php';
	if(isset($_POST["login"]) && isset($_POST["password"])) {
        $login = $_POST["login"];
        $password = $_POST["password"];
        
        if($login=="" || $password=="") {
           $URL = "login.php?erreur=valeurNulle";
        }
        else {
            $query = "SELECT Login, Password 
                      FROM Abonné
                      WHERE Login='".$login."' AND Password='".$password."'";
        
            if($pdo->query($query)->fetchcolumn() == "")
            {
                $URL = "login.php?erreur=invalide";
            } 
                   
            else {
		      if(isset($_POST["remember"]))
			     setcookie("login", $login, time() + 24*60*60) ;
		      else
			     setcookie("login", $login) ;
            
		      $URL = "index.php";
            }
        } 
	   header ("Location: $URL");
	}
    
    $pdo = NULL;
?>