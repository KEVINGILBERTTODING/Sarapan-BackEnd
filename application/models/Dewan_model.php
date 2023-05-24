<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Dewan_model
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

class Dewan_model extends CI_Model
{

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
	}

	public function getAllDewan()
	{
		$this->db->select('*');
		$this->db->from('dewan');
		return $this->db->get()->result();
	}
}

/* End of file Dewan_model.php */
/* Location: ./application/models/Dewan_model.php */
