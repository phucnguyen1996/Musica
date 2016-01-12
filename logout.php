<?php
    if (isset($_SERVER['HTTP_COOKIE']))
    {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach($cookies as $cookie)
        {
            $mainCookies = explode('=', $cookie);
            $name = trim($mainCookies[0]);
            setcookie($name, '', time()-700000);
            setcookie($name, '', time()-700000, '/');
        }
    }
    session_start();

    if(isset($_SESSION['cart'])) {
        unset($_SESSION['cart']);
    }
    
    header ("Location: index.php");
    exit();
?>