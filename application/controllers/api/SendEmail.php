<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SendEmail extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('email'));
		$this->load->library(array('email'));
	}


	public function kirimEmail()
	{
		$status = $this->input->post('status');
		$subject = "Test subject";
		$email = $this->input->post('email');



		if ($status == 'Diterima') {
			$subject = 'test email';
			$status = 'Disetujui';
			$message =
				"
				";
		}

		$this->sendEmail($subject, $message, $email);
	}
	function sendEmail($subject, $message,  $email_pengaju)
	{

		// Config email
		$this->load->library('PHPMailer_load'); //Load Library PHPMailer
		$mail = $this->phpmailer_load->load(); // Mendefinisikan Variabel Mail
		$mail->isSMTP();  // Mengirim menggunakan protokol SMTP
		$mail->Host = 'smtp.gmail.com'; // Host dari server SMTP
		$mail->SMTPAuth = true; // Autentikasi SMTP
		$mail->Username = 'sarapanapp@gmail.com';
		$mail->Password = 'rfwrxdjqmfbthrxp';
		$mail->SMTPSecure = 'tls';
		$mail->Port = 587;
		$mail->setFrom('e-sarapan@gmail.com', 'E-Sarapan'); // Sumber email
		$mail->addAddress($email_pengaju, $email_pengaju); // Alamat tujuan
		$mail->Subject = $subject; // Subjek Email

		$mail->msgHtml($message);

		if (!$mail->send()) {
			$response = [
				'code' => 404,
				'status' => true
			];

			echo json_encode($response);
		} else {

			$response = [
				'code' => 200,
				'status' => true
			];

			echo json_encode($response);
		}
	}
}
