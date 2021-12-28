<?php

error_reporting(1);
//echo print_r($_POST);
try{
		if(isset($_GET['version'])){
			echo 2;
		}
		if(isset($_POST['nombre'], $_POST['correo'],  $_POST['telefono'], $_POST['mensaje'])== false){
				throw new Exception("Ingrese todos los campos");
		}

		require_once 'PHPMailer/PHPMailerAutoload.php';

							$mensaje = "<br><u><b>ESTA PERSONA ENVIÓ UNA CONSULTA DESDE LA WEB:</b></u> 
							<br><br>Nombre y apellido: <b>".$_POST['nombre'].
							"</b><br><br>Correo: <b>".$_POST['correo'].
							"</b><br><br> Telefono: <b>".$_POST['telefono'].
							"</b><br><br> <u>Mensaje: </u><br>".$_POST['mensaje']."<br><br><br>";
							
							$_Mail = new PHPMailer;
							
							//si queremos enviar el correo desde otro servidor distinto al que pose el dominio y correo el php
							//descomentar lo siguiente
							
							$_Mail -> isSMTP();                                      // Set mailer to use SMTP
							
							$_Mail -> Host = 'mail.estancialatitina.com';  

							$_Mail -> SMTPAuth = true;                               // Enable SMTP authentication
							$_Mail -> Username = 'notificaciones@estancialatitina.com';                 // SMTP username
							$_Mail -> Password = '/kVWemA2iQ';                           // SMTP password
							$_Mail -> SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
							$_Mail -> Port = 587;                                    // TCP port to connect to

							$_Mail -> SMTPOptions =array(
								'ssl' => array(
									'verify_peer' => false,
									'verify_peer_name' => false,
									'allow_self_signed' => true
								)
							);
							
							//quien envia el correo
							//1er campo correo de quien envia, 2do campo nombre de la persona que lo envia.
							$_Mail -> setFrom('notificaciones@estancialatitina.com', 'Estancia La Titina');  // 111  @dominio
							
							// si queremos enviar html cambiar false por true
							$_Mail -> isHTML(false); 
							
							// a donde enviamos el correo
				//			$_Mail -> addAddress($_POST['correo']); 
							$_Mail -> addAddress("info@estancialatitina.com");  //  111 MAIL DESTINO
							$_Mail -> Subject = "Notificacion Cliente";
							
							$_Mail -> Body    = $mensaje; // mensaje
							$_Mail -> AltBody = $mensaje;// <- este es un mensaje cuando no lee html
							
							if(!$_Mail -> send()){
									throw new Exception( "No se pudo enviar el mensaje");
							}

}catch(Exception $e){
					$retorno = ['status'=>false,"message"=>$e->getMessage()];
}					
					echo json_encode($retorno?:['status'=>true]);
					exit();
					
