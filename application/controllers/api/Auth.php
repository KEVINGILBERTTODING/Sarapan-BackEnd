<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller Auth
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

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('users_model');
		$this->load->model('biodata_model');
	}

	public function login()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$validate = $this->users_model->login($email);
		if ($validate != null) {
			if (password_verify($password, $validate['password'])) {
				$response = [
					'code' => 200,
					'user_id' => $validate['id'],
					'nama' => $validate['name'],
					'role' => $validate['level']
				];
				echo json_encode($response);
			} else {
				$response = [
					'code' => 404,
					'message' => 'Password salah'
				];
				echo json_encode($response);
			}
		} else {
			$response = [
				'code' => 404,
				'message' => 'Email belum terdaftar'
			];
			echo json_encode($response);
		}
	}


	public function register()
	{
		$email = $this->input->post('email');
		$validate = $this->users_model->login($email);
		if ($validate == null) {
			$dataBiodata = [
				'id_user' => $this->users_model->getMaxId(),
				'telepon' => $this->input->post('telepon')
			];
			$data = [
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'username' => $this->input->post('username'),
				'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
				'level' => 'User',
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s')

			];

			$register = $this->users_model->register($data, $dataBiodata);
			if ($register == true) {
				$insertBiodata =  $this->biodata_model->insert($dataBiodata);
				if ($insertBiodata == true) {
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
			} else {
				$response = [
					'code' => 404,
					'message' => 'Terjadi kesalahan'
				];
				echo json_encode($response);
			}
		} else {
			$response = [
				'code' => 404,
				'message' => 'Email telah terdaftar'
			];
			echo json_encode($response);
		}
	}
}


/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */
