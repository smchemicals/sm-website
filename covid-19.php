<?php
    if(isset($_POST['submit']))
    {
        
        $to = "smchemicals@gmail.com";
        
        $from = $_POST['email']; //E-Mail ID value
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $phone = $_POST['phone']; //Mobile No
        $temp = $_POST['requpro'];
        
        $city = $_POST['city'];
        $country = $_POST['country'];
        
        $location = $city." , ".$country;
                
        $requpro = implode(', ',$temp);
        
        
        $name = $first_name." ".$last_name;
        
        $msg = $_POST['message']; // Get Message Value
        
        $subject = "Request from: ".$name." for COVID-19 Supplies like ".$requpro. " from ".$location." .";
        
        echo("\n".$subject);
                  
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
                            <td style='width:190px;'><p>Location :</p></td>
                            <td style='width:400px'><p>$location</p></td>
                        </tr>
                        <tr>
                            <td style='width:190px;'><p>Required Products :</p></td>
                            <td style='width:400px'><p>$requpro</p></td>
                        </tr>

                        <tr>
                            <td style='width:190px;'><p>Message :</p></td>
                            <td style='width:400px'><p>$msg</p></td>
                        </tr>
                    </tbody>
                </table>
            </body>
        </html>
        ";
        // HTML Message Ends here
         
/*        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
 
        // More headers
        $headers .= 'From: Admin <admin@websapex.com>' . "\r\n"; // Give an email id on which you want get a reply. User will get a mail from this email id
        $headers .= 'Cc: info@websapex.com' . "\r\n"; // If you want add cc
        $headers .= 'Bcc: boss@websapex.com' . "\r\n"; // If you want add Bcc
        */
        
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
                    location.replace('covid-thankyou.html');
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
