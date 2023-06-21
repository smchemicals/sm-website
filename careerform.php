<?php

if(isset($_POST['submit'])){
    
    $to = "smchemicals@gmail.com";
    
    $from = $_POST['email']; //E-Mail ID value
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone']; //Mobile No
    $job = $_POST['job'];
    $cover_letter = $_POST['message'];

    $name = $first_name." ".$last_name;
    
    $resume_name = $first_name."_".$last_name;
    
    $target_dir = "resumes/";
    $resume_name = $resume_name ."_". basename($_FILES["resume"]["name"]);
    $target_file = $target_dir . $resume_name;
    
    $subject = "Application from: ".$name." for ".$job.".";
    
    
    $uploadOk = 1;

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "<script>
        alert('Sorry, file already exists.');
        </script>";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["resume"]["size"] > 500000) {
        echo "<script>
        alert('Sorry, your file it too large.');
        </script>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<script>
        alert('Sorry, your file was not uploaded.');
        </script>";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["resume"]["tmp_name"], $target_file)) {
            echo "<script>
                alert('Your resume is uploaded.');
            </script>";
        } else {
              echo "<script>
                 alert('Sorry, there was an error uploading your file.');
            </script>";   
        }
    }
    
            $message ="
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
                            <td style='width:190px;'><p>Modile No :</p></td>
                            <td style='width:400px'><p>$phone</p></td>
                        </tr>
                        <tr>
                            <td style='width:190px;'><p>Application for :</p></td>
                            <td style='width:400px'><p>$job</p></td>
                        </tr>
                        <tr>
                            <td style='width:190px;'><p>Resume Uploaded:</p></td>
                            <td style='width:400px'><p>$resume_name</p></td>
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
    
        $headers = "From: ". $from."\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $headers .= "X-Priority: 1\r\n";
        $headers.= "X-Mailer: PHP". phpversion() ."\r\n" ;
    
        $headers_ack = "From: ". $to;
        $subject_ack = "Thank you ".$first_name." ".$last_name.",We will contact you soon.";
        $message_ack_pre = "Dear ".$first_name." ".$last_name.",\r\n\r\n";
        $message_ack_post = "Best Regards,\r\n SM Chemicals\r\n \r\nAddress:\r\n House No 2-2-1137/5/B \r\nNew Nallakunta, Hyderabad - 500 044, T.S\r\n Mobile  : +91 - 9246181170 \r\n \r\n E-Mail : smchemicals@gmail.com \r\n Visit us at http://www.smchemicals.co.in";
        $message_ack = $message_ack_pre."We have received your request and shall revert shortly.\r\n\r\n".$message_ack_post;
         
        if(mail($to,$subject,$message,$headers) && mail($from,$subject_ack,$message_ack,$headers_ack)){
            // Message if mail has been sent
            
            echo "<script>
                    location.replace('contactus_thankyou.html');
                </script>";
        }
 
        else{
            // Message if mail has been not sent
            echo "<script>
                    alert('Please retry submiting the form.');
                    location.replace('/index');
                </script>";
        }
    
}
?>
