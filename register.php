<?php 
    require_once "includes/header_register.php";
?>
<?php

    if (isset($_POST['inscription'])) {
        if  (empty($_POST['prenom']) || !ctype_alpha($_POST['prenom'])) {
            $message = "Votre prenom doit être une chaine de caractère alphabetiques !";
        }elseif(empty($_POST['nom']) || !ctype_alpha($_POST['nom'])) {
            $message = "Votre nom doit être une chaine de caractère alphabetiques !";
        }elseif(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $message = "Rentrer une adresse email valide !";
        }elseif (empty($_POST['password']) || $_POST['password'] != $_POST['confirm_password']) {
            $message = "Rentrer un mot de passe valide !";
        }elseif (empty($_POST['username']) || !ctype_alnum($_POST['username'])) {
            $message = "Votre username doit être une chaine de caractère alphanumérique !";
        }else{
          
            require_once 'includes/bdd.php';
            
            $reqUsername = $bdd->prepare("SELECT * FROM utilisateurs WHERE username=:username");
            $reqUsername->bindvalue(':username', $_POST['username']);
            $reqUsername->execute();
            $resultUsername = $reqUsername->fetch();
            
            $reqEmail = $bdd->prepare("SELECT * FROM utilisateurs WHERE email_utilisateur=:email");
            $reqEmail->bindvalue(':email', $_POST['email']);
            $reqEmail->execute();
            $resultEmail = $reqEmail->fetch();
            
            if ($resultUsername) {
                $message = "Le nom d'utilisateur existe déjà, choisissez un autre nom d'utilisateur";
            } elseif($resultEmail) {
                $message = "Un compte est déjà attaché a l'adresse email saisie";
            }else{                
                $requete = $bdd->prepare("INSERT INTO utilisateurs(nom_utilisateur, prenom_utilisateur, username, email_utilisateur, password_utilisateur, token_utilisateur, photo_utilisateur) VALUES (:nom, :prenom, :username, :email, :password, :token, :photo_profil)");
                
                $requete->bindvalue(":nom", $_POST['nom']);
                $requete->bindvalue(":prenom", $_POST['prenom']);
                $requete->bindvalue(":username", $_POST['username']);
                $requete->bindvalue(":email", $_POST['email']);
                $requete->bindvalue(":password", $_POST['password']);
                $requete->bindvalue(":token", "aaaa");
                if (empty($_FILES['photo_profil']['name'])) {
                    $photo_profil = "avatar_defaut.png";
                    $requete->bindvalue(":photo_profil", $photo_profil);
                }else{
                    if (preg_match("#jpeg|png|jpg#", $_FILES['photo_profil']['type'])) {
                        $path = "img/photo_profil/";
                        move_uploaded_file($_FILES['photo_profil']['name'], $path.$_FILES['photo_profil']['name']);
                    } else {
                        $message = "La photo de profil doit être de type jpeg, jpg ou png!";
                    }
                    
                    $requete->bindvalue(":photo_profil", $_FILES['photo_profil']['name']);
                }
                
                $requete->execute();
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
                                    <h3 class="text-center font-weight-light my-4">Creer un compte</h3></div>
                                    <div class="card-body">
                                        <form action="register.php" method="post" enctype="multipart/form-data">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputFirstName" type="text" name="prenom" />
                                                        <label for="inputFirstName">Prénom</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input class="form-control" id="inputLastName" type="text"  name="nom" />
                                                        <label for="inputLastName">Nom</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="email" name="email" />
                                                <label for="inputEmail">Adresse Email</label>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputPassword" type="password"  name="password" />
                                                        <label for="inputPassword">Mot de passe</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputPasswordConfirm" type="password"  name="confirm_password" />
                                                        <label for="inputPasswordConfirm">Confirmation mot de passe</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputUserName" type="text" name="username" />
                                                        <label for="inputUserName">Nom d'utilisateur</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div>
                                                        <label for="photo">Photo de profil</label>
                                                        <input type="hidden" name="MAXX_FILE_SIZE" value="1000000">
                                                        <input  id="photo" name="photo_profil" type="file" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid"><input type="submit" name="inscription" value="Créer un compte" class="btn btn-primary btn-block" /></div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="login.php">Avez-vous un comptet? Connectez-vous</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            
            
            <?php require_once "includes/footer.php"; ?>
            