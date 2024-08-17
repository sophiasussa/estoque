<?php

    if(session_status() === PHP_SESSION_NONE){
        SESSION_START();
    }

    if (!isset($_SESSION['id_usuario'])) {
        header("Location: views/login.php");
        exit();
    }
?>