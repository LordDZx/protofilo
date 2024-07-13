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

    // Check Name
    if (strlen($name) < 2) {
        $error['name'] = "Please enter your name.";
    }
    // Check Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
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
    $message = array();
    $message[] = "Email from: ". $name;
    $message[] = "Email address: ". $email;
    $message[] = "Message:";
    $message[] = $contact_message;
    $message[] = "-----";
    $message[] = "This email was sent from your site's contact form.";
    $message = implode("\n", $message);

    // Set From: header
    $from = $email;

    // Email Headers
    $headers = array();
    $headers[] = "From: ". $from;
    $headers[] = "MIME-Version: 1.1";
    $headers[] = "Content-Type: text/plain; charset=UTF-8";
    $headers = implode("\r\n", $headers);

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

?>
