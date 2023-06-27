<?php
if (isset($_POST['submit'])) {
    $recaptcha = $_POST['g-recaptcha-response'];
    $res = reCaptcha($recaptcha);

    if ($res['success']) {
        $to = "smchemicalsofficial@gmail.com";
        $from = $_POST['email'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $phone = $_POST['phone'];
        $subject_text = $_POST['subject'];

        $subject = "Enquiry Form submission from: " . $first_name . " " . $last_name . " for " . $subject_text;
        $message = $_POST['message'];
        $message_pre = "Dear Sir/Madam,";
        $message_post = "Best Regards\r\n" . "Name: " . $first_name . " " . $last_name . "\r\nPhone Number: " . $phone . "\r\nMail-ID: " . $from . "\r\n";
        $headers = "From: " . $from . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
        $headers .= "X-Priority: 1\r\n";
        $headers .= "X-Mailer: PHP" . phpversion() . "\r\n";
        $message = $message_pre . "\r\n\r\n" . $message . "\r\n\r\n" . $message_post;

        $headers_ack = "From: " . $to;
        $subject_ack = "Thank you, " . $first_name . " " . $last_name . ". We will contact you soon.";
        $message_ack_pre = "Dear " . $first_name . " " . $last_name . ",\r\n\r\n";
        $message_ack_post = "Best Regards,\r\nSM Chemicals\r\n\r\nAddress:\r\nHouse No 2-2-1137/5/B\r\nNew Nallakunta, Hyderabad - 500 044, T.S\r\nMobile: +91 - 9246181170\r\n\r\nE-Mail: smchemicals@gmail.com\r\nVisit us at http://www.smchemicals.co.in";
        $message_ack = $message_ack_pre . "We have received your request and shall revert shortly.\r\n\r\n" . $message_ack_post;

        mail($from, $subject_ack, $message_ack, $headers_ack);
        mail($to, $subject, $message, $headers);

        header('Location: contactus_thankyou.html');
        exit();
    } else {
        // The reCAPTCHA response is invalid
        // Display an error message or take appropriate action
        echo "<script>alert('reCAPTCHA verification failed.');</script>";
    }
}

function reCaptcha($recaptcha)
{
    $secret = "6LfQQ7UmAAAAAPnnA-lu8Tf9JekSiZRuVC0eOF48";
    $ip = $_SERVER['REMOTE_ADDR'];

    $postvars = array(
        "secret" => $secret,
        "response" => $recaptcha,
        "remoteip" => $ip
    );
    $url = "https://www.google.com/recaptcha/api/siteverify";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
    $data = curl_exec($ch);
    curl_close($ch);

    return json_decode($data, true);
}
?>
