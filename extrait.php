<?php 
include_once 'config.php' ;

//Charger les données depuis le paramètre ID fourni
$stmt = $pdo->prepare("SELECT Extrait FROM Enregistrement WHERE Code_Morceau=?");
$stmt->execute(array($_GET['Code']));

//Créer un stream depuis les données de la base de donnée
$stmt->bindColumn(1, $lob, PDO::PARAM_LOB);
$stmt->fetch(PDO::FETCH_BOUND);
$audio = pack("H*", $lob);

//Changer le type de contenu de la page dans l'entête HTTP
header("Content-Type: audio/mpeg");

//Ecrire ensuite ce flux dans le flux de réponse :
echo $audio;

$pdo = null;
?>