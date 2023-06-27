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
    $body .= "Content-Type: multipart/alternative; boundary=\"$boundary\"\r\n\r\n";

    // HTML version of the email
    $body .= "--$boundary\r\n";
    $body .= "Content-Type: text/html; charset=UTF-8\r\n";
    $body .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";
    $body .= "<html>
                <body>
                    <h2>Job Application</h2>
                    <p><strong>First Name:</strong> $firstName</p>
                    <p><strong>Last Name:</strong> $lastName</p>
                    <p><strong>Phone:</strong> $phone</p>
                    <p><strong>Email:</strong> $email</p>
                    <p><strong>Applying for:</strong> $job</p>
                    <p><strong>Message:</strong></p>
                    <p>$message</p>
                </body>
            </html>\r\n\r\n";

    // Attachment
    $body .= "--$boundary\r\n";
    $body .= "Content-Type: application/pdf; name=\"$resumeName\"\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n";
    $body .= "Content-Disposition: attachment; filename=\"$resumeName\"\r\n\r\n";
    $body .= "$resumeContent\r\n\r\n";
    $body .= "--$boundary--";

    // Send acknowledgment email
    $ackSubject = 'Acknowledgment - Job Application';
    $ackMessage = "<html>
                    <body>
                        <p>Dear $firstName,</p>
                        <p>Thank you for your job application. We have received your application and will review it soon.</p>
                        <p>Best regards,<br>SM Chemicals</p>
                        <p>Address:<br>House No 2-2-1137/5/B<br>New Nallakunta, Hyderabad - 500 044, T.S<br>Mobile: +91 - 9246181170</p>
                        <p>E-Mail: smchemicals@gmail.com, smchemicalsofficial@gmail.com<br>Visit us at <a href='http://www.smchemicals.co.in'>http://www.smchemicals.co.in</a></p>
                    </body>
                </html>";
    $ackHeaders = "From: $from\r\n";
    $ackHeaders .= "Reply-To: $to\r\n";
    $ackHeaders .= "MIME-Version: 1.0\r\n";
    $ackHeaders .= "Content-Type: text/html; charset=UTF-8\r\n";

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