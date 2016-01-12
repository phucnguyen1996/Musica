<?php
session_start();

if(!isset($_COOKIE['login']) || empty($_COOKIE['login'])) {
    header ("Location: login.php");
}
else {
    //add product to session or create new one
    if(isset($_POST['code_item']) && !empty($_POST['code_item']))
    {
        $code_item = $_POST['code_item'];
    
        if(!isset($_SESSION['cart'])) {
            $_SESSION['cart']=array();
        }
        array_push($_SESSION['cart'],$code_item);
    }
    header ("Location: cart.php");
}
?>