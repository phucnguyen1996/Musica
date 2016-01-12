<?php
session_start();
include ("config.php");
$code_abonne='';
$credit=0;
if(isset($_COOKIE['login'])) {
    $login = $_COOKIE['login'];
    
    $queryCode="SELECT Code_Abonné, Login, Credit FROM Abonné WHERE Login='" . $login ."'";
    
    foreach($pdo->query($queryCode) as $row) {
        $code_abonne = $row[utf8_decode('Code_Abonné')];
        $credit=$row['Credit'];
    }
}
$listItems = array();
$prixTotal=0;
//add product to session or create new one
if(isset($_SESSION['cart']) && !empty($_SESSION['cart']))
{
    foreach($_SESSION['cart'] as $id){
        $query="SELECT Enregistrement.Code_Morceau, Enregistrement.Titre, Enregistrement.Prix
                FROM Enregistrement     
                WHERE Enregistrement.Code_Morceau='".$id."'";
        foreach($pdo->query($query) as $row) {
            $prixTotal+=$row['Prix'];
            array_push($listItems, $row['Code_Morceau']);
        }
    }
    
    if($credit>=$prixTotal) {
        foreach($listItems as $item) {
            $query="INSERT INTO Achat(Code_Enregistrement, Code_Abonné) 
                    VALUES ('".$item."' , '".$code_abonne."')";
            
            try {        
                $pdo->query($query);
                
                $newCredit=$credit-$prixTotal;
                
                $queryCredit="UPDATE Abonné SET Credit='".$newCredit."' WHERE Code_Abonné='".$code_abonne."'"; 
                
                try {              
                    $pdo->query($queryCredit);             
                                
                    unset($_SESSION['cart']);
                    if(isset($_SESSION['cart'])) {
                        unset($_SESSION['cart']);
                    }
                    header('Location: cart.php');
                }
                catch(PDOException $errMsg) 
                {
                    echo 'Error: ' . $errMsg->getMessage();
                }       
            } 
            catch(PDOException $errMsg) 
            {
                echo 'Error: ' . $errMsg->getMessage();
            }       
        }
    }
}
$pdo=NULL;
?>