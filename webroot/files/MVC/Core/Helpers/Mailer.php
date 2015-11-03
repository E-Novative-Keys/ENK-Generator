<?php

class Mailer
{
	public function send($host, $addr, $password, $port, $name, $receivers, $subject, $body)
	{
		$mail = new PHPMailer();

		$mail->isSMTP();
		$mail->Host 		= $host;
		$mail->SMTPAuth 	= true;
		$mail->Username 	= $addr;
		$mail->Password 	= $password;
		$mail->SMTPSecure 	= 'tls';
		$mail->Port 		= $port;
		$mail->From 		= $addr;
		$mail->FromName 	= $name;

		foreach ($receivers as $name => $addr)
			$mail->addAddress($addr, $name);
		
		$mail->isHTML(true);
		$mail->CharSet 		= 'UTF-8';
		$mail->Subject 		= $subject;
		$mail->Body 		= $body;
		
		return $mail->send();
	}
}

?>