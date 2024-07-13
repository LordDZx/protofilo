<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$siteOwnersEmail = 'sinperrr3ddd@gmail.com';

if ($_POST) {
    $name = trim(stripslashes($_POST['contactName']));
    $email = trim(stripslashes($_POST['contactEmail']));
    $subject = trim(stripslashes($_POST['contactSubject']));
    $contact_message = trim(stripslashes($_POST['contactMessage']));

    // Check Name
    if (strlen($name) < 2) {
        $error['name'] = "Please enter your name.";
    }
    // Check Email
    if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
        $error['email'] = "Please enter a valid email address.";
    }
    // Check Message
    if (strlen($contact_message) < 15) {
        $error['message'] = "Please enter your message. It should have at least 15 characters.";
    }
    // Subject
    if ($subject == '') {
        $subject = "Contact Form Submission";
    }

    // Set Message
    $message = "Email from: " . $name . "\n";
    $message .= "Email address: " . $email . "\n";
    $message .= "Message: \n";
    $message .= $contact_message;
    $message .= "\n ----- \n This email was sent from your site's contact form. \n";

    // Set From: header
    $from = $name . " <" . $email . ">";

    // Email Headers
    $headers = "From: " . $from . "\r\n";
    $headers .= "MIME-Version: 1.1\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    if (!$error) {
        $mail = mail($siteOwnersEmail, $subject, $message, $headers);

        if ($mail) {
            echo "OK";
        } else {
            echo "Something went wrong. Please try again.";
            error_log("Email sending failed: " . $subject . " - " . $message);
        }
    } else {
        $response = (isset($error['name'])) ? $error['name'] . "<br /> \n" : null;
        $response .= (isset($error['email'])) ? $error['email'] . "<br /> \n" : null;
        $response .= (isset($error['message'])) ? $error['message'] . "<br />" : null;

        echo $response;
    }
}

?>
