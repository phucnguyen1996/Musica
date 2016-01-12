<?php 
include_once 'config.php' ;

//Charger les données depuis le paramètre ID fourni
$stmt = $pdo->prepare("SELECT Image FROM Instrument WHERE Code_Instrument=?");
$stmt->execute(array($_GET['Code']));

//Créer un stream depuis les données de la base de donnée
$stmt->bindColumn(1, $lob, PDO::PARAM_LOB);
$stmt->fetch(PDO::FETCH_BOUND);
$image = pack("H*", $lob);

//Changer le type de contenu de la page dans l'entête HTTP
header("Content-Type: image/jpeg");

//Ecrire ensuite ce flux dans le flux de réponse :
echo $image;

$pdo = null;
?>