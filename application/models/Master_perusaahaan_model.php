<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master_perusahaan_model extends CI_Model{
    public $table = 'master_perusahaan';
    
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
    
    function get_all(){
        $this->db->from($this->table)
        ->order_by('perusahaan_nama', 'ASC');
        return $this->db->get();
    }
    
    function get_by_kolom($kolom, $isi){
        $this->db->where($kolom, $isi)
        ->from($this->table);
        return $this->db->get();
    }
    
    function get_datatable($start, $rows, $kolom, $isi){
        $this->db->where('('.$kolom.' LIKE "%'.$isi.'%")')
        ->from($this->table)
        ->order_by('jawaban_id', 'ASC')
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