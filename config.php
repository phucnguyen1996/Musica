<?php
    // Paramètres de connexion
    $driver = 'sqlsrv';$host = 'INFO-SIMPLET';$nomDb = 'Classique_Web';
    $user = 'ETD';$password = 'ETD';    
    
    // Chaîne de connexion
    $pdodsn = "$driver:Server=$host;Database=$nomDb";
    try {
        // Connexion PDO
        $pdo = new PDO($pdodsn, $user, $password);
        $pdo2 = new PDO($pdodsn, $user, $password);
    }
    catch(PDOException $errMsg) 
    {
        echo 'Error: ' . $errMsg->getMessage();
    }
?>