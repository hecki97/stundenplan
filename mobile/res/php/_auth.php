<?php
    session_start();
    $host = $_SERVER['SERVER_NAME'];

    if(!isset($_SESSION["username"])) 
   { 
        header("Location: http://$host/stundenplan/mobile/login.php");
        exit;
   } 
?>