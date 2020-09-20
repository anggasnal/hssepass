<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cbt_tes_token_model extends CI_Model{
	public $table = 'cbt_tes_token';
	
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

    function delete_by_user_date($id){
        $this->db->where('DATE(token_ts)<DATE(NOW()) AND token_id="'.$id.'"')
                 ->delete($this->table);
    }
    
    function update($kolom, $isi, $data){
        $this->db->where($kolom, $isi)
                 ->update($this->table, $data);
    }
    
    function count_by_kolom($kolom, $isi){
        $this->db->select('COUNT(*) AS hasil')
                 ->where($kolom, $isi)
                 ->from($this->table);
        return $this->db->get();
    }

    function count_by_isi($isi){
        $this->db->select('COUNT(*) AS hasil')
                 ->where('token_isi="'.$isi.'" AND DATE(token_ts)=DATE(NOW())')
                 ->from($this->table);
        return $this->db->get();
    }
	
	function get_by_kolom($kolom, $isi){
        $this->db->select('token_id,token_isi,token_id,token_ts,token_aktif')
                 ->where($kolom, $isi)
                 ->from($this->table);
        return $this->db->get();
    }

    /**
     * Mendapatkan token berdasarkan token dan tanggal hari ini
     */
    function get_by_token_now_limit($token, $limit){
        $this->db->select('token_id,token_isi,token_id,token_ts,token_aktif')
                 ->where('(token_isi="'.$token.'" AND DATE(token_ts)=DATE(NOW()))')
                 ->from($this->table)
				 ->limit($limit);
        return $this->db->get();
    }

    // Mendapatkan jumlah token berdasarkan lifetime token yang sudah di generate
    function count_by_token_lifetime($token, $lifetime){
        $this->db->select('COUNT(*) AS hasil')
                 ->where('token_isi="'.$token.'" AND token_ts>TIMESTAMPADD(MINUTE,-'.$lifetime.',NOW())')
                 ->from($this->table);
        return $this->db->get();
    }
	
	function get_by_kolom_limit($kolom, $isi, $limit){
        $this->db->select('token_id,token_isi,token_id,token_ts,token_aktif')
                 ->where($kolom, $isi)
                 ->from($this->table)
				 ->limit($limit);
        return $this->db->get();
    }

    function get_by_user_now($id){
        $sql = 'SELECT GROUP_CONCAT("\'",token_isi,"\'") AS token FROM cbt_tes_token WHERE token_id="'.$id.'" AND DATE(token_ts)=DATE(NOW()) ORDER BY token_id ASC';

        return $this->db->query($sql);
    }
	
	function get_datatable($start, $rows, $kolom, $isi){
		$this->db->where('('.$kolom.' LIKE "%'.$isi.'%")')
                 ->from($this->table)
				 ->order_by('token_id', 'DESC')
                 ->limit($rows, $start);
        return $this->db->get();
	}
    
    function get_datatable_count($kolom, $isi){
		$this->db->select('COUNT(*) AS hasil')
                 ->where('('.$kolom.' LIKE "%'.$isi.'%")')
                 ->from($this->table);
        return $this->db->get();
	}
}