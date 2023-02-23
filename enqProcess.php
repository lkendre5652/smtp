<?php
include('smtp/PHPMailerAutoload.php');

$yourname = $_POST['your-name-enq'];
$yourmobile = $_POST['your-mobile-enq'];
$youremail = $_POST['your-email-enq'];
$productsall = $_POST['productsall'];
$yourMessage  = $_POST['your-message'];

function smtp_mailer1($to,$subject,$msg){            
    $mail = new PHPMailer(); 
    $mail->SMTPDebug  = 3;
    $mail->IsSMTP(); 
    $mail->SMTPAuth = true; 
    $mail->SMTPSecure = 'tls'; 
    $mail->Host = "smtp.gmail.com"; // smtp change
    $mail->Port = 587; 
    $mail->IsHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Username = "test@g.c"; // smtp email
    $mail->Password = ""; // pass
    $mail->SetFrom("test@g.c"); // email
    $mail->Subject = $subject;
    $mail->Body =$msg;
    $mail->AddAddress($to);
     $mail->ClearReplyTos();
    $mail->addReplyTo('test@g.c', 'test');
    $mail->SMTPOptions=array('ssl'=>array(
        'verify_peer'=>false,
        'verify_peer_name'=>false,
        'allow_self_signed'=>false
    ));
    $resp = [];
    if(!$mail->Send()){ 
    
    }else{

      
        }
    }


//admin                          
function smtp_mailer($to,$subject,$msg){            
    $mail = new PHPMailer(); 
    $mail->SMTPDebug  = 3;
    $mail->IsSMTP(); 
    $mail->SMTPAuth = true; 
    $mail->SMTPSecure = 'tls'; 
    $mail->Host = "smtp.gmail.com"; // smtp change
    $mail->Port = 587; 
    $mail->IsHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Username = "test@g.c"; // smtp email
    $mail->Password = "test123"; // pass
    $mail->SetFrom("test@g.c"); // email
    $mail->Subject = $subject;
    $mail->Body =$msg;
    $mail->AddAddress($to);
     $mail->ClearReplyTos();
    $mail->addReplyTo('test@g.c', 'TEST Name');
    $mail->SMTPOptions=array('ssl'=>array(
        'verify_peer'=>false,
        'verify_peer_name'=>false,
        'allow_self_signed'=>false
    ));
    $resp = [];
    if(!$mail->Send()){ 
        $resp['comm_error'] = "There was an error trying to send your message. Please try again later.";
        $resp['error_msg'] = "error-msg";
        $resp['data_resp'] = 'error';
        return json_encode($resp);      
    }else{

        $resp['comm_succ'] =  'Your form has been submitted successfully!!';
        $resp['success_msg'] = 'success-msg';
        $resp['data_resp'] = 'success';
        return json_encode($resp);  
        }
    }

    if( ( !empty($yourname) ) && ( !empty($yourmobile) ) && ( !empty($youremail) ) ){   
        $regex = '/^[a-zA-Z ]*$/';
        if( (preg_match($regex,$yourname)  == true)  ){
            $name = 1;          
        }   else{
            $name = 0;
        }
        //mobile number
        $regmob = "/^[0-9]{8,15}+$/";
        if( (preg_match($regmob,$yourmobile)  == true)  ){
            if( strlen($yourmobile) < 8  || strlen($yourmobile) > 15 ){
                $mobile = 0;                
            }else{
                 $mobile= 1;                
            }           
        }else{
             $mobile    = 0;
        }
        if($name == 1 && $mobile == 1 ){
            if( !empty($yourname ) && !empty($yourmobile) &&  !empty($youremail) && !empty($productsall) ){
                $conn = mysqli_connect('localhost','','$#','')or die('Something went wrong with You!!');                
                $sql = "insert into  enqformnow(yourname, yourmobile, youremail,productsall,yourMessage)values('$yourname','$yourmobile','$youremail','$productsall','$yourMessage')";
                mysqli_query($conn,$sql);                
            } 
            //admin
            $subject = "Contact Form Submission For - TEST Name";
            $msg = "Dear Team ,<br> We have received below details from <strong>TEST Name</strong> website Contact Form submitted today.<br>";           
            $msg .= "Name:".$yourname;
            $msg .= "<br>Contact No:".$yourmobile;
            $msg .= "<br>Email:".$youremail;
            $msg .= "<br> Service: ".$productsall;
            $msg .= "<br> Message: ".$yourMessage;
            $msg .= "<br><br><br>";
            $msg .= "Thanks & Regards,<br>";
            $msg .= "<strong>TEST Name</strong>";
            echo smtp_mailer( 'laxmantest2525@gmail.com',$subject,$msg);            
            
            // user reply
            $user_msg = "Dear ".$yourname.",<br>";
            $user_msg .= "Thank you. Your response has been recorded. Our representative will get in touch with you shortly.<br /><br /><br />";
            $user_msg .= "Thanks & Regards,<br>";
            $user_msg .= "<strong>TEST Name</strong>";
            echo smtp_mailer1( $youremail,$subject,$user_msg);
        }   
    }

?>