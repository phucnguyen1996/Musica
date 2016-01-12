<?php
include 'config.php';
$nomErr = $prenomErr = $loginErr = $passwdErr= $paysErr = '';

if(isset($_POST['nom']) && !empty($_POST['nom'])){
    $queryNom = "SELECT Nom_Abonné FROM Abonné WHERE Nom_Abonné='" . $_POST['nom'] ."'";
    if($pdo->query($queryNom)->fetchcolumn() != "")
    {
        $nomErr= 'used';
    }
}
else {
    $nomErr= 'empty';
}

if(isset($_POST['prenom']) && !empty($_POST['prenom'])){
    $queryPrenom = "SELECT Prénom_Abonné FROM Abonné WHERE Prénom_Abonné='" . $_POST['prenom'] ."'";
    if($pdo->query($queryPrenom)->fetchcolumn() != "")
    {
        $prenomErr= 'used';
    }
}
else{
    $prenomErr='empty';
}

if(isset($_POST['login']) && !empty($_POST['login'])){
    $queryLogin = "SELECT Login FROM Abonné WHERE Login='" . $_POST['login'] ."'";
    if($pdo->query($queryLogin)->fetchcolumn() != "")
    {
        $loginErr= 'used';
    }
}
else
{
    $loginErr='empty';
}

if(!isset($_POST['password']) || empty($_POST['password'])) {
    $passwdErr='empty';
}

if(!isset($_POST['codePays']) || empty($_POST['codePays'])) {
    $paysErr='empty';
}

if($nomErr=='' && $prenomErr=='' && $loginErr=='' && $passwdErr=='' && $paysErr=='') {
    $query = "INSERT INTO Abonné (Nom_Abonné, Prénom_Abonné, Login, Password, Adresse, Ville, Code_Postal, Code_Pays, Email)
              VALUES('". $_POST['nom'] . "', '"
                      . $_POST['prenom'] . "', '"
                      . $_POST['login'] . "', '"
                      . $_POST['password'] . "', '"
                      . $_POST['adresse'] . "', '"
                      . $_POST['ville'] . "', '"
                      . $_POST['codePostal'] . "', '"
                      . $_POST['codePays'] . "', '"
                      . $_POST['email'] . "')" ; 
    try {
        $pdo->query($query) ;
        $URL = 'index.php';
        header ("Location: $URL");
        echo "SUCCES";
    }

    catch(PDOException $e)
    {
        echo $query . "<br>" . $e->getMessage();
    }
    $pdo = null;
}

else {
    $URL = 'register.php?nomErr='.$nomErr.'&prenomErr='.$prenomErr.'&loginErr='.$loginErr.'&passwdErr='.$passwdErr.'&paysErr='.$paysErr;
    header ("Location: $URL");
}

?>