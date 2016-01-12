<?php
    session_start();
    include_once("config.php");
    //current URL of the Page. cart_update.php redirects back to this URL
    $current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
?>
<?php
    include_once("layout_top.php");
?>		
	    </div>
   </div>
</div>
<!--header end here-->
<div id="products-wrapper">
 <h1>View Cart</h1>
 <div class="view-cart">
 	<?php
    $current_url = base64_encode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	if(isset($_SESSION["products"]))
    {
	    $total = 0;
		echo '<form method="post" action="cart_update.php">';
		echo '<ul>';
		$cart_items = 0;
		foreach ($_SESSION["products"] as $cart_itm)
        {
           $product_code = $cart_itm["code_morceau"];
		   $results = $mysqli->query("SELECT Titre, Prix FROM Enregistrement WHERE Code_Morceau='$product_code' LIMIT 1");
		   $obj = $results->fetch_object();
		   
		    echo '<li class="cart-itm">';
			echo '<span class="remove-itm"><a href="cart_update.php?removep='.$cart_itm["code_morceau"].'&return_url='.$current_url.'">&times;</a></span>';
			echo '<div class="p-price">'.$currency.$obj->Prix.'</div>';
            echo '<div class="product-info">';
			echo '<h3>'.$obj->Titre.' (Code :'.$product_code.')</h3> ';
			echo '</div>';
            echo '</li>';
			$total = ($total + $cart_itm["price"]);

			echo '<input type="hidden" name="item_name['.$cart_items.']" value="'.$obj->Titre.'" />';
			echo '<input type="hidden" name="item_code['.$cart_items.']" value="'.$product_code.'" />';
			$cart_items ++;
			
        }
    	echo '</ul>';
		echo '<span class="check-out-txt">';
		echo '<strong>Total : '.$total.'</strong>  ';
		echo '</span>';
		echo '</form>';
		
    }else{
		echo 'Your Cart is empty';
	}
	
    ?>
    </div>
</div>
<?php
    include_once("layout_bot.php");
?>