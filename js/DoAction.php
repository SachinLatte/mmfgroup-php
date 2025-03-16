<?php
ob_start();
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


header('Content-type: application/json; charset=UTF-8');

date_default_timezone_set('Asia/Kolkata');
$date = date("j F Y, g:i a");
$_ADMIN =[
    "email" => "borgesachin365@gmail.com",
    "password" => "amhphwormytnqyvx"
    ];


if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $response = array();
    $validation = "";
    $Website_name ="Your Company Name";
    // Create template
    // Send Email Template
    function sendEmail($name, $email, $phone, $destionation, $message){
        global $Website_name;
            $msgbody = "<html><body>";
            $msgbody .= "Dear ".$name.", <br><br>";
            $msgbody .= "Thank you for contacting us. This is to confirm that your message has been received by us on ". date("l, M d, h:ia") .".<br>The details provided by you were as mentioned below-<br>";
            $msgbody .= "<strong>Name  </strong><strong> : </strong>" . $name . "<br>";
            $msgbody .= "<strong>Email Id  </strong><strong> : </strong>" . $email . "<br>";
            $msgbody .= "<strong>Mobile No.  </strong><strong> : </strong>" . $phone . "<br>";
            $msgbody .= "<strong>Destionation  </strong><strong> : </strong>" . $destionation . "<br>";
            $msgbody .= "<strong>Message  </strong><strong> : </strong>" . $message . "<br>";
            
            
            
            $msgbody .= "<br>We will be replying to you shortly.<br><br><strong>Thanks & Regards,<br>$Website_name<strong>";
            $msgbody .= "</body></html>";

            $admmsgbody = "<html><body>";
            $admmsgbody = "Dear Admin, <br>";
            $admmsgbody .= "The details provided by the enquirer are mentioned below:<br><br>";
            $admmsgbody .= "<strong>Name  </strong><strong> : </strong>" . $name . "<br>";
            $admmsgbody .= "<strong>Email Id  </strong><strong> : </strong>" . $email . "<br>";
            $admmsgbody .= "<strong>Mobile No.  </strong><strong> : </strong>" . $phone . "<br>";
            $admmsgbody .= "<strong>Destionation  </strong><strong> : </strong>" . $destionation . "<br>";
            $admmsgbody .= "<strong>Message  </strong><strong> : </strong>" . $message . "<br>";
            
            $admmsgbody .= "Enquirer is awaiting your reply.";
            $admmsgbody .= "</body></html>";
            
            $sendEnquiry = sendEnquiryEmailSMTP($name, $email, $phone, $message, $msgbody, $admmsgbody, $destionation);
			$csv = ThirdpartyAPI($name, $email, $phone, $destionation, $message);
            
	        return $sendEnquiry && $csv;

    }

    // sendEnquiryEmail
    function sendEnquiryEmail($name, $email, $phone, $message, $msgbody, $admmsgbody, $destionation){
        global $Website_name;
    	
    	try {
			// Always set content-type when sending HTML email
			$header = "MIME-Version: 1.0" . "\r\n";
			$header .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			// More headers
			$header .= 'From: <borgesachin365@gmail.com>' . "\r\n";

            if (!mail($email, "AUTO REPLY FROM ".strtoupper($Website_name), $msgbody, $header)) {
                $response['status'] = 'error';
                $response['success'] = false;
                $response['errors'] = "Autoreply not send";
                echo json_encode($response);
                exit();
			} else {
               

				// Always set content-type when sending HTML email
				$header1 = "MIME-Version: 1.0" . "\r\n";
				$header1 .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
				// More headers
				$header1 .= 'From: <borgesachin365@gmail.com>' . "\r\n";
                if (!mail("borgesachin365@gmail.com", "New enquiry form website", $admmsgbody, $header1)) {
                    $response['status'] = 'error';
                    $response['success'] = false;
                    $response['errors'] = "Admin mail not send";
                    echo json_encode($response);
                    exit();
				}else{
				   
				    setcookie('formsource', $name, time() + (86400), "/");
				    
				    $redirect = $_SERVER['HTTP_REFERER'];
				    
                    $response['status'] = 'success';
                    $response['code'] = '2000';
                    $response['success'] = true;
                    $response['errors'] = '';
                    $response['message'] = 'Lead is saved successfully';
                    $response['redirecturl'] = $redirect ;
                    echo json_encode($response);
                    exit();
                }
            }

        } catch (Exception $e) {
            $status = "Mail not send";
            //Server settings
            $header1 = "From: <borgesachin365@gmail.com> \r\n";
            $header1 .= "MIME-Version: 1.0\r\n";
            $header1 .= "Content-type: text/html; charset=iso-8859-1 \r\n";

            $mailto ="borgedadaso50@gmail.com";
            $subject = "Error ";
            $body ="Email sending failed";

            mail($mailto, $subject, $body, $header1);
            $response['status'] = 'success';
            $response['code'] = '2000';
            $response['success'] = true;
            $response['errors'] = '';
            $response['message'] = 'Lead is saved successfully2';
            $response['redirecturl'] = $_SERVER['HTTP_REFERER'];
            echo json_encode($response);
            exit();
        }
    }

    function sendEnquiryEmailSMTP($name, $email, $phone, $message, $msgbody, $admmsgbody, $destionation){
        global $Website_name, $_ADMIN;
      
            
            $mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

            //$mail->IsSMTP(); // telling the class to use SMTP
            $mail->Host       = "smtp.gmail.com"; // SMTP server
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth   = true;                  // enable SMTP authentication
            $mail->SMTPSecure = "tls";                 // sets the prefix to the servier
            $mail->Port       = "587";                   // set the SMTP port for the GMAIL server
            $mail->Username = $_ADMIN['email'];                 
            $mail->Password = $_ADMIN['password'];     
            $mail->CharSet = 'utf-8'; 

            $mail->From = $_ADMIN['email'];
            $mail->FromName = $Website_name;
            
            $mailAutoReply = clone $mail;
            
            $mail->addAddress($email, $name);
            $mail->AddReplyTo($_ADMIN['email'], "Admin");
            $mail->isHTML(true);
            
            $mail->Subject = "AUTO REPLY FROM ".strtoupper($Website_name);
            $mail->Body = $msgbody;
        try {
        		if (!$mail->send()) {
        		} else {
        				$mailAutoReply->AddAddress($_ADMIN['email'], "Admin");
                    	$mailAutoReply->AddReplyTo($email, $name);
        				$mailAutoReply->Subject = "Enquiry for Get in Touch";
        				$adminname ="Admin";
        
        			$mailAutoReply->Body = $admmsgbody;
        
        			$mailAutoReply->IsHTML(true);
        
        			if (!$mailAutoReply->send()) {
        				$response['status'] = 'eroor';
        				$response['message'] = "2 - Mailer Error: " . $mail->ErrorInfo;
        			} else {
        			    
        			    $resume ='';
    				    // $savelead = saveData($name, $email, $phone, $source);
    				    // setcookie('formsource', $source, time() + (86400), "/");
                        $redirect = $_SERVER['HTTP_REFERER'];
    				    
                        $response['status'] = 'success';
                        $response['success'] = true;
                        $response['errors'] = '';
                        $response['message'] = 'Lead is saved successfully';
                        $response['redirecturl'] = $redirect ;
                        echo json_encode($response);
                        exit();
        
        			}
        			echo json_encode($response);
        		}
        
        	} catch (Exception $e) {
        		$status = "Mail not send";
        		//Server settings
        		$header1 = "From: borgesachin365@gmail.com \r\n";
        		$header1 .= "MIME-Version: 1.0\r\n";
        		$header1 .= "Content-type: text/html; charset=iso-8859-1 \r\n";
        		
        		$mailto ="borgedadaso50@gmail.com";
        		$subject = "Error : ";
        		$body ="Email sending failed ";
        
        		mail($mailto, $subject, $body, $header1);
        
        		$response['status'] = 'success';
        		$response['message'] = "Thank you for your response";
        		$response['redirecturl'] = $_SERVER['HTTP_REFERER'];
        		echo json_encode($response);
        	}

    }

    function ThirdpartyAPI($name, $email, $phone, $destionation, $message){
        global $Website_name, $date;
        

		$file = fopen("./contactform.csv","a");
    	fputcsv($file,array($name,$phone,$email,$destionation,$message, $date));
		fclose($file);
    }
    // check submit
    if (isset($_POST["submit"])) {
        
        $name			=	$_POST['your-name'];
        $email			=	$_POST['your-email'];
        $phone			=	$_POST['your-number'];
        $destionation   =   $_POST['your-destionation'];
        $message		=	$_POST['your-message'];
        
        
        if (empty(trim($name))) {
            $errors['name']= "Please enter fullname </br>";
            $validation .= "Please enter fullname </br>";
        } else if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $errors['name']= "Only letters and white space allowed</br>";
             $validation .= "Only letters and white space allowed</br>";
        } else if ($name === "test" || $name === "demo" || $name === "user") {
            $errors['name']= "Plese Specify valid fullname</br>";
             $validation .=  "Plese Specify valid fullname</br>";
        }

        if (empty(trim($email))) {
            $errors['email']= "Please enter email </br>";
            $validation .= "Please enter email </br>";
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email']= "Invalid email format <br>";
                $validation .= "Invalid email format <br>";
            }
        }

        if (empty($phone)) {
            $errors['mobile']= "Please enter phone </br>";
            $validation .= "Please enter phone </br>";
        } else if (!is_numeric($phone)) {
            $errors['mobile']= "Please enter only digits !</br>";
            $validation .= "Please enter only digits !</br>";
        } else if (!preg_match("/^[6789]\d{9}/", $phone)) {
            $errors['mobile']= "Please enter valid number</br>";
            $validation .="Please enter valid number</br>";
        } else if (strlen($phone) !=10) {
            $errors['mobile']= "phone number 10 digits only ! </br>";
            $validation .="phone number 10 digits only ! </br>";
        }

        if (empty(trim($destionation))) {
            $errors['name']= "Please enter city </br>";
            $validation .= "Please enter city </br>";
        }

        if (empty(trim($message))) {
            $errors['name']= "Please enter message </br>";
            $validation .= "Please enter message </br>";
        }
        
        
        if (!empty($errors)) {
            $response['status'] = 'error';
            $response['code'] = '2001';
            $response['success'] = false;
            $response['errors'] = $errors;
            $response['message'] = $validation;
            echo json_encode($response);
            exit();
        } else {
            $enquiryEmail = sendEmail($name, $email, $phone, $destionation, $message);
	        return $enquiryEmail;
        }
	}else{
		$response['status'] = 'error';
	    $response['code'] = '2001';
	    $response['success'] = true ;
	    $response['message'] = 'Form not found';
	}
}else{ 
    $response['status'] = 'error';
    $response['code'] = '2004';
    $response['success'] = true ;
    $response['message'] = 'Method not allowed';
    echo json_encode($response);
    exit();
}
?>