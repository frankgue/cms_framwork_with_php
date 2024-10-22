<?php

    if (isset($_POST['connexion'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        require_once "includes/bdd.php";
        
        $requete  = $bdd->prepare("SELECT * FROM utilisateurs WHERE email_utilisateur=:email AND role_utilisateur=:role_utilisateur");
        $requete->execute(array("email"=> $email, 'role_utilisateur'=>'Admin'));
        $result = $requete->fetch();
        
        if (!$result) {
            $message = "Merci de saisir une adresse email valide";
            
        }elseif ($result['validation_email_utilisateur'] == 0) {
            require_once "includes/token.php";
            
            $update = $bdd->prepare("UPDATE utilisateurs SET token_utilisateur=:token WHERE email_utilisateur=:email");
            $update->bindValue(':token', $token);
            $update->bindValue(':email', $email);
            $update->execute();
             
            require_once "includes/PHPMailer/sendmail.php";
        } else {
            
            $passwordIsOk = password_verify($_POST['password'], $result['password_utilisateur']);
            
            if ($passwordIsOk) {
                session_start();
                
                $_SESSION['id_utilisateur'] = $result['id_utilisateur'];
                $_SESSION['username'] = $result['username'];
                $_SESSION['email_utilisateur'] = $email;
                $_SESSION['role_utilisateur'] = $result['role_utilisateur'];
                $_SESSION['photo_utilisateur'] = $result['photo_utilisateur'];
                
                if (isset($_POST['sesouvenir'])) {
                    setcookie("email", $_POST['email'], time()+3600*24*365);
                    setcookie("password", $_POST['password'], time()+3600*24*365);
                }else{
                    if ($_COOKIE['email']) {
                        setcookie($_COOKIE['email'], "");
                    }
                    
                    if ($_COOKIE['password']) {
                        setcookie($_COOKIE['password'], "");
                    }
                    
                }
                
                header('location:index.php');
            } else {
                $message = "Veuillez saisir un mot de passe valide";
            }
            
            
        }
    }

?>

<?php require_once 'includes/header_login.php'; ?>


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
                                    <h3 class="text-center font-weight-light my-4">Connexion</h3></div>
                                    <div class="card-body">
                                        <form action="login.php" method="post">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="email" name="email" value="<?php if(isset($_COOKIE['email'])) echo $_COOKIE['email'] ?>"  />
                                                <label for="inputEmail">adresse Email</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="password" id="inputPassword" type="password" value="<?php if(isset($_COOKIE['password'])) echo $_COOKIE['password']  ?>" />
                                                <label for="inputPassword">Mot de passe </label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" name="sesouvenir" />
                                                <label class="form-check-label" for="inputRememberPassword">Se souvenir de moi</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="password.php">Mot de passe oublié?</a>
                                                <input type="submit" value="Connexion" name="connexion" class="btn btn-primary" />
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <?php require_once('includes/footer.php'); ?>