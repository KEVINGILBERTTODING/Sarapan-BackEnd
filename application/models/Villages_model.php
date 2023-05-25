<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Villages_model
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

class Villages_model extends CI_Model
{

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
	}

	public function getVillagesById($id)
	{
		$this->db->select('*');
		$this->db->from('indonesia_villages');
		$this->db->where('district_code', $id);
		return $this->db->get()->result();
	}
}

/* End of file Villages_model.php */
/* Location: ./application/models/Villages_model.php */
