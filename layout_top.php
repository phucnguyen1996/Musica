<!DOCTYPE HTML>
<html>
<head>
<meta charset=utf-8 />
<title>Musica - Éducation musicale pour tout le monde</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
<!--favicon-->
<link rel="shortcut icon" type="image/png" href="http://example.com/bass-clef.ico">
<link rel="shortcut icon" type="image/png" href="images/bass-clef.ico"/>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-1.11.0.min.js"></script>
<!-- Custom Theme files -->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<link href="css/style-item.css" rel="stylesheet" type="text/css" media="all"/>
<!-- Custom Theme files -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Study Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!--Google Fonts-->
<!-- start-smoth-scrolling -->
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script>
	<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(".scroll").click(function(event){		
					event.preventDefault();
					$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
				});
			});
	</script>
<!-- //end-smoth-scrolling -->
<script src="js/menu_jquery.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>       
</head>
<body>
<div class="header1">
	<div class="container">
        <div class="header-main">
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="index.php">MUSICA</a>
                    </div>
                    <div>
                        <ul class="nav navbar-nav">
                            <li><a href="index.php">Index</a></li>
                            <li><a href="about.php">A propos</a></li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Albums
                                <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="albums.php">Tous les albums</a></li>
                                    <li class="divider"></li>
                                    <li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Genre</a>
                                        <ul class="dropdown-menu">
                                            <?php
                                                include 'config.php';
                                                $query = 'SELECT DISTINCT Genre.Code_Genre, Genre.Libellé_Abrégé 
                                                          FROM Genre
                                                          INNER JOIN Album
                                                          ON Genre.Code_Genre=Album.Code_Genre
                                                          ORDER BY Genre.Libellé_Abrégé';
                                                foreach ($pdo->query($query) as $row) {
                                                    echo '<li><a href="albums.php?code_genre='.$row['Code_Genre'].'">'.$row[utf8_decode('Libellé_Abrégé')].'</a></li>';   
                                                }
                                            ?> 
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Musiciens
                                <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="musiciens.php">Tous les musiciens</a></li>
                                    <li class="divider"></li>
                                    <li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Pays</a>
                                        <ul class="dropdown-menu">
                                            <?php
                                                include 'config.php';
                                                $query = 'SELECT DISTINCT Pays.Nom_Pays, Pays.Code_Pays
                                                          FROM Pays 
                                                          INNER JOIN Musicien 
                                                          ON Pays.Code_Pays = Musicien.Code_Pays
                                                          ORDER BY Pays.Nom_Pays';
                                                foreach ($pdo->query($query) as $row) {
                                                    echo '<li><a href="musiciens.php?code_pays='.$row['Code_Pays'].'">'.$row[utf8_decode('Nom_Pays')].'</a></li>';   
                                                }
                                            ?> 
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Orchestres
                                <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="orchestres.php">Tous les orchestres</a></li>
                                    <li class="divider"></li>
                                    <li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Instruments</a>
                                        <ul class="dropdown-menu">
                                            <?php
                                                include_once 'config.php';
                                                $query = 'SELECT DISTINCT Instrument.Code_Instrument, Instrument.Nom_Instrument 
                                                            FROM (((Orchestres INNER JOIN Direction ON Orchestres.Code_Orchestre = Direction.Code_Orchestre)
                                        INNER JOIN Musicien ON Musicien.Code_Musicien = Direction.Code_Musicien) 
                                        INNER JOIN Interpréter ON Musicien.Code_Musicien = Interpréter.Code_Musicien) 
                                        INNER JOIN Instrument ON Instrument.Code_Instrument = Interpréter.Code_Instrument 
                                                            ORDER BY Instrument.Nom_Instrument';
                                                foreach ($pdo->query($query) as $row) {
                                                    echo '<li><a href="orchestres.php?code_instrument='.$row['Code_Instrument'].'">'.$row['Nom_Instrument'].'</a></li>';   
                                                }
                                            ?> 
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="instruments.php">Instruments</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <?php
                                if(!isset($_COOKIE['login']) || $_COOKIE['login']=="" )  { 
                            ?>
                                    <li><a href="register.php"><span class="glyphicon glyphicon-user"></span> S'inscrire</a></li>
                                    <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Connexion</a></li>
                             <?php
                                } else {
                                    $login = $_COOKIE['login'] ;
                             ?>
                                    <li class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Bonjour, <?php echo $login ?>
                                        <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <?php
                                                $query = "SELECT Login, Credit FROM Abonné WHERE Login='".$login."'";
                                                
                                                foreach($pdo->query($query) as $row) {
                                                    echo '<li><a href="#">Credit: '.$row['Credit'].'</a></li>';
                                                }
                                            ?>
                                            <li><a href="credit.php">Recharger credit</a></li>
                                            <li><a href="cart.php">Mon panier</a></li>
                                            <li><a href="achat.php">Mes achats</a></li>
                                            <li><a href="logout.php">Déconnexion</a></li>
                                        </ul>
                                    </li>
                             <?php       
                                }
                             ?>
                        </ul>
                    </div>
                </div>
            </nav>