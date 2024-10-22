<?php

    function enregistrer_categorie(){
        
        global $bdd;
        global $message;
        preg_match("/([^A-Za-z0-9]\s)/", $_POST['nom_categorie'], $result);
        if (empty($_POST['nom_categorie']) || !empty($result)) {
            $message = "Le nom de la catégorie doit être une chaîne de caractères alphanumérique!";
        }else{
            $requete = $bdd->prepare("INSERT INTO categories(nom_categorie) VALUES(:nom_categorie)");
            $requete->bindvalue(":nom_categorie", $_POST['nom_categorie']);
            $result = $requete->execute();
            
            if (!$result) {
                $message = "Un problème est survenu, la catégorie n'a pas été enregistrée!";
            } else {
                $message = "La catégorie a bien été enregistrée.";
            }
        }
        
    }
    
    function supprimer_categorie(){
        global $bdd;
        global $message2;
        
        $id_categorie_supp = $_GET['supprimer'];
        $req = "DELETE FROM categories WHERE id_categorie='$id_categorie_supp'";
        
        $result1 = $bdd->exec($req);
        
        if (!$result1) {
            $message2 = "Un problème est survenu, la catégorie n'a pas été supprimée!";
        } else {
            $message2 = "La catégorie a bien été supprimer!";
        }
    }

    function afficher_categories(){
        
        global $bdd;
        
        $requete = "SELECT * FROM categories ORDER BY id_categorie ASC";
        $result = $bdd->query($requete);
        
        if (!$result) {
            $message1 = "La récupération des données a rencontrée un problème!";
            echo "<center style='color:red;'>".$message1."</center>";
        } else {
            while ($line = $result->fetch(PDO::FETCH_ASSOC)) {
               $nom_categorie = $line['nom_categorie'];
               $id_categorie = $line['id_categorie'];
               echo "<tr>
            <td>$nom_categorie</td>
            <td><a href='categories.php?supprimer=$id_categorie'>Supprimer</a></td>
            <td><a href='categories.php?modifier=$id_categorie'>Modifier</a></td>
        </tr>";
            }
        }
        
    }
function recuperer_categorie_modif(){
    
    global $bdd;
    global $id_categorie_modif;
    global $data;
    
    $id_categorie_modif = $_GET['modifier'];
                        
    $req2 = "SELECT * FROM categories WHERE id_categorie='$id_categorie_modif'";
    $result2 = $bdd->query($req2);
    $data = $result2->fetch(PDO::FETCH_ASSOC);
    
    $nom_categorie = $data['nom_categorie'];
}

function modifier_categorie(){
    
    global $bdd;
    global $message3;
    preg_match("/([^A-Za-z0-9]\s)/", $_POST['nom_categorie_modif'], $result);
    if (empty($_POST['nom_categorie_modif']) || !empty($result)) {
        $message3 = "Le nom de la catégorie doit être une chaîne de caractères alphanumérique!";
    }else{
        $req3 = $bdd->prepare("UPDATE categories SET nom_categorie =:nom_categorie_modif WHERE id_categorie=:id_categorie_modif");
        $req3->bindvalue(":nom_categorie_modif", $_POST['nom_categorie_modif']);
        $req3->bindvalue(":id_categorie_modif", $_POST['id_categorie_modif']);
        $result3 = $req3->execute();
        
        if (!$result3) {
            $message3 = "Un problème est survenu, la catégorie n'a pas été modifiée!";
        } else {
            $message3 = "La catégorie a bien été enregistrée.";
        }
    }
}


?>