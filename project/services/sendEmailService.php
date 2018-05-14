<?php


function sendEmail__FAKE($email, $subject, $txt, $from) {

}


function sendEmail($email, $subject, $txt, $from) {

    //TODO email sending through SMTP server
    $headers = "From: $from" . "\r\n";
    mail($email, $subject, $txt, $headers);
}


