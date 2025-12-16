<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Your main receiving email
  $receiving_email_address = 'northernexpress@gmail.com';  // Change if needed

  // CC email (this will receive a copy of every submission)
  $cc_email = 'wanahmadzaimwr99@gmail.com';

  $name    = strip_tags(trim($_POST["name"]));
  $email   = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
  $subject = strip_tags(trim($_POST["subject"]));
  $message = strip_tags(trim($_POST["message"]));

  if (empty($name) || empty($email) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo "Please fill all fields correctly.";
    exit;
  }

  $email_subject = "New Contact Form Submission: $subject";
  $email_body    = "You have received a new message from your website contact form.\n\n".
                   "Here are the details:\n".
                   "Name: $name\n".
                   "Email: $email\n".
                   "Subject: $subject\n".
                   "Message:\n$message";

  // Headers
  $headers = "From: $name <$email>\r\n";
  $headers .= "Reply-To: $email\r\n";
  $headers .= "CC: $cc_email\r\n";  // <-- This adds the CC
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

  if (mail($receiving_email_address, $email_subject, $email_body, $headers)) {
    http_response_code(200);
    echo "Thank you! Your message has been sent.";
  } else {
    http_response_code(500);
    echo "Oops! Something went wrong. Please try again later.";
  }
} else {
  http_response_code(403);
  echo "There was a problem with your submission.";
}
?>