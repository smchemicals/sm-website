<?php
if (isset($_POST['submit'])) {
    // Retrieve form data
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $job = $_POST['job'];
    $message = $_POST['message'];

    // Email details
    $to = 'smchemicalsofficial@gmail.com';
    $subject = "Job application from: $firstName $lastName for $job";
    $from = $_POST['email'];

    // Email headers
    $headers = "From: $from\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $headers .= "X-Priority: 1\r\n";
    $headers .= "X-Mailer: PHP" . phpversion() . "\r\n";

    // Email body
    $body = "Job Application\r\n";
    $body .= "First Name: $firstName\r\n";
    $body .= "Last Name: $lastName\r\n";
    $body .= "Phone: $phone\r\n";
    $body .= "Email: $email\r\n";
    $body .= "Applying for: $job\r\n";
    $body .= "Message:\r\n$message\r\n";

    // Send acknowledgment email
    $ackSubject = 'Acknowledgment - Job Application';
    $ackMessage = "Dear $firstName,\r\n\r\nThank you for your job application. We have received your application and will review it soon.\r\n\r\nBest regards,\r\nSM Chemicals\r\n \r\nAddress:\r\nHouse No 2-2-1137/5/B \r\nNew Nallakunta, Hyderabad - 500 044, T.S\r\nMobile: +91 - 9246181170 \r\n \r\nE-Mail: smchemicals@gmail.com, smchemicalsofficial@gmail.com \r\nVisit us at http://www.smchemicals.co.in";
    $ackHeaders = "From: $from\r\n";
    $ackHeaders .= "Reply-To: $to\r\n";

    if (mail($to, $subject, $body, $headers) && mail($email, $ackSubject, $ackMessage, $ackHeaders)) {
        // Message if mail has been sent
        echo "<script>
                location.replace('contactus_thankyou.html');
            </script>";
    } else {
        // Message if mail has not been sent
        echo "<script>
                alert('Please retry submitting the form.');
                location.replace('/index');
            </script>";
    }
}
?>