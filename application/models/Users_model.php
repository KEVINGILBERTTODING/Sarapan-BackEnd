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


	public function register($dataUser)
	{
		$register = $this->db->insert('users', $dataUser);
		if ($register) {
			return true;
		} else {
			return false;
		}
	}
}

/* End of file Users_model.php */
/* Location: ./application/models/Users_model.php */
