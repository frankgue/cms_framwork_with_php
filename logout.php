<?php
    
    session_start();
    
    if ($_SESSION) {
        session_unset(); //Permet de detruire toutes les variables de session courantes
        session_destroy();
        
        header('location:index.php');
    } else {
        echo "Vous n'êtes pas connecté. !";
    }

?>