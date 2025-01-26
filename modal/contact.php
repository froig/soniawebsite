<?php

// Contacting email
$php_main_email = "info@soniamirzaei.com";

// Fetching and sanitizing values from POST
$php_name = htmlspecialchars(strip_tags($_POST['ajax_name'] ?? ''));
$php_email = filter_var($_POST['ajax_email'] ?? '', FILTER_SANITIZE_EMAIL);
$php_message = htmlspecialchars(strip_tags($_POST['ajax_message'] ?? ''));

// Validate email
if (filter_var($php_email, FILTER_VALIDATE_EMAIL)) {
    $php_subject = "Message from contact form";

    // To send HTML mail, the Content-type header must be set
    $php_headers = 'MIME-Version: 1.0' . "\r\n";
    $php_headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $php_headers .= 'From: no-reply@soniamirzaei.com' . "\r\n"; // Use a static sender email
    $php_headers .= 'Reply-To: ' . $php_email . "\r\n"; // Allow replying to the user's email

    // Email template
    $php_template = '
        <div style="padding:20px; font-family:Arial, sans-serif; color:#333;">
            <p>Hello ' . htmlspecialchars($php_name) . ',</p>
            <p>Thank you for contacting us. Below is a copy of your message:</p>
            <p><strong>Name:</strong> ' . htmlspecialchars($php_name) . '</p>
            <p><strong>Email:</strong> ' . htmlspecialchars($php_email) . '</p>
            <p><strong>Message:</strong><br>' . nl2br(htmlspecialchars($php_message)) . '</p>
            <p>We will contact you as soon as possible.</p>
        </div>';

    // Wrap message lines
    $php_sendmessage = wordwrap($php_template, 70);

    // Send email
    if (mail($php_main_email, $php_subject, $php_sendmessage, $php_headers)) {
        echo "<span class='contact_success'>Thank you! Your message has been sent successfully.</span>";
    } else {
        echo "<span class='contact_error'>Oops! Something went wrong. Please try again later.</span>";
    }
} else {
    echo "<span class='contact_error'>* Invalid email *</span>";
}

?>