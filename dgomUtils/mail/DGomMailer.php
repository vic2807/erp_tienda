<?php

namespace app\dgomUtils\mail;

use Yii;
use yii\swiftmailer\Mailer;
use app\dgomUtils\setup\SetupUtils;

class DGomMailer{


	/**
	 * Envia el correo electronico para la activiación de la cuenta
	 *
	 * @param array $parametrosEmail
	 * @return boolean  
	 *  Parametros para el email
	 *	$parametrosEmail ['url'] = Yii::$app->urlManager->createAbsoluteUrl ( [ 'ingresar/' . $user->txt_token ] );
	 *  $parametrosEmail ['user'] = $user->getNombreCompleto ();
	 *	$parametrosEmail ['email'] = $user->txt_email;
	 *	$parametrosEmail ['pass'] = $model->password;      	
	 */
	public function sendEmailActivacion($email,$parametrosEmail) {
		
		return $this->sendEmail ( 
			'@app/dgomUtils/mail/layouts/activarCuenta', 
			'Email de Activaciòn', 
			SetupUtils::getString(SetupUtils::MAIL_USER_NAME), //Yii::$app->params ['modUsuarios'] ['email'] ['emailActivacion'],
			$email, 
			'Correo de activación', //Yii::$app->params ['modUsuarios'] ['email'] ['subjectActivacion'],
			 $parametrosEmail );
	}

	public function sendEmailBienvenida($email, $parametrosEmail)
	{

		return $this->sendEmail(
			'@app/dgomUtils/mail/layouts/bienvenida',
			'Email de Bienvenida',
			SetupUtils::getString(SetupUtils::MAIL_USER_NAME), //Yii::$app->params ['modUsuarios'] ['email'] ['emailActivacion'],
			$email,
			'¡Te damos la Bienvenida!', //Yii::$app->params ['modUsuarios'] ['email'] ['subjectActivacion'],
			$parametrosEmail
		);
	}

	public function sendEmailContacto($email,$parametrosEmail) {
		
		return $this->sendEmail ( 
			'@app/dgomUtils/mail/layouts/contacto', 'Email de contacto', 
			Yii::$app->params ['modUsuarios'] ['email'] ['emailActivacion'],
			$email, 
			Yii::$app->params ['modUsuarios'] ['email'] ['subjectActivacion'], 
			$parametrosEmail 
		);
	}

	public function sendEmailNotificacionesCliente($email,$parametrosEmail) {

		return $this->sendEmail ( 
			'@app/dgomUtils/mail/layouts/notificacionCliente', 
			'Email de notificaciòn', 
			Yii::$app->params ['modUsuarios'] ['email'] ['emailActivacion'],
			$email, 
			Yii::$app->params ['modUsuarios'] ['email'] ['subjectActivacion'], 
			$parametrosEmail 
		);
	}

	public function sendEmailNotificacionesAdmin($email,$parametrosEmail) {
		
		// Envia el correo electronico
		return $this->sendEmail ( 
			'@app/modules/ModUsuarios/mail/notificacionAdmin', 
			'@app/modules/ModUsuarios/mail/layouts/text', 
			Yii::$app->params ['modUsuarios'] ['email'] ['emailActivacion'],
			$email, 
			Yii::$app->params ['modUsuarios'] ['email'] ['subjectActivacion'], 
			$parametrosEmail 
		);
	}
	
	/**
	 * Envia el correo electronico para recuperar el correo electronico
	 *
	 * @param array $parametrosEmail
	 * @return boolean
	 */
	public  function sendEmailRecuperarPassword($email,$parametrosEmail) {
		// Envia el correo electronico
		return $this->sendEmail ( 
			'@app/dgomUtils/mail/layouts/recuperarPassword', 
			'Email de recuperación de contraseña', 
			SetupUtils::getString(SetupUtils::MAIL_USER_NAME), 
			$email, 
			"Recuperar contraseña", 
			$parametrosEmail 
		);
	}
	
