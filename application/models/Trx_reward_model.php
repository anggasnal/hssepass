<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* ZYA CBT
* Achmad Lutfi
* achmdlutfi@gmail.com
* achmadlutfi.wordpress.com
*/
class Trx_reward_model extends CI_Model{
	public $table = 'trx_reward';
	
	function __construct(){
        parent::__construct();
    }
	
    function save($data){
        $this->db->insert($this->table, $data);
    }
    
    function delete($kolom, $isi){
        $this->db->where($kolom, $isi)
                 ->delete($this->table);
    }
    
    function update($kolom, $isi, $data){
        $this->db->where($kolom, $isi)
                 ->update($this->table, $data);
    }

    function count_all(){
        $this->db->select('COUNT(*) AS hasil')
                 ->from($this->table);
        return $this->db->get();
    }

    function get_master_reward(){
        $this->db->select('*')
                 ->from("reward");
        return $this->db->get();
    }

    function get_master_jabatan(){
        $this->db->select('*')
                 ->from("jabatan");
        return $this->db->get();
    }

    function get_master_mitra(){
        $this->db->select('*')
                 ->from("m_mitra");
        return $this->db->get();
    }

    function get_master_cbt_user(){
        $this->db->select('*')
                 ->from("cbt_user")
				 ->where('is_internal = 0');
        return $this->db->get();
    }

    function get_master_cbt_user_haveid_card(){
        $this->db->select('*')
                 ->from("cbt_user")
				 ->where("nomor_pass IS NOT NULL AND qr_code IS NOT NULL");
        return $this->db->get();
    }
    
	function get_by_kolom($kolom, $isi){
        $this->db->select('trx_reward.trx_reward_id, a.id as user_id, m_mitra.mitra_id, jabatan.jabatan_id, trx_reward.tgl_validasi, b.user_firstname as validator, trx_reward.reward, trx_reward.filename,a.foto')
				 ->where('('.$kolom.' = "'.$isi.'")')
                 ->from($this->table)
				 ->join('cbt_user a', 'a.id = trx_reward.user_id', 'left')
				 ->join('m_mitra', 'm_mitra.mitra_id = trx_reward.mitra_id', 'left')
				 ->join('jabatan', 'jabatan.jabatan_id = trx_reward.jabatan_id', 'left')
				 ->join('cbt_user b', 'b.id = trx_reward.validator', 'left');
        return $this->db->get();
    }

    /*function get_by_kolom_join_modul($kolom, $isi){
        $this->db->select('cbt_topik.*, cbt_modul.*')
                 ->join('cbt_modul', 'cbt_topik.topik_modul_id = cbt_modul.modul_id')
                 ->from($this->table)
                 ->where($kolom, $isi);
        return $this->db->get();
    }

    function get_all(){
        $this->db->from($this->table)
                 ->order_by('topik_id', 'ASC');
        return $this->db->get();
    }
	
	function get_by_kolom_limit($kolom, $isi, $limit){
        $this->db->where($kolom, $isi)
                 ->from($this->table)
				 ->limit($limit);
        return $this->db->get();
    }*/
	
	function get_datatable($start, $rows, $kolom, $isi){
		$this->db->select('trx_reward.trx_reward_id, a.user_firstname, m_mitra.mitra_nama, jabatan.user_jabatan, trx_reward.tgl_validasi, b.user_firstname as validator, trx_reward.reward,a.foto')
				 ->where('('.$kolom.' LIKE "%'.$isi.'%")')
                 ->from($this->table)
				 ->join('cbt_user a', 'a.id = trx_reward.user_id', 'left')
				 ->join('m_mitra', 'm_mitra.mitra_id = trx_reward.mitra_id', 'left')
				 ->join('jabatan', 'jabatan.jabatan_id = trx_reward.jabatan_id', 'left')
				 ->join('cbt_user b', 'b.username = trx_reward.validator', 'left')
				 ->order_by($kolom, 'ASC')
                 ->limit($rows, $start);
        return $this->db->get();
	}
    
    function get_datatable_count($kolom, $isi){
		$this->db->select('COUNT(*) AS hasil')
                 ->where('('.$kolom.' LIKE "%'.$isi.'%")')
				 ->join('cbt_user a', 'a.id = trx_reward.user_id', 'left')
				 ->join('m_mitra', 'm_mitra.mitra_id = trx_reward.mitra_id', 'left')
				 ->join('jabatan', 'jabatan.jabatan_id = trx_reward.jabatan_id', 'left')
				 ->join('cbt_user b', 'b.username = trx_reward.validator', 'left')
                 ->from($this->table);
        return $this->db->get();
	}
}