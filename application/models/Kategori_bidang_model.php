<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Kategori_bidang_model
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

class Kategori_bidang_model extends CI_Model
{

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
	}

	public function getAllKategoriBidang()
	{
		$this->db->select('*');
		$this->db->from('kategori_bidang');
		return $this->db->get()->result();
	}
}

/* End of file Kategori_bidang_model.php */
/* Location: ./application/models/Kategori_bidang_model.php */
