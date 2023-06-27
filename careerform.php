<?php
if (isset($_POST['submit'])) {
    // Retrieve form data
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $job = $_POST['job'];
    $message = $_POST['message'];

    // File path and name of the uploaded resume
    $resumePath = $_FILES['resume']['tmp_name'];
    $resumeName = $_FILES['resume']['name'];
    $resumeSize = $_FILES['resume']['size'];

    // Define the file size limit (in bytes)
    $fileSizeLimit = 10 * 1024 * 1024; // 10MB

    // Check if the file size exceeds the limit
    if ($resumeSize > $fileSizeLimit) {
        echo "Error: The file size exceeds the limit of 10MB.";
        exit;
    }

    // Email details
    $to = 'smchemicalsofficial@gmail.com';
    $subject = "Job application from: $firstName $lastName for $job";
    $from = $_POST['email'];

    // Read the resume file content and encode it as base64
    $resumeContent = base64_encode(file_get_contents($resumePath));

    // Generate a random boundary for the email
    $boundary = md5(time());

    // Email headers
    $headers = "From: $from\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
    $headers .= "X-Priority: 1\r\n";
    $headers .= "X-Mailer: PHP" . phpversion() . "\r\n";

    // Email body
    $body = "--$boundary\r\n";
    $body .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
    $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $body .= "First Name: $firstName\r\n";
    $body .= "Last Name: $lastName\r\n";
    $body .= "Phone: $phone\r\n";
    $body .= "Email: $email\r\n";
    $body .= "Applying for: $job\r\n";
    $body .= "Message:\r\n$message\r\n";
    $body .= "--$boundary\r\n";
    $body .= "Content-Type: application/pdf; name=\"$resumeName\"\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n";
    $body .= "Content-Disposition: attachment; filename=\"$resumeName\"\r\n\r\n";
    $body .= "$resumeContent\r\n\r\n";
    $body .= "--$boundary--";

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
