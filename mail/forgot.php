<?php

//namespaces de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendforgot($email_address) {

    // Load Composer's autoloader
    require 'vendor/autoload.php';

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);
    $db = new db;
    $req = $db->req("SELECT password, nickname FROM users WHERE email='$email_address'")->fetch();

    try {
        //Server settings
        $mail->SMTPDebug = 0;                                       // Enable verbose debug output
        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host       = 'smtp.free.fr';  // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'p5oc@free.fr';                     // SMTP username
        $mail->Password   = 'OpenClassrooms';                               // SMTP password
        $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 465;  

    //Recipients
    $mail->setFrom('p5oc@free.fr', 'Ballinity');
    $mail->addAddress($email_address, $req[1]);     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('no_reply@free.fr', 'NO REPLY');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Reinitialisation du mot de passe';
    $url = "http://localhost/P5/Blog/index.php?action=reset&hashed={$req[0]}";
    $mail->Body    = "Bonjour,<br><br>Veuillez cliquez sur ce lien pour réinitialiser votre mot de passe : <a href=\"$url\">$url</a><br><br>Cordialement.";
    //$mail->AltBody = $message."\nNuméro de téléphone : $phone";

    //Encoding
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';

    $mail->send();
        //echo 'Message has been sent';
        return true;
    } catch (Exception $e) {
    //return false;
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"."$email_address";
    }

}

function sendConfirmation($nickname) {
    // Load Composer's autoloader
    require 'vendor/autoload.php';

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);
    $db = new db;
    $email = $db->req("SELECT email FROM users WHERE nickname='$nickname'")->fetch();

    try {
        //Server settings
        $mail->SMTPDebug = 0;                                       // Enable verbose debug output
        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host       = 'smtp.free.fr';  // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'p5oc@free.fr';                     // SMTP username
        $mail->Password   = 'OpenClassrooms';                               // SMTP password
        $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 465;  

    //Recipients
    $mail->setFrom('p5oc@free.fr', 'Ballinity');
    $mail->addAddress($email[0], $nickname);     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('no_reply@free.fr', 'NO REPLY');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Mot de passe réinitialisé';
    $mail->Body    = "Bonjour $nickname,<br><br>Votre mot de passe a bien été réinitialisé<br><br>Cordialement.";
    //$mail->AltBody = $message."\nNuméro de téléphone : $phone";

    //Encoding
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';

    $mail->send();
        //echo 'Message has been sent';
        return true;
    } catch (Exception $e) {
    //return false;
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

?>

