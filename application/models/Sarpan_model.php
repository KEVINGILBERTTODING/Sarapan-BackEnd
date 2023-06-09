<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Sarpan_model
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

class Sarpan_model extends CI_Model
{

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
	}

	public function getSarpanValid()
	{

		$this->db->select('sarpan.*, users.name');
		$this->db->from('sarpan');
		$this->db->where('sarpan.status_sarpan', 'Valid');
		$this->db->join('users', 'sarpan.id_user = users.id', 'left');
		$this->db->order_by('id_sarpan', 'desc');

		return $this->db->get()->result();
	}

	public function insertSarapan($data)
	{
		$insert = $this->db->insert('sarpan', $data);
		if ($insert) {
			return true;
		} else {
			return false;
		}
	}

	public function gethistorySarapan($userId)
	{
		$this->db->select('sarpan.*, users.name');
		$this->db->from('sarpan');
		$this->db->where('id_user', $userId);
		$this->db->join('users', 'sarpan.id_user = users.id', 'left');
		$this->db->order_by('id_sarpan', 'desc');
		return $this->db->get()->result();
	}

	public function getAllSarpanModerator($status)
	{
		$this->db->select('*');
		$this->db->from('sarpan');
		$this->db->where('sarpan.status_sarpan', $status);
		$this->db->join('users', 'users.id = sarpan.id_user', 'left');
		$this->db->order_by('sarpan.id_sarpan', 'desc');
		return $this->db->get()->result();
	}

	public function updateSarpan($id, $data)
	{
		$this->db->where('id_sarpan', $id);
		$update = $this->db->update('sarpan', $data);
		if ($update) {
			return true;
		} else {
			return false;
		}
	}

	public function getAllSarpanLaporanModerator($dateStart, $dateEnd)
	{
		$this->db->select('*');
		$this->db->from('sarpan');
		$this->db->join('users', 'users.id = sarpan.id_user', 'left');
		$this->db->where('sarpan.tanggal >=', $dateStart);
		$this->db->where('sarpan.tanggal <=', $dateEnd);
		$this->db->order_by('sarpan.id_sarpan', 'desc');
		return $this->db->get()->result();
	}

	public function getAllSarpanLaporanModerator2()
	{
		$this->db->select('*');
		$this->db->from('sarpan');
		$this->db->join('users', 'users.id = sarpan.id_user', 'left');
		$this->db->join('biodata', 'biodata.id_user = sarpan.id_user', 'left');
		$this->db->order_by('sarpan.id_sarpan', 'desc');
		return $this->db->get()->result();
	}
}
