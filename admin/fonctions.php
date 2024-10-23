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

function enregistrer_nouveau_article(){
    
    global $bdd;
    global $token;
    global $message;
    
    if (isset($_POST['ajouter_article'])) {
        if (empty($_POST['titre_article'])) {
            $message = "Le titre de l'article doit être une chaîne de caractères non vide";
        }elseif (empty($_POST['mot_cles_article'])) {
            $message = "Précisez au moins un mot clés de l'article!";
        }elseif (empty($_POST['contenu_article'])) {
            $message = "Le contenu de l'article doit être une chaîne de caractères non vide";
        }elseif(empty($_POST['nom_categorie_article'])) {
            $message = "Choisissez une catégorie a votre article";
        }elseif(empty($_FILES['image_article']['name'])) {
            $message = "Veuillez selectionner une image pour votre article de type jpeg, jpg ou png!";
        }else {
            if (preg_match("#jpeg|jpg|png#", $_FILES['image_article']['type'])) {
                $path  = "../img/images_articles/";
                
                $nouveau_nom_image = $token."_".$_FILES['image_article']['name'];
                move_uploaded_file($_FILES['image_article']['tmp_name'], $path.$nouveau_nom_image);
                $nom_categorie_article = $_POST['nom_categorie_article'];
                $requete_categorie = "SELECT * FROM categories WHERE nom_categorie='$nom_categorie_article'";
                $result_categorie = $bdd->query($requete_categorie);
                $data_categorie = $result_categorie->fetch(PDO::FETCH_ASSOC);
                
                $id_categorie = $data_categorie['id_categorie'];
                $aujoudhui = date("Y-m-d");
                $id_auteur = $_SESSION['id_utilisateur'];
                
                $requete = $bdd->prepare("INSERT INTO articles(titre_article, date_article, contenu_article, tags_article, image_article, id_categorie, id_auteur, status_article) VALUE(:titre_article, :date_article, :contenu_article, :tags_article, :image_article, :id_categorie, :id_auteur, :status_article)");
                
                $requete->bindValue(':titre_article', $_POST['titre_article']);
                $requete->bindValue(':date_article', $aujoudhui);
                $requete->bindValue(':contenu_article', $_POST['contenu_article']);
                $requete->bindValue(':tags_article', $_POST['mot_cles_article']);
                $requete->bindValue(':image_article', $nouveau_nom_image);
                $requete->bindValue(':id_categorie', $id_categorie);
                $requete->bindValue(':id_auteur', $id_auteur);
                $requete->bindValue(':status_article',  "Publie");
                
                $result = $requete->execute();
                
                if (!$result) {
                    $message = "Un problème est survenu et l'article n'a pas été soumi à la publication!";
                } else {
                    $message = "L'article a bien été soumi a la publication";
                }
            }else {
                $message = "L'image de l'article' doit être de type jpeg, jpg ou png et sa taille ne doit pas depasser 1MO";
            }
          
            
        }
    }
}


?>