<?php

if(isset($_POST['submit'])){
    
    $to = "smchemicalsofficial@gmail.com";
    
    $from = $_POST['email']; // E-Mail ID value
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone']; // Mobile No
    $job = $_POST['job'];
    $cover_letter = $_POST['message'];

    $name = $first_name." ".$last_name;
    
    $resume_name = $first_name."_".$last_name;
    
    $subject = "Application from: ".$name." for ".$job.".";

    // Create the email message
    $message = "
    <html>
    <head>
    <style>
        tbody{
            background-color: #ECEFF1;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 5px solid #fff;
        }
        p{
            color: #25374F; 
            font-size:24px;
            font-family: Helvetica, sans-serif; 
            font-weight:300;
        }
    </style>
    </head>
    <body>
        <table style='width:800px;'>
            <tbody>
                <tr>
                    <td style='width:190px;'><p>Name :</p></td>
                    <td style='width:400px'><p>$name</p></td>
                </tr>
                <tr>
                    <td style='width:190px;'><p>E-Mail ID :</p></td>
                    <td style='width:400px'><p>$from</p></td>
                </tr>
                <tr>
                    <td style='width:190px;'><p>Mobile No :</p></td>
                    <td style='width:400px'><p>$phone</p></td>
                </tr>
                <tr>
                    <td style='width:190px;'><p>Application for :</p></td>
                    <td style='width:400px'><p>$job</p></td>
                </tr>
                <tr>
                    <td style='width:190px;'><p>Cover Letter :</p></td>
                    <td style='width:400px'><p>$cover_letter</p></td>
                </tr>
            </tbody>
        </table>
    </body>
    </html>
    ";
    
    // Attach the resume as an attachment
    $attachment = chunk_split(base64_encode(file_get_contents($_FILES["resume"]["tmp_name"])));
    $resume_name = $resume_name . "_" . basename($_FILES["resume"]["name"]);
    $message .= "--PHP-mixed-" . md5(time());
    $message .= "\r\nContent-Type: application/pdf; name=\"" . $resume_name . "\"";
    $message .= "\r\nContent-Transfer-Encoding: base64";
    $message .= "\r\nContent-Disposition: attachment; filename=\"" . $resume_name . "\"\r\n\r\n";
    $message .= $attachment . "\r\n\r\n";
    $message .= "--PHP-mixed-" . md5(time()) . "--";
    
    // Set the email headers
    $headers = "From: ". $from."\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: multipart/mixed; boundary=\"PHP-mixed-" . md5(time()) . "\"\r\n";
    $headers .= "X-Priority: 1\r\n";
    $headers .= "X-Mailer: PHP" . phpversion() . "\r\n";
    
    // Set the acknowledgement email headers
    $headers_ack = "From: ". $to;
    $subject_ack = "Thank you ".$first_name." ".$last_name.", We will contact you soon.";
    $message_ack_pre = "Dear ".$first_name." ".$last_name.",\r\n\r\n";
    $message_ack_post = "Best Regards,\r\nSM Chemicals\r\n\r\nAddress:\r\nHouse No 2-2-1137/5/B\r\nNew Nallakunta, Hyderabad - 500 044, T.S\r\nMobile: +91 - 9246181170\r\n\r\nE-Mail: smchemicals@gmail.com, smchemicalsofficial@gmail.com\r\nVisit us at http://www.smchemicals.co.in";
    $message_ack = $message_ack_pre."We have received your request and shall revert shortly.\r\n\r\n".$message_ack_post;
    
    // Check if the file size exceeds the limit (500KB in this example)
    $maxFileSize = 500000; // 500KB
    if ($_FILES["resume"]["size"] > $maxFileSize) {
        echo "<script>
            alert('Sorry, your file is too large. Maximum file size allowed is 500KB.');
            location.replace('/index');
        </script>";
        exit;
    }
    
    if(mail($to, $subject, $message, $headers) && mail($from, $subject_ack, $message_ack, $headers_ack)){
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