	/**
	 * Envia mensaje de correo electronico
	 *
	 * @param string $templateHtml      	
	 * @param string $templateText        	
	 * @param string $from        	
	 * @param string $to        	
	 * @param string $subject        	
	 * @param array $params        	
	 * @return boolean
	 */
	public function sendEmail($templateHtml, $templateText, $from, $to, $subject, $params) {

		//Verifica si debe enviar emails
		if(!SetupUtils::getBoolean(SetupUtils::MAIL_ENABLED)){
			Yii::debug(SetupUtils::getEnviroment() .  ' Envío de correo desactivado');
			return;
		}


		//Configuración del correo
		$mailerParams = [
			//'class' => 'yii\swiftmailer\Mailer',
			'transport'=>[
				'class' 	 => 'Swift_SmtpTransport',
				'host' 		 => SetupUtils::getString(SetupUtils::MAIL_HOST), // 'c03.tmdcloud.com',
				'username' 	 => SetupUtils::getString(SetupUtils::MAIL_USER_NAME), //'development@2gom.com.mx',
				'password'	 => SetupUtils::getString(SetupUtils::MAIL_PASSWORD), //'_fJ.&@yhA&z;',
				'port' 		 => SetupUtils::getString(SetupUtils::MAIL_PORT), //'465',
				'encryption' => SetupUtils::getString(SetupUtils::MAIL_ENCRYPTION) //'ssl',
			] 
		];

		

		$email = new Mailer($mailerParams);

		$message =  Yii::$app->mailer->compose ( [
				'html' => $templateHtml
		], $params )->setFrom ( $from )->setTo ( $to )->setSubject ( $subject );


		$bcc = SetupUtils::getString(SetupUtils::MAIL_SEND_CCO);
		if($bcc != null && $bcc != ""){
			$message->setBcc($bcc);
		}

		$toTest = SetupUtils::getString(SetupUtils::MAIL_TO_TEST);
		if($toTest != null && $toTest != ""){
			$message->setTo($toTest);
		}

		$email->send($message);
	}

	public function sendBasicEmail($templateHtml, $templateText, $from, $to, $subject, $params) {

		//Verifica si debe enviar emails
		if (!SetupUtils::getBoolean(SetupUtils::MAIL_ENABLED) || !SetupUtils::getBoolean(SetupUtils::MAIL_TO_TEST)) {
			Yii::debug(SetupUtils::getEnviroment() .  ' Envío de correo desactivado');
			return;
		}


		//Configuraicion del correo
		$mailerParams = [
			//'class' => 'yii\swiftmailer\Mailer',
			'transport'=>[
				'class' 	 => 'Swift_SmtpTransport',
				'host' 		 => SetupUtils::getString(SetupUtils::MAIL_HOST), // 'c03.tmdcloud.com',
				'username' 	 => SetupUtils::getString(SetupUtils::MAIL_USER_NAME), //'development@2gom.com.mx',
				'password'	 => SetupUtils::getString(SetupUtils::MAIL_PASSWORD), //'_fJ.&@yhA&z;',
				'port' 		 => SetupUtils::getString(SetupUtils::MAIL_PORT), //'465',
				'encryption' => SetupUtils::getString(SetupUtils::MAIL_ENCRYPTION) //'ssl',
			]
		];



		$email = new Mailer($mailerParams);
		try{
			$message = $email->compose ( [], $params )->setFrom ( $from )->setTo ( $to )->setSubject ( $subject );
		}catch(\Exception $e){

		}


		$bcc = SetupUtils::getString(SetupUtils::MAIL_SEND_CCO);
		if($bcc != null && $bcc != ""){
			$message->setBcc($bcc);
		}

		$toTest = SetupUtils::getString(SetupUtils::MAIL_TO_TEST);
		if($toTest != null && $toTest != ""){
			$message->setTo($toTest);
		}

		$message->setHtmlBody($templateHtml);


		$email->send($message);
	}
	
}
