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

	public function getMyAspirasi($id)
	{
		$this->db->select('aspirasi.*, aspirasi_detail.*, dewan.*, kategori.*, users.*');
		$this->db->from('aspirasi');
		$this->db->join('aspirasi_detail', 'aspirasi_detail.id_aspirasi = aspirasi.id_aspirasi', 'left');
		$this->db->join('dewan', 'dewan.id_dewan = aspirasi.id_dewan', 'left');
		$this->db->join('kategori', 'kategori.id_kategori = aspirasi.id_kategori', 'left');
		$this->db->join('users', 'users.id = aspirasi.id_user', 'left');
		$this->db->where('id_user', $id);
		$this->db->order_by('aspirasi.id_aspirasi', 'desc');

		return $this->db->get()->result();
	}

	public function getAspirasiDewanById($id, $status)
	{
		$this->db->select('aspirasi.*, aspirasi_detail.*, dewan.*, kategori.*, users.*');
		$this->db->from('aspirasi');
		$this->db->join('aspirasi_detail', 'aspirasi_detail.id_aspirasi = aspirasi.id_aspirasi', 'left');
		$this->db->join('dewan', 'dewan.id_dewan = aspirasi.id_dewan', 'left');
		$this->db->join('kategori', 'kategori.id_kategori = aspirasi.id_kategori', 'left');
		$this->db->join('users', 'users.id = aspirasi.id_user', 'left');
		$this->db->where('aspirasi.id_dewan', $id);
		$this->db->where('aspirasi_detail.status_aspirasi', $status);
		$this->db->order_by('aspirasi.id_aspirasi', 'desc');
		return $this->db->get()->result();
	}

	public function getAspirasiModerator($status)
	{
		$this->db->select('*');
		$this->db->from('aspirasi');
		$this->db->join('aspirasi_detail', 'aspirasi_detail.id_aspirasi = aspirasi.id_aspirasi', 'left');
		$this->db->join('users', 'users.id = aspirasi.id_user', 'left');
		$this->db->join('dewan', 'dewan.id_dewan = aspirasi.id_dewan', 'left');
		$this->db->join('biodata', 'biodata.id_user = aspirasi.id_user', 'left');
		$this->db->join('kategori', 'kategori.id_kategori = aspirasi.id_kategori', 'left');
		$this->db->where('aspirasi_detail.status_aspirasi', $status);
		$this->db->order_by('aspirasi.id_aspirasi', 'desc');
		return $this->db->get()->result();
	}

	public function updateAspirasi($id, $dataAspirasi)
	{
		$this->db->where('id_aspirasi', $id);
		$update = $this->db->update('aspirasi_detail', $dataAspirasi);
		if ($update) {
			return true;
		} else {
			return false;
		}
	}
}
