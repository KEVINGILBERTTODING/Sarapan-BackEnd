<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Users_model
 *
 * This Model for ...
 * 
 * @package		CodeIgniter
 * @category	Model
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class Users_model extends CI_Model
{

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
	}

	public function login($email)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('email', $email);
		return $this->db->get()->row_array();
	}


	public function register($dataUser, $dataBiodata)
	{
		$insert	= $this->db->insert('users', $dataUser);

		if ($insert) {
			return true;
		} else {
			return false;
		}
	}

	// get max userid
	public function getMaxId()
	{
		$this->db->select_max('id');
		$this->db->from('users');
		$maxId = $this->db->get()->row_array();
		$result = $maxId['id'] + 1;
		return $result;
	}

	public function getUserById($userId)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('id', $userId);
		return $this->db->get()->row_array();
	}
}

/* End of file Users_model.php */
/* Location: ./application/models/Users_model.php */
