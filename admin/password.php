<?php 

    require_once "includes/header_login.php"; 

    if (isset($_POST['forget_password'])) {
        if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ) {
            $message = "Rentrer une adresse email valide !";
        } else {
            require_once "includes/bdd.php";
            
            $requete = $bdd->prepare("SELECT * FROM utilisateurs WHERE email_utilisateur=:email AND role_utilisateur=:role_utilisateur");
            $requete->bindvalue(':email', $_POST['email']);
            $requete->bindvalue(':role_utilisateur', 'Admin');
            $requete->execute();
            $result = $requete->fetch();
            $nombre = $requete->rowCount();
            
            if ($nombre == 0) {
                $message = "L'adresse email saisie ne correspond a aucun administrateur!";
            } else {
                if ($result['validation_email_utilisateur'] != 1) {
                    require_once "includes/token.php";
                    
                    $update = $bdd->prepare("UPDATE utilisateurs SET token_utilisateur=:token WHERE email_utilisateur=:email AND role_utilisateur=:role_utilisateur");
                    $update->bindvalue(':token', $token);
                    $update->bindvalue(':email', $_POST['email']);
                    $update->bindvalue(':role_utilisateur', 'Admin');
                    $update->execute();
                    
                    require_once "includes/PHPMailer/sendmail.php"; 
                    
                } else {
                    require_once "includes/token.php";
                    
                    $update = $bdd->prepare("UPDATE utilisateurs SET token_utilisateur=:token WHERE email_utilisateur=:email AND role_utilisateur=:role_utilisateur");
                    $update->bindvalue(':token', $token);
                    $update->bindvalue(':email', $_POST['email']);
                    $update->bindvalue(':role_utilisateur', 'Admin');
                    $update->execute();
                    
                    require_once "includes/PHPMailer/sendmail_reinitialisation.php";
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
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header">
                                    <?php 
                                        if (isset($message)) {
                                           echo $message;
                                        }
                                    ?>
                                    <h3 class="text-center font-weight-light my-4">Réinitialisation du mot de passe</h3></div>
                                    <div class="card-body">
                                        <div class="small mb-3 text-muted">Veuillez rentrer votre adresse Email.</div>
                                        <form action="password.php" method="post">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="email"  name="email"  />
                                                <label for="inputEmail">Address Email</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="login.php">Connexion</a>
                                                <input type="submit" name="forget_password" class="btn btn-primary" value="Reinitialiser mot de passe" />
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
           <?php require_once "includes/footer.php" ?>