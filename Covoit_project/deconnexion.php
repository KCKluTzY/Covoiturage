<?php
    session_start();
    unset($_SESSION['id']);
    unset($_SESSION['nom']);
    unset($_SESSION['prenom']);
    unset($_SESSION['email']);
    $_SESSION['logged'] = false;
    session_destroy();
    header("location:index.php");
?>