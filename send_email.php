<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);
 


    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'indhuindhuja13@gmail.com'; // Your Gmail address
        $mail->Password = 'asxcegmazzxhdayu'; // Your Gmail app password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Set the sender email dynamically from the form
        $mail->setFrom($email, $name); // Sender email set to user input email
        $mail->addAddress('indhujahitech044@gmail.com', 'Apartment website '); // Receiver email

        // Email content
        $mail->isHTML(false);
        $mail->Subject = 'Booking Request';
        $mail->Body = "Name: " . $name . "\n" . 
                      "Email: " . $email . "\n\n" . 
                      "Subject: " . $subject . "\n\n".
                      "Message:\n" . $message;

        // Send the email
        $mail->send();

        // Redirect to index.php after successful sending
        header("Location: index.php");
        exit();
    } catch (Exception $e) {
        echo "Failed to send message. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
