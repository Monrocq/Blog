<?php

//namespaces de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendforgot($email_address, $expiration) {

    // Load Composer's autoloader
    require 'vendor/autoload.php';

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);
    $db = new db;
    $query = $db->query("SELECT password, nickname FROM users WHERE email='$email_address'")->fetch();

    try {
        //Server settings
        $mail->SMTPDebug = 0;                                       // Enable verbose debug output
        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host       = 'smtp.free.fr';  // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'p5oc@free.fr';                     // SMTP username
        $mail->Password   = '************';                               // SMTP password
        $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 465;  

    //Recipients
    $mail->setFrom('p5oc@free.fr', 'Ballinity');
    $mail->addAddress($email_address, $query[1]);     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('no_reply@free.fr', 'NO REPLY');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');

    //Création de la clé
    $key = hash('sha256', $expiration);

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Reinitialisation du mot de passe';
    $url = "http://localhost/P5/Blog/index.php?action=reset&hashed={$query[0]}&key=$key";
    $mail->Body    = "Bonjour <strong>{$query[1]}</strong>,<br><br>Veuillez cliquez sur ce lien pour réinitialiser votre mot de passe : <a href=\"$url\">$url</a><br>Attention il expirera dans deux heures!<br><br>Cordialement.";
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
    $email = $db->query("SELECT email FROM users WHERE nickname='$nickname'")->fetch();

    try {
        //Server settings
        $mail->SMTPDebug = 0;                                       // Enable verbose debug output
        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host       = 'smtp.free.fr';  // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'p5oc@free.fr';                     // SMTP username
        $mail->Password   = 'O***C*********';                               // SMTP password
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

