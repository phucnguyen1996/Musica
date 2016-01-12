<?php
session_start();

//add product to session or create new one
if(isset($_POST['item']) && is_array($_POST['item']))
{
    foreach($_POST['item'] as $id) {
        unset($_SESSION['cart'][$id]); 
    }
}

header('Location: cart.php');
?>