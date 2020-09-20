<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* ZYA CBT
* Achmad Lutfi
* achmdlutfi@gmail.com
* achmadlutfi.wordpress.com
*/
class Cbt_user_grup_model extends CI_Model{
	public $table = 'cbt_user_grup';
	public $tbl = 'm_mitra';
	public $tbl_jabatan = 'jabatan';
	
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
    
    function count_by_kolom($kolom, $isi){
        $this->db->select('COUNT(*) AS hasil')
                 ->where($kolom, $isi)
                 ->from($this->table);
        return $this->db->get();
    }
	
	function get_by_kolom($kolom, $isi){
        $this->db->where($kolom, $isi)
                 ->from($this->table);
        return $this->db->get();
    }
	
	function get_by_kolom_limit($kolom, $isi, $limit){
        $this->db->where($kolom, $isi)
                 ->from($this->table)
				 ->limit($limit);
        return $this->db->get();
    }
	
	function get_jabatan($kolom, $isi, $limit){
        $this->db->where($kolom, $isi)
                 ->from($this->tbl_jabatan)
				 ->limit($limit);
        return $this->db->get();
    }
	
	function get_mitra_by_id($kolom, $isi, $limit){
        $this->db->where($kolom, $isi)
                 ->from($this->tbl)
				 ->limit($limit);
        return $this->db->get();
    }

    function get_group(){
        $this->db->from($this->table)
                 ->order_by('grup_id', 'ASC');
        return $this->db->get();
    }

    function get_mitra(){
        $this->db->from($this->tbl)
                 ->order_by('mitra_nama', 'ASC');
		$this->db->where('(status = "1")');
        return $this->db->get();
    }

    function get_divisi(){
        $this->db->from('divisi')
                 ->order_by('nama', 'ASC');
        return $this->db->get();
    }
	
	function get_datatable($start, $rows, $kolom, $isi){
		$this->db->where('('.$kolom.' LIKE "%'.$isi.'%")')
                 ->from($this->table)
				 ->order_by($kolom, 'ASC')
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