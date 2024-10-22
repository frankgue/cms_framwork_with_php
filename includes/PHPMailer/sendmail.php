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

$mail->Subject = "Confirmation d'email";
$mail->Body = 'Afin de valider votre adresse Email, merci de cliquer sur le lien suivant:<a href="localhost/webcms/verification.php?token='.$token.'&email='.$_POST['email'].'">Confirmation email</a>';

$mail->SMTPDebug = 0;

if($mail->send()){
    echo "Un mail vient dêtre envoyé a votre adresse email pour confirmer la creation de votre compte";
    $message = "Un mail vient dêtre envoyé a votre adresse email pour confirmer la creation de votre compte";
} else {
    $message = "Erreur lors de l'envoi de l'email: " . $mail->ErrorInfo;
    echo "Erreur lors de l'envoi de l'email: " . $mail->ErrorInfo;
}