<?php
    
    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.

        $name = strip_tags(trim($_POST["name"]));
                $name = str_replace(array("\r","\n"),array(" "," "),$name);

        $company = strip_tags(trim($_POST["company"]));
                $company = str_replace(array("\r","\n"),array(" "," "),$company);

        $address = strip_tags(trim($_POST["address"]));
                $address = str_replace(array("\r","\n"),array(" "," "),$address);

        $city = strip_tags(trim($_POST["city"]));
                $city = str_replace(array("\r","\n"),array(" "," "),$city);
        
        $mobile = strip_tags(trim($_POST["mobile"]));
                $mobile = str_replace(array("\r","\n"),array(" "," "),$mobile);

        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);

        $message = strip_tags(trim($_POST["message"]));
                $message = str_replace(array("\r","\n"),array(" "," "),$message);

        // Check that data was sent to the mailer.
        if ( empty($name) OR 
            empty($company) OR 
            empty($address) OR 
            empty($city) OR 
            empty($mobile) OR 
            !filter_var($email, FILTER_VALIDATE_EMAIL) OR
            empty($message)) {
            // Set a 400 (bad request) response code and exit.
            // http_response_code(400);
            if (!function_exists('http_response_code'))
            {
                function http_response_code($newcode = NULL)
                {
                    static $code = 400;
                    if($newcode !== NULL)
                    {
                        header('X-PHP-Response-Code: '.$newcode, true, $newcode);
                        if(!headers_sent())
                            $code = $newcode;
                    }       
                    return $code;
                }
            }
            echo "Oops! There was a problem with your submission. Please complete the form and try again.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.

        $recipient = "chinmay412@gmail.com";

        // Set the email subject.
        $subject = "New Enquiry Form - $name";

        // Build the email content.
        $email_content = "Person Name: $name\n";
        $email_content .= "Company Name: $company\n";
        $email_content .= "Address: $address\n";
        $email_content .= "City: $city\n";
        $email_content .= "Mobile: $mobile\n";
        $email_content .= "Email: $email\n";
        $email_content .= "Message: $message\n";        

        // Build the email headers.
        // $email_headers = "From: $nameOfCandidate <$email>";
        $email_headers = "Reply-To: <chinmay412@gmail.com>\r\n"; 
        $email_headers .= "Return-Path: <chinmay412@gmail.com>\r\n"; 
        $email_headers .= "From: $name <$email>\r\n"; 
        $email_headers .= "Organization: My Organization\r\n"; 
        $email_headers .= "Content-Type: text/plain\r\n";

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            // http_response_code(200);
            if (!function_exists('http_response_code'))
            {
                function http_response_code($newcode = NULL)
                {
                    static $code = 200;
                    if($newcode !== NULL)
                    {
                        header('X-PHP-Response-Code: '.$newcode, true, $newcode);
                        if(!headers_sent())
                            $code = $newcode;
                    }       
                    return $code;
                }
            }
            echo "Thank you for your enquiry! Your message has been sent. We will get back to you soon.";
        } else {
            // Set a 500 (internal server error) response code.
            // http_response_code(500);
            if (!function_exists('http_response_code'))
            {
                function http_response_code($newcode = NULL)
                {
                    static $code = 500;
                    if($newcode !== NULL)
                    {
                        header('X-PHP-Response-Code: '.$newcode, true, $newcode);
                        if(!headers_sent())
                            $code = $newcode;
                    }       
                    return $code;
                }
            }
            echo "Oops! Something went wrong and we couldn't send your message.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        // http_response_code(403);
        if (!function_exists('http_response_code'))
            {
                function http_response_code($newcode = NULL)
                {
                    static $code = 403;
                    if($newcode !== NULL)
                    {
                        header('X-PHP-Response-Code: '.$newcode, true, $newcode);
                        if(!headers_sent())
                            $code = $newcode;
                    }       
                    return $code;
                }
            }
        echo "There was a problem with your submission, please try again.";
    }

?>
