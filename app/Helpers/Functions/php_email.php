<?php
use PHPMailer\PHPMailer\PHPMailer;  
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if(!function_exists('sendWithPhpMailer')){
  //Params contains detail for single email
  //Recipients contains multiple email in array
  function sendWithPhpMailer($params='',$recipients=''){  
    if(!is_array($params)){return false;}//parameters empty
    $mail = new PHPMailer(true);
    $smtp = DB::table('smtp_settings')->first();
    $mail->Priority = 1;
		$mail->AddCustomHeader("X-MSMail-Priority: High");
		$mail->AddCustomHeader("Importance: High");
    if($smtp){//if smtp setup is done
      if(strtolower($smtp->auth) == 'yes'){
        //smtp setup
        //Enable SMTP debugging.
        $mail->SMTPDebug = 0;
        //Set PHPMailer to use SMTP.
        $mail->isSMTP(); 
        $mail->Host = $smtp->hostname;
        $mail->Port = $smtp->port; // Set the SMTP port
        $mail->SMTPAuth = true;
        $mail->Username = $smtp->username; // SMTP username
        $mail->Password = $smtp->password; // SMTP password
        $mail->SMTPSecure = $smtp->encryption; // Enable encryption, 'ssl' also accepted
        //Other SMTP Options
        $mail->SMTPOptions = array(
          'ssl' => array(
              'verify_peer' => false,
              'verify_peer_name' => false,
              'allow_self_signed' => true
          )
        );

      }
    }
    //From email address and name
    $mail->From = $params['from_email'];
    $mail->FromName = $params['from_name'];    

    //To address and name
    if(is_array($recipients) && count($recipients) > 0){
        foreach($recipients as $recipient): //same email for multiple recipients in bluck
          $mail->addAddress($recipient);
        endforeach;
    }else{
      if(isset($params['to_name']) && !empty(trim($params['to_name']))){
        $mail->addAddress($params['to_email'], $params['to_name']);
      }else{
        $mail->addAddress($params['to_email']);
      }
    }
    //Address to which recipient will reply
    //$mail->addReplyTo("reply@yourdomain.com", "Reply");

    //CC and BCC
    //$mail->addCC("cc@example.com");
    //$mail->addBCC("bcc@example.com");

    //Provide file path and name of the attachments
    //$mail->addAttachment("file.txt", "File.txt");        
    //$mail->addAttachment("images/profile.png"); //Filename is optional
    
    //Send HTML or Plain Text email
    $mail->isHTML(true);
    $mail->Subject = $params['subject'];
    $mail->Body = $params['message'];
    $mail->AltBody = (isset($params['alt_body']) && !empty(trim($params['alt_body'])))?$params['alt_body']:'';

    try {
      $mail->send();
      //echo "Message has been sent successfully";
      return 'thik xa';
    } catch (Exception $e) {
      // return "Mailer Error: " . $mail->ErrorInfo; //enable incase of debuging only
      // return 'thik xaina';
      dd($mail);
    }
  }
}


if(!function_exists('test_email')){
	function test_email(){
		$params['from_email'] = 'surendra.dhital@defttree.com';
	    $params['from_name']  = 'Surendra Defttree';
	    $params['to_email']   = 'surendhital4@gmail.com';
	    $params['to_name']	  = 'Surendra Dhital';
	    $params['subject']	  = 'Test SMTP Email';
	    $params['message']	  = '<p>Dear Customer,</p> <p>This is test SMTP email through laravel.</p>';
	    sendWithPhpMailer($params);
	}
}