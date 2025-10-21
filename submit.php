<?php
// Set your recipient email address here
$receiving_email_address = 'talonitsolutions@gmail.com'; 

// --- Configuration End ---

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Sanitize and validate the inputs
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (empty($name) || empty($email) || empty($subject) || empty($message) || !$email) {
        // Simple error handling for missing or invalid fields
        // In a real application, you'd redirect back with a specific error message.
        header('Location: Contact.html?status=error_invalid_fields');
        exit;
    }

    // 2. Prepare the email content
    $email_subject = "New Contact Form Submission: " . $subject;
    $email_body = "You have received a new message from your website contact form.\n\n";
    $email_body .= "Name: " . $name . "\n";
    $email_body .= "Email: " . $email . "\n";
    $email_body .= "Subject: " . $subject . "\n\n";
    $email_body .= "Message:\n" . $message . "\n";

    // 3. Set the headers
    $headers = 'From: Website Contact <no-reply@yourdomain.com>' . "\r\n" .
               'Reply-To: ' . $email . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    // 4. Send the email
    if (mail($receiving_email_address, $email_subject, $email_body, $headers)) {
        // Success: Redirect back to the contact page with a success message
        header('Location: Contact.html?status=success');
    } else {
        // Failure: Redirect back with a failure message
        header('Location: Contact.html?status=error_mail_fail');
    }
    
} else {
    // If someone tries to access the script directly, redirect them
    header('Location: Contact.html');
}
exit;
?>