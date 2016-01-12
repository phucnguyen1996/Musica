<?php
    include 'config.php';
    $h2='Albums';
    $suiteH2='';
    $pagination=FALSE;
    $paramPagination='';
    $condition='';
    $nameInput='';
    $valueInput='';
    
    $key='';
    $queryKey='';
    if(isset($_GET['key']) && !empty($_GET['key'])) {
        $key = $_GET['key'];
        
        $queryKey="AND (Album.Code_Album LIKE'%".$key."%'  
                        OR Album.Titre_Album LIKE'%".$key."%' 
                        OR Année_Album LIKE'%".$key."%' )";
       $suiteH2='<br>Mots clés: [ '.$key.' ]';
    }
    
    $codeMusicien='';
    $codeOrchestre='';
    $codeInstrument='';
    $codeGenre='';
    
    if(isset($_GET['code_musicien']))
    {
        $codeMusicien = $_GET['code_musicien'];
        $parm = 'code_musicien='.$codeMusicien;
        $queryName="SELECT Code_Musicien, Nom_Musicien, Prénom_Musicien, Année_Naissance, Année_Mort
                    FROM Musicien 
                    WHERE Code_Musicien=".$codeMusicien;
        
        foreach($pdo->query($queryName) as $row) {
            $h2 = 'RECHERCHE DES ALBUMS <br>Musicien: [ '.$row['Nom_Musicien'].' '.$row[utf8_decode('Prénom_Musicien')].' ]'.$suiteH2;
        }
        
        $query="SELECT DISTINCT Album.Code_Album, Album.Titre_Album, Album.Année_Album, Musicien.Code_Musicien
                FROM Genre INNER JOIN ((Pays INNER JOIN (Editeur INNER JOIN Album ON Editeur.Code_Editeur = Album.Code_Editeur) ON Pays.Code_Pays = Editeur.Code_Pays) INNER JOIN Musicien ON Pays.Code_Pays = Musicien.Code_Pays) ON Genre.Code_Genre = Album.Code_Genre
                WHERE Musicien.Code_Musicien='".$codeMusicien."' ".$queryKey;
                
        $nameInput='code_musicien';
        $valueInput=$codeMusicien;        
            
    }
    else if(isset($_GET['code_orchestre'])) {
        $codeOrchestre = $_GET['code_orchestre'];
        $parm = 'code_orchestre='.$codeOrchestre;
        
        $queryName="SELECT Orchestres.Code_Orchestre, Orchestres.Nom_Orchestre      
                    FROM Orchestres
                    WHERE Orchestres.Code_Orchestre='".$codeOrchestre."'";
        
        foreach($pdo->query($queryName) as $row) {
            $h2 = 'RECHERCHE DES ALBUMS <br>Orchestre: [ '.$row['Nom_Orchestre'].' ]'.$suiteH2;  
        }        
        
        $query="SELECT DISTINCT Album.Code_Album, Album.Titre_Album, Orchestres.Code_Orchestre
                FROM Orchestres INNER JOIN ((Genre INNER JOIN ((Pays INNER JOIN (Editeur INNER JOIN Album ON Editeur.Code_Editeur = Album.Code_Editeur) ON Pays.Code_Pays = Editeur.Code_Pays) INNER JOIN Musicien ON Pays.Code_Pays = Musicien.Code_Pays) ON Genre.Code_Genre = Album.Code_Genre) INNER JOIN Direction ON Musicien.Code_Musicien = Direction.Code_Musicien) ON Orchestres.Code_Orchestre = Direction.Code_Orchestre
                WHERE Orchestres.Code_Orchestre='".$codeOrchestre."' ".$queryKey;
                
        $nameInput='code_orchestre';
        $valueInput=$codeOrchestre;                    
    }
    else if(isset($_GET['code_instrument'])) 
    {
        $codeInstrument= $_GET['code_instrument'];
        $parm = 'code_instrument='.$codeInstrument;
        
        $queryName="SELECT Instrument.Code_Instrument, Instrument.Nom_Instrument
                                    FROM Instrument
                                    WHERE Instrument.Code_Instrument='".$codeInstrument."'";
        
        foreach($pdo->query($queryName) as $row) {
            $h2 = 'RECHERCHE DES ALBUMS <br>Instrument: [ '.$row['Nom_Instrument'].' ]'.$suiteH2;  
        }                                  
        
        $query="SELECT DISTINCT Album.Code_Album, Album.Titre_Album, Album.Année_Album, Orchestres.Code_Orchestre
                FROM Orchestres 
                INNER JOIN (((Pays 
                INNER JOIN (Editeur 
                INNER JOIN Album 
                ON Editeur.Code_Editeur = Album.Code_Editeur) 
                ON Pays.Code_Pays = Editeur.Code_Pays) 
                INNER JOIN Musicien 
                ON Pays.Code_Pays = Musicien.Code_Pays) 
                INNER JOIN Direction 
                ON Musicien.Code_Musicien = Direction.Code_Musicien) 
                ON Orchestres.Code_Orchestre = Direction.Code_Orchestre      
                WHERE Orchestres.Code_Orchestre='".$codeInstrument."'";
        
        $nameInput='code_instrument';
        $valueInput=$codeInstrument;  
    }
    else if(isset($_GET['code_genre']))
    {
        $codeGenre = $_GET['code_genre'];
        $parm = 'code_genre='.$codeGenre;
        $queryName="SELECT Code_Genre, Libellé_Abrégé
                    FROM Genre
                    WHERE Code_Genre='".$codeGenre."'";
                    
        foreach($pdo->query($queryName) as $row) {
            $h2 = 'RECHERCHE DES ALBUMS <br>Genre: [ '.$row[utf8_decode('Libellé_Abrégé')].' ]'.$suiteH2;
        }  
        $condition = "WHERE Code_Genre='". $codeGenre."' ".$queryKey; 
        
        $pagination=TRUE;
        $paramPagination='code_genre='.$codeGenre.'&';
        /*$query="SELECT DISTINCT Album.Titre_Album, Album.Code_Album, Genre.Code_Genre          
                FROM Genre INNER JOIN Album ON Genre.Code_Genre = Album.Code_Genre          
                    WHERE Genre.Code_Genre='".$code."'";
                    */ 
        $nameInput='code_genre';
        $valueInput=$codeGenre;         
    }
    else 
    {
        $pagination=TRUE;
        /*
        $query="SELECT DISTINCT Titre_Album, Code_Album        
                FROM Album
                ORDER BY Titre_Album";
                */
    }

?>