<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller User
 *
 * This controller for ...
 *
 * @package   CodeIgniter
 * @category  Controller CI
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @author    Raul Guerrero <r.g.c@me.com>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class User extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('dewan_model');
		$this->load->model('sop_model');
		$this->load->model('sarpan_model');
		$this->load->model('users_model');
		$this->load->helper(array('email'));
		$this->load->library(array('email'));
		$this->load->model('aspirasi_model');
		$this->load->model('kecamatan_model');
		$this->load->model('villages_model');
		$this->load->model('kategori_bidang_model');
		$this->load->model('kategori_model');
	}

	public function getAllDewan()
	{
		echo json_encode($this->dewan_model->getAllDewan());
	}

	public function getAllSop()
	{
		echo json_encode($this->sop_model->getAllSop());
	}
	public function getSarpanValid()
	{
		echo json_encode($this->sarpan_model->getSarpanValid());
	}



	public function getUserById()
	{
		$userId = $this->input->get('user_id');
		echo json_encode($this->users_model->getUserById($userId));
	}

	public function insertSarapan()
	{

		$email = $this->input->post('email');

		$subject = 'no-reply';
		$message =
			"
				<b> PERHATIAN JANGAN MEMBALAS EMAIL INI </b>
				<hr>
				<br>
				<p>Terima kasih atas partisipasi anda, anda telah berhasil mengajukan Saran dan Harapan pada
				tanggal " . date('d-m-Y') . " . <br><br><br>

				<b> Sarapan App </b>
				";


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

			$data = [
				'id_user' => $this->input->post('user_id'),
				'uraian_sarpan' => $this->input->post('uraian_sarpan'),
				'tanggal' => date('Y-m-d'),
				'status_sarpan' => 'Pending',
			];

			$insert = $this->sarpan_model->insertSarapan($data);
			if ($insert == true) {
				$response = [
					'code' => 200,
					'status' => true
				];
				echo json_encode($response);
			} else {
				$response = [
					'code' => 404,
					'status' => false
				];
				echo json_encode($response);
			}
		}
	}

	public function getHistorySarpan()
	{
		$userId = $this->input->get('user_id');
		echo json_encode($this->sarpan_model->gethistorySarapan($userId));
	}

	public function getHistoryAspirasi()
	{
		$userId = $this->input->get('user_id');
		echo json_encode($this->aspirasi_model->getHistoryAspirasi($userId));
	}

	public function insertAspirasi()
	{
		$dataAspirasi = [
			'id_user' => '1'
		];

		$dataDetAspirasi = [
			'id_aspirasi' => $this->aspirasi_model->getMaxId()
		];

		$insert =  $this->aspirasi_model->insertAspirasi($dataAspirasi, $dataDetAspirasi);
		if ($insert == true) {
			$response = [
				'code' => 200
			];
			echo json_encode($response);
		} else {
			$response = [
				'code' => 404
			];
			echo json_encode($response);
		}
	}


	public function getDistrict()
	{
		echo json_encode($this->kecamatan_model->getAllKecamatan());
	}

	public function getVillagesById()
	{
		$id = $this->input->get('id');
		echo json_encode($this->villages_model->getVillagesById($id));
	}

	public function getAllKategoriBidang()
	{
		echo json_encode($this->kategori_bidang_model->getAllKategoriBidang());
	}

	public function getAllKategoriById()
	{
		$id = $this->input->get('id');
		echo json_encode($this->kategori_model->getAllKategoriById($id));
	}
}


/* End of file User.php */
/* Location: ./application/controllers/User.php */
