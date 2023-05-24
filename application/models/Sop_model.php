<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Sop_model
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

class Sop_model extends CI_Model
{

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
	}

	public function getAllSop()
	{
		$this->db->select('*');
		$this->db->from('sop');
		return $this->db->get()->result();
	}
}

/* End of file Sop_model.php */
/* Location: ./application/models/Sop_model.php */
