<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Biodate_model
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

class Biodata_model extends CI_Model
{

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
	}

	public function insert($dataBiodata)
	{
		$insert =  $this->db->insert('biodata', $dataBiodata);
		if ($insert) {
			return true;
		} else {
			return false;
		}
	}

	public function getBiodataById($id)
	{
		$this->db->select('*');
		$this->db->from('biodata');
		$this->db->where('id_user', $id);
		return $this->db->get()->row_array();
	}
}

/* End of file Biodate_model.php */
/* Location: ./application/models/Biodate_model.php */
