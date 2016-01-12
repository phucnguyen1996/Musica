<?php
    include_once("layout_top.php")
?>
	    </div>
   </div>
</div>
<!--header end here-->
<!--contact start here-->
<div class="contact">
    <form method="post" action="login_validation.php">
		<div class="container">
			<div class="contact-top">
				<h2>VOS ACHATS</h2>
			</div>
            <div class="form-group"
                <div>
                    <?php
                    include 'config.php';
                    
                    if(isset($login) && !empty($login)) {
                        
                        $queryAbonne = "SELECT Achat.Code_Achat, Achat.Code_Enregistrement, Enregistrement.Titre
                                    FROM Enregistrement 
                                    INNER JOIN (Abonné INNER JOIN Achat 
                                    ON Abonné.Code_Abonné = Achat.Code_Abonné) 
                                    ON Enregistrement.Code_Morceau = Achat.Code_Enregistrement      
                                    WHERE Abonné.Login='".$login."'";
                                                
                        echo '<table class="table table-hover">'.
                             '  <thead>'.
                             '      <tr>'.
                             '          <th>Code Achat</th>'.
                             '          <th>Code Enregistrement</th>'.
                             '          <th>Titre</th>'.      
                             '      </tr>'.
                             '  </thead>'.
                             '  <tbody>';
                        foreach($pdo->query($queryAbonne) as $row) {
                            echo '  <tr>'.
                                 '      <td>'.$row['Code_Achat'].'</td>'.
                                 '      <td>'.$row['Code_Enregistrement'].'</td>'.
                                 '      <td>'.$row['Titre'].'</td>'.
                                 '  </tr>';
                        }
                        echo '  </tbody>'.
                             '</table>'; 
                    } else {
                        header('Location: login.php');
                    }         
                    
                    ?>
                </div>    
            </div>
		</div>	
    </form>
</div>
<!--contact end here-->
<?php
    include_once("layout_bot.php")
?>