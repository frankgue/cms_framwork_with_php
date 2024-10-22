<?php

$dbn = 'mysql:dbname=webcms;host=localhost';
$user = 'root';
$password = '';

try {
    $bdd = new PDO($dbn, $user, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
} catch (PDOException $e) {
    echo "Echec lors de la connexion: ".$e->getMessage();
}