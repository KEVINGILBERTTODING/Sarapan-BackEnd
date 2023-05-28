<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Kategori_model
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

class Kategori_model extends CI_Model
{

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
	}

	public function getAllKategoriById($id)
	{
		$this->db->select('*');
		$this->db->from('kategori');
		$this->db->where('id_bidang', $id);
		return $this->db->get()->result();
	}

	public function getAllKategori()
	{
		$this->db->select('*');
		$this->db->from('kategori');
		$this->db->join('kategori_bidang', 'kategori_bidang.id_bidang = kategori.id_bidang', 'left');
		return $this->db->get()->result();
	}
}

/* End of file Kategori_model.php */
/* Location: ./application/models/Kategori_model.php */
