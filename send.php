<?php


    require 'PHPMailer.php';




if($_POST) {



    $name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
$email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
 $message = filter_var($_POST["message"], FILTER_SANITIZE_STRING);


    if (empty($name)) {
        $empty[] = "<b>Name</b>";
    }
    if (empty($email)) {
        $empty[] = "<b>Email</b>";
    }

    if (empty($message)) {
        $empty[] = "<b>Message</b>";
    }

    if (!empty($empty)) {
        $output = json_encode(array('type' => 'error', 'text' => implode(", ", $empty) . ' Required!'));
        die($output);
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { //email validation
        $output = json_encode(array('type' => 'error', 'text' => '<b>' . $email . '</b> is an invalid Email, please correct it.'));
        die($output);
    }




    if (isset($_POST["captcha"])) {
        $captcha = $_POST["captcha"];
        $privatekey = "your_secret_key";
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = array(
            'secret' => $privatekey,
            'response' => $captcha,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        );

        $curlConfig = array(
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $data
        );

        $ch = curl_init();
        curl_setopt_array($ch, $curlConfig);
        $response = curl_exec($ch);
        curl_close($ch);
    }

    $jsonResponse = json_decode($response);
    if ($jsonResponse->success==false) {
        // What happens when the CAPTCHA was entered incorrectly
        $output = json_encode(array('type' => 'error', 'text' => '<b>Captcha</b> Validation Required!'));
        die($output);
    } else {
            /**
             * Send mail to server
             */
            $mail = new PHPMailer;
            $mail->setFrom('no-reply@uavskies.com', 'Uavskies');
            $mail->addReplyTo('replyto@uavskies.com', 'Uavskies');
           //$mail->addAddress('info@UAVSkies.com');
            $mail->addAddress('anrctg@gmail.com');

            $mail->Body = "Name: $name \n\r";
            $mail->Body .= "Email: $email \n\r";

            $mail->Body .= "Message: $message \n\r";

            if (!$mail->send()) {
                $output = json_encode(array('type' => 'error', 'text' => 'Unable to send email, please contact info@uavskies.com'));
                die($output);
            } else {
                /**
                 * Send mail to client
                 */

                $output = json_encode(array('type' => 'message', 'text' => 'Hi ' . $name . ', thank you for the comments. We will get back to you shortly.'));
                die($output);
            }


    }


}


?>



