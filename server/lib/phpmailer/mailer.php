<?

require_once PROYECT_PATH . "/lib/phpmailer/PHPMailerAutoload.php";

function get_mailer()
{

	$mail = new PHPMailer;
	#$mail->SMTPDebug = 3;
	$mail->isSMTP();   
	// $mail->Mailer = 'smtp';                                   
	$mail->SMTPAuth = true;                               
	$mail->Host = 'smtp.gmail.com';  
	$mail->Port = 587;               
	$mail->SMTPSecure = 'tls';       

	$mail->Username = 'mcgalv';  
	$mail->Password = 'GlopzVega88';       

	$mail->From = 'mcgalv@gmail.com';
	$mail->FromName = 'Yo';
	$mail->addAddress('mcgalv@gmail.com', 'G Lopez');   
	$mail->isHTML(true); 
	$mail->Subject = 'Here is the subject';
	$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';



	return $mail;
}