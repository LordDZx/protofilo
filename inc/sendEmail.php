<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$siteOwnersEmail = 'sinperrr3ddd@gmail.com';

if ($_POST) {
    $name = trim(stripslashes($_POST['contactName']));
    $email = trim(stripslashes($_POST['contactEmail']));
    $subject = trim(stripslashes($_POST['contactSubject']));
    $contact_message = trim(stripslashes($_POST['contactMessage']));

    $error = array();

    // Validate input data
    if (!validateName($name)) {
        $error['name'] = "Please enter a valid name.";
    }
    if (!validateEmail($email)) {
        $error['email'] = "Please enter a valid email address.";
    }
    if (strlen($contact_message) < 15) {
        $error['message'] = "Please enter your message. It should have at least 15 characters.";
    }

    // Set subject
    if ($subject == '') {
        $subject = "Contact Form Submission";
    }

    // Set message
    $message = "Email from: ". $name. "\n";
    $message.= "Email address: ". $email. "\n";
    $message.= "Message: \n";
    $message.= $contact_message;
    $message.= "\n ----- \n This email was sent from your site's contact form. \n";

    // Set From: header
    $from = filter_var($email, FILTER_VALIDATE_EMAIL)? $email : $siteOwnersEmail;

    // Email headers
    $headers = "From: ". $from. "\r\n";
    $headers.= "MIME-Version: 1.1\r\n";
    $headers.= "Content-Type: text/plain; charset=UTF-8\r\n";

    if (!$error) {
        $mail = mail($siteOwnersEmail, $subject, $message, $headers);

        if ($mail) {
            echo "OK";
        } else {
            echo "Something went wrong. Please try again.";
            error_log("Email sending failed: ". $subject. " - ". $message);
        }
    } else {
        $response = '';
        foreach ($error as $err) {
            $response.= $err. "<br />\n";
        }
        echo $response;
    }
}

function validateName($name) {
    return preg_match('/^[a-zA-Z ]+$/', $name);
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

?>
