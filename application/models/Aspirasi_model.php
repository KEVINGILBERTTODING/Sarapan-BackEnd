<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Aspirasi_model
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

class Aspirasi_model extends CI_Model
{

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
	}

	// ------------------------------------------------------------------------


	// ------------------------------------------------------------------------
	public function getHistoryAspirasi($userId)
	{

		$this->db->select('aspirasi.*, aspirasi_detail.*');
		$this->db->from('aspirasi');
		$this->db->where('id_user', $userId);
		$this->db->join('aspirasi_detail', 'aspirasi_detail.id_aspirasi = aspirasi.id_aspirasi', 'left');
		return $this->db->get()->result();
	}

	public function getMaxId()
	{
		$query = $this->db->select_max('id_aspirasi')
			->from('aspirasi')
			->get();
		$result = $query->row();

		if ($result->id_aspirasi == null) {
			return 1;
		} else {
			return $result->id_aspirasi + 1;
		}
	}

	public function insertAspirasi($dataAspirasi, $dataDetAspirasi)
	{

		$this->db->trans_start();
		$this->db->insert('aspirasi', $dataAspirasi);
		$this->db->insert('aspirasi_detail', $dataDetAspirasi);
		$this->db->trans_complete();
		if ($this->db->trans_status() == TRUE) {
			return true;
		} else {
			return false;
		}
	}
}
