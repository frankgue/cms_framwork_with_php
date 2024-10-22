<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'gkfcsolution@gmail.com';
$mail->Password = "jyxp slsh kpoq zmcy";
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->Charset = "utf-8";
$mail->setFrom("gkfcsolution@gmail.com","FrankGUEKENG");
$mail->addAddress($_POST['email'], "FrankGUEKENG");
$mail->isHTML(true);

$mail->Subject = "Réinitialisation du mot de passe";
$mail->Body = 'Afin de reinitialiser votre mot de passe , merci de cliquer sur le lien suivant:<a href="localhost/webcms/new_password.php?token='.$token.'&email='.$_POST['email'].'">Réinitialiser mot de passe</a>';

$mail->SMTPDebug = 0;

if($mail->send()){
    echo "Un mail vient dêtre envoyé a votre adresse email pour réinitialiser votre mot de passe";
    $message = "Un mail vient dêtre envoyé a votre adresse email pour réinitialiser votre mot de passe";
} else {
    $message = "Erreur lors de l'envoi de l'email: " . $mail->ErrorInfo;
    echo "Erreur lors de l'envoi de l'email: " . $mail->ErrorInfo;
}