<?php
    session_start();
    require_once "includes/header_login.php";
    require_once "includes/bdd.php";

    if (isset($_GET['modifier_compte']) && isset($_SESSION['id_utilisateur']) && $_GET['modifier_compte'] == $_SESSION['id_utilisateur']) {
        $id_utilisateur = $_SESSION['id_utilisateur'];
        $requete = "SELECT * FROM utilisateurs WHERE id_utilisateur=$id_utilisateur";
        
        $result = $bdd->query($requete);
        $ligne = $result->fetch(PDO::FETCH_ASSOC);
        
        $nom_utilisateur  = $ligne['nom_utilisateur'];
        $prenom_utilisateur  = $ligne['prenom_utilisateur'];
        $username  = $ligne['username'];
        $photo_profil  = $ligne['photo_utilisateur'];
        
        if (isset($_POST['modif_profil'])) {
            
            if  (empty($_POST['prenom']) || !ctype_alpha($_POST['prenom'])) {
                $message = "Votre prenom doit être une chaine de caractère alphabetiques !";
            }elseif(empty($_POST['nom']) || !ctype_alpha($_POST['nom'])) {
                $message = "Votre nom doit être une chaine de caractère alphabetiques !";
            }elseif (empty($_POST['username']) || !ctype_alnum($_POST['username'])) {
                $message = "Votre username doit être une chaine de caractère alphanumérique !";
            }else{
                
            require_once 'includes/bdd.php';
            
            $reqUsername = $bdd->prepare("SELECT * FROM utilisateurs WHERE username=:username");
            $reqUsername->bindvalue(':username', $_POST['username']);
            $reqUsername->execute();
            $resultUsername = $reqUsername->fetch();
            
            if ($resultUsername) {
                $message = "Le nom d'utilisateur saisi existe déjà, merci de choisir un autre nom d'utilisateur!";
            } else {
                $requete2 = $bdd->prepare("UPDATE utilisateurs SET nom_utilisateur=:nom, prenom_utilisateur=:prenom, username=:username, photo_utilisateur=:photo_profil WHERE id_utilisateur=:id_utilisateur");
                $requete2->bindvalue(':id_utilisateur', $id_utilisateur);
                $requete2->bindvalue(':nom', $_POST['nom']);
                $requete2->bindvalue(':prenom', $_POST['prenom']);
                $requete2->bindvalue(':username', $_POST['username']);
                
                if (empty($_FILES['photo_profil']['name'])) {
                    $requete2->bindvalue(':photo_profil', $photo_profil);
                } else {
                    
                    if (preg_match("#jpeg|png|jpg#", $_FILES['photo_profil']['type'])) {
                        
                        require_once "includes/token.php";
                        
                        $path = "img/photo_profil/";
                        $nouveau_nom_photo = $token."_".$_FILES['photo_profil']['name'];
                        move_uploaded_file($_FILES['photo_profil']['tmp_name'], $path.$nouveau_nom_photo);
                    } else {
                        $message = "La photo de profil doit être de type jpeg, jpg ou png!";
                    }
                    
                    $requete2->bindvalue(":photo_profil", $nouveau_nom_photo);
                }
                
                $result2 = $requete2->execute();
                
                if ($result2) {
                    header('location:profil.php');
                }else{
                    $message = "Votre profil n'a pas été modifié";
                }
                
            }
            
            
            }
            
        }


?>
<body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header">
                                    <?php 
                                        if (isset($message)) {
                                           echo $message;
                                        }
                                    ?>
                                    <h3 class="text-center font-weight-light my-4">Modifier mon profil</h3></div>
                                    <div class="card-body">
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputFirstName" type="text" name="prenom" value="<?= $prenom_utilisateur  ?>" />
                                                        <label for="inputFirstName">Prénom</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input class="form-control" id="inputLastName" type="text"  name="nom" value="<?= $nom_utilisateur  ?>" />
                                                        <label for="inputLastName">Nom</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputUserName" type="text" name="username" value="<?= $username  ?>" />
                                                        <label for="inputUserName">Nom d'utilisateur</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div>
                                                    <?php  echo "<img width=150  class='media-objeect' src='img/photo_profil/$photo_profil' alt='photo de profil'/>"; ?>
                                                        <label for="photo">Photo de profil</label>
                                                        <input type="hidden" name="MAXX_FILE_SIZE" value="1000000">
                                                        <input  id="photo" name="photo_profil" type="file" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid"><input type="submit" name="modif_profil" value="Modifier mon profil" class="btn btn-primary btn-block" /></div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
     <?php
             
    }
?>       
            
            <?php require_once "includes/footer.php"; ?>
            