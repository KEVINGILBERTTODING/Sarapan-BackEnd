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
		$this->load->model('biodata_model');
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

		$email = $this->input->post('email');

		$subject = 'no-reply';
		$message =
			"
				<b> PERHATIAN JANGAN MEMBALAS EMAIL INI </b>
				<hr>
				<br>
				<p>Terima kasih atas partisipasi anda, anda telah berhasil mengajukan Aspirasi pada
				tanggal " . date('d-m-Y') . " . <br><br><br>

				<b> Sarapan App </b>
				";

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
				'status' => false,
				'message' => 'Gagal mengirim notifikasi email'
			];

			echo json_encode($response);
		} else {
			$userId = $this->input->post('user_id');

			$config['upload_path']          = './uploads/lampiran/';
			$config['allowed_types']        = 'jpg|png|jpeg';


			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('lampiran')) {
				$response = [
					'code' => 404,
					'message' => 'Format file tidak sesuai'
				];
				echo json_encode($response);
			} else {

				$data = array('upload_data' => $this->upload->data());


				$file_name = $data['upload_data']['file_name'];
				$source_path = './uploads/lampiran/' . $data['upload_data']['file_name'];
				$dir_path = $_SERVER['DOCUMENT_ROOT'] . '/sarapan/esarapan/public/lampiran/';
				if (!is_dir($dir_path)) {
					mkdir($dir_path, 0777, true);
				}

				$destination_path = $dir_path . $file_name;

				if (file_exists($source_path)) {
					if (copy($source_path, $destination_path)) {
					} else {
						$response = [
							'code' => 404,
							'message' => 'Terjadi kesalahan'
						];
						echo json_encode($response);
					}
				}

				$dataAspirasi = [
					'id_user' => $userId,
					'id_kategori' => $this->input->post('id_kategori'),
					'id_dewan' => $this->input->post('id_dewan'),
					'uraian_aspirasi' => $this->input->post('uraian_aspirasi'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')

				];

				$dataDetAspirasi = [
					'id_aspirasi' => $this->aspirasi_model->getMaxId(),
					'alamat' => $this->input->post('alamat'),
					'kecamatan' => $this->input->post('kecamatan'),
					'kelurahan' => $this->input->post('kelurahan'),
					'rt' => $this->input->post('rt'),
					'rw' => $this->input->post('rw'),
					'lampiran' => $file_name,
					'tanggal' => date('Y-m-d'),
					'status_aspirasi' => 'Pending'
				];

				$insert =  $this->aspirasi_model->insertAspirasi($dataAspirasi, $dataDetAspirasi);
				if ($insert == true) {
					$response = [
						'code' => 200
					];
					echo json_encode($response);
				} else {
					$response = [
						'code' => 404,
						'message' => 'Terjadi kesalahan'
					];
					echo json_encode($response);
				}
			}
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

	public function getBiodataByUserId()
	{
		$userId = $this->input->get('user_id');
		echo json_encode($this->biodata_model->getBiodataById($userId));
	}

	public function getMyAspirasi()
	{
		$userId = $this->input->get('user_id');
		echo json_encode($this->aspirasi_model->getMyAspirasi($userId));
	}

	public function getAspirasiDewanById()
	{
		$userId = $this->input->get('dewan_id');
		$status = $this->input->get('status');
		echo json_encode($this->aspirasi_model->getAspirasiDewanById($userId, $status));
	}

	public function editPassword()
	{
		$userId = $this->input->post('user_id');
		$oldPassword = $this->input->post('old_password');
		$newPassword = $this->input->post('new_password');
		$dataUser = $this->users_model->getUserById($userId);
		if (password_verify($oldPassword, $dataUser['password'])) {
			$dataPassword = [
				'password' => password_hash($newPassword, PASSWORD_DEFAULT),
				'updated_at' => date('Y-m-d H:i:s')
			];


			$updatePassword = $this->users_model->updateUser($userId, $dataPassword);
			if ($updatePassword == true) {
				$response = [
					'code' => 200,

				];
				echo json_encode($response);
			} else {
				$response = [
					'code' => 404,
					'message' => 'Gagal mengubah password'

				];
				echo json_encode($response);
			}
		} else {
			$response = [
				'code' => 404,
				'message' => 'Password lama anda salah'
			];
			echo json_encode($response);
		}
	}

	public function getUserByUserId()
	{
		$id = $this->input->get('user_id');
		echo json_encode($this->users_model->getUserById2($id));
	}

	public function editProfile()
	{
		$userId = $this->input->post('user_id');
		$email = $this->input->post('email');
		$cekUsername = $this->users_model->login($email);
		if ($cekUsername != null) {
			if ($cekUsername['id'] == $userId) {
				$dataUsers = [
					'name' => $this->input->post('nama_lengkap'),
					'email' => $this->input->post('email'),
					'username' => $this->input->post('username'),
					'updated_at' => date('Y-m-d H:i:s')
				];

				$dataBiodata = [
					'no_ktp' => $this->input->post('no_ktp'),
					'no_kk' => $this->input->post('no_kk'),
					'telepon' => $this->input->post('telepon'),
					'alamat_rumah' => $this->input->post('alamat_rumah')

				];

				$trans = $this->users_model->updateProfile($userId, $dataUsers, $dataBiodata);
				if ($trans == true) {
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
			} else {
				$response = [
					'code' => 404,
					'message' => 'Email telah digunakan'
				];
				echo json_encode($response);
			}
		} else {

			$dataUsers = [
				'name' => $this->input->post('nama_lengkap'),
				'email' => $this->input->post('email'),
				'username' => $this->input->post('username'),
				'updated_at' => date('Y-m-d H:i:s')
			];

			$dataBiodata = [
				'no_ktp' => $this->input->post('no_ktp'),
				'no_kk' => $this->input->post('no_kk'),
				'telepon' => $this->input->post('telepon'),
				'alamat_rumah' => $this->input->post('alamat_rumah')

			];

			$trans = $this->users_model->updateProfile($userId, $dataUsers, $dataBiodata);
			if ($trans == true) {
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
	}
}


/* End of file User.php */
/* Location: ./application/controllers/User.php */
