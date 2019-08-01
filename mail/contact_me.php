<?php
// Check for empty fields
if(empty($_POST['name'])  		||
   empty($_POST['email']) 		||
   empty($_POST['phone']) 		||
   empty($_POST['message'])	||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
	echo "No arguments Provided!";
	return false;
   }

$name = strip_tags(htmlspecialchars($_POST['name']));
$email_address = strip_tags(htmlspecialchars($_POST['email']));
$phone = strip_tags(htmlspecialchars($_POST['phone']));
$message = strip_tags(htmlspecialchars($_POST['message']));

//namespaces de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
   //Server settings
   $mail->SMTPDebug = 0;                                       // Enable verbose debug output
   $mail->isSMTP();                                            // Set mailer to use SMTP
   $mail->Host       = 'smtp.free.fr';  // Specify main and backup SMTP servers
   $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
   $mail->Username   = 'indian.express@free.fr';                     // SMTP username
   $mail->Password   = '********';                               // SMTP password
   $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
   $mail->Port       = 465;   

   //Recipients
   $mail->setFrom($email_address, $name);
   $mail->addAddress('adel_98@hotmail.fr', 'Webmaster');     // Add a recipient
   //$mail->addAddress('ellen@example.com');               // Name is optional
   $mail->addReplyTo($email_address, $name);
   $mail->addCC('cc@example.com');
   $mail->addBCC('bcc@example.com');

   // Content
   $mail->isHTML(true);                                  // Set email format to HTML
   $mail->Subject = 'Prise de contact depuis le formulaire';
   $mail->Body    = $message."<br>Numéro de téléphone : $phone";
   $mail->AltBody = $message."\nNuméro de téléphone : $phone";

   //Encoding
   $mail->CharSet = 'UTF-8';
   $mail->Encoding = 'base64';

	
// Create the email and send the message | OLD VERSION
//$to = 'adel_98@hotmail.fr'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
//$email_subject = "Website Contact Form:  $name";
//$email_body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email_address\n\nPhone: $phone\n\nMessage:\n$message";
//$headers = "From: noreply@yourdomain.com\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
//$headers .= "Reply-To: $email_address";	
//mail($to,$email_subject,$email_body,$headers);

$mail->send();
    //echo 'Message has been sent';
    return true;
} catch (Exception $e) {
   return false;
    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

			
?>

