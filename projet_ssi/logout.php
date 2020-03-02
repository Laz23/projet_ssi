<?php
    session_save_path("/home/laz/projet_ssi/sess_data");
    session_start();
    unset($_SESSION['connecte']);
    
    unset($_SESSION["user"]); 
    unset($_SESSION["pwd"]); 
    unset($_SESSION["role"]); 

    /*unset($_COOKIE['user']);
    unset($_COOKIE['pwd']);
    unset($_COOKIE['role']);*/
    //unset($_COOKIE["user"]);
    //session_destroy();
    header("Location: /se_connecter.php");