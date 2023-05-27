<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller Moderator
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

class Moderator extends CI_Controller
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
		$this->load->model('biodata_model');

		$this->load->helper(array('email'));
		$this->load->library(array('email'));
	}

	public function getAllSarpanModerator()
	{

		$jenis = $this->input->get('status');
		echo json_encode($this->sarpan_model->getAllSarpanModerator($jenis));
	}

	public function updateSarpan()
	{
		$idSarpan = $this->input->post('id_sarpan');
		$email = $this->input->post('email');
		$sarpan = $this->input->post('sarpan');
		$status = $this->input->post('status');
		$tanggal = $this->input->post('tanggal');

		if ($status == 'Valid') {
			$subject = 'Saran dan Harapan Anda Telah Divalidasi';
			$status2 = 'Valid';
			$message =
				"
					<b> PERHATIAN JANGAN MEMBALAS EMAIL INI </b>
					<hr>
					<br>
					<p>Berkaitan dengan saran dan harapan yang anda berikan kepada kami, pada tanggal $tanggal, kami telah memvalidasi saran dan harapan anda. Berikut adalah saran dan harapan anda yang telah kami validasi.</p>
					<br>
					<p> $sarpan </p>
					<br>
					<p>Terima kasih atas saran dan harapan yang anda berikan kepada kami.</p>
					<br>
					
	
					<b> Sarapan App </b>
					";
		} else {
			$subject = 'Saran dan Harapan Anda Tidak Divalidasi';
			$status2 = 'Tolak';
			$message =
				"
					<b> PERHATIAN JANGAN MEMBALAS EMAIL INI </b>
					<hr>
					<br>
					<p>Berkaitan dengan saran dan harapan yang anda berikan kepada kami, pada tanggal $tanggal, kami tidak dapat memvalidasi saran dan harapan anda. Berikut adalah saran dan harapan anda yang tidak kami validasi.</p>
					<br>
					<p> $sarpan </p>
					<br>
					<p>Terima kasih atas saran dan harapan yang anda berikan kepada kami.</p>
					<br>
					
	
					<b> Sarapan App </b>
					";
		}



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
		$mail->addAddress($email, $email); // Alamat tujuan
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
				'status_sarpan' => $status2
			];

			$update = $this->sarpan_model->updateSarpan($idSarpan, $data);
			if ($update == true) {
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

	public function getAllAspirasiModerator()
	{
		$status = $this->input->get('status');
		echo json_encode($this->aspirasi_model->getAspirasiModerator($status));
	}

	public function updateAspirasi()
	{
		$idAspirasi = $this->input->post('id_aspirasi');
		$email = $this->input->post('email');
		$aspirasi = $this->input->post('aspirasi');
		$status = $this->input->post('status');
		$tanggal = $this->input->post('tanggal');

		if ($status == 'Valid') {
			$subject = 'Aspirasi Anda Telah Disetujui';
			$status2 = 'Valid';
			$message =
				"
					<b> PERHATIAN JANGAN MEMBALAS EMAIL INI </b>
					<hr>
					<br>
					<p>Berkaitan dengan aspirasi yang anda berikan kepada kami, pada tanggal $tanggal, kami telah memvalidasi dan telah kami setujui. Berikut adalah aspirasi anda yang telah kami setujui.</p>
					<br>
					<p> $aspirasi </p>
					<br>
					<p>Terima kasih atas aspirasi yang anda berikan kepada kami.</p>
					<br>
					
	
					<b> Sarapan App </b>
					";
		} else {
			$subject = 'Aspirasi Anda Tidak Disetujui';
			$status2 = 'Non-Valid';
			$message =
				"
					<b> PERHATIAN JANGAN MEMBALAS EMAIL INI </b>
					<hr>
					<br>
					<p>Berkaitan dengan aspirasi yang anda berikan kepada kami, pada tanggal $tanggal, kami tidak dapat menyetujui aspirasi anda. Berikut adalah aspirasi anda yang tidak kami setujui.</p>
					<br>
					<p> $aspirasi </p>
					<br>
					<p>Terima kasih atas aspirasi yang anda berikan kepada kami.</p>
					<br>
					
	
					<b> Sarapan App </b>
					";
		}



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
		$mail->addAddress($email, $email); // Alamat tujuan
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
				'status_aspirasi' => $status2
			];

			$update = $this->aspirasi_model->updateAspirasi($idAspirasi, $data);
			if ($update == true) {
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

	public function getAspirasiLaporanModerator()
	{
		$dateStart = $this->input->get('date_start');
		$dateEnd = $this->input->get('date_end');
		echo json_encode($this->aspirasi_model->getAspirasiLaporanModerator($dateStart, $dateEnd));
	}

	public function getAllSarpanLaporanModerator()
	{
		$dateStart = $this->input->get('date_start');
		$dateEnd = $this->input->get('date_end');
		echo json_encode($this->sarpan_model->getAllSarpanLaporanModerator($dateStart, $dateEnd));
	}

	public function getAllAspirasiModerator2()
	{
		echo json_encode($this->aspirasi_model->getAllAspirasiModerator());
	}

	public function cetakLaporanAspirasi($dateStart, $dateEnd)
	{

		$this->load->library('pdflib');
		$this->pdflib->setFileName('Laporan_aspirasi.pdf');
		$this->pdflib->setPaper('A4', 'landscape');

		$data['date_start'] = $dateStart;
		$data['date_end'] = $dateEnd;
		$data['aspirasi'] = $this->aspirasi_model->getAspirasiLaporanModerator($dateStart, $dateEnd);

		$this->pdflib->loadView('v_laporan_aspirasi', $data);
	}

	public function getAllSarpanLaporanModerator2()
	{
		echo json_encode($this->sarpan_model->getAllSarpanLaporanModerator2());
	}

	public function cetakLaporanSarapan($dateStart, $dateEnd)
	{

		$this->load->library('pdflib');
		$this->pdflib->setFileName('Laporan_sarapan.pdf');
		$this->pdflib->setPaper('A4', 'landscape');
		$data['date_start'] = $dateStart;
		$data['date_end'] = $dateEnd;
		$data['sarapan'] = $this->sarpan_model->getAllSarpanLaporanModerator2($dateStart, $dateEnd);

		$this->pdflib->loadView('v_laporan_sarpan', $data);
	}
}


/* End of file Moderator.php */
/* Location: ./application/controllers/Moderator.php */
