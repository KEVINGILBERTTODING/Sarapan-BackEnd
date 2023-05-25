<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Kecamatan_model
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

class Kecamatan_model extends CI_Model
{

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
	}

	public function getAllKecamatan()
	{
		$this->db->select('*');
		$this->db->from('indonesia_districts');
		return $this->db->get()->result();
	}
}

/* End of file Kecamatan_model.php */
/* Location: ./application/models/Kecamatan_model.php */
