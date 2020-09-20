<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Paket_pekerjaan_model extends CI_Model{
    public $table = 'paket_pekerjaan';
    
    function __construct(){
        parent::__construct();
    }
    
    function save($data){
        $this->db->insert($this->table, $data);
    }
    
    function absen_masuk($data){
        $this->db->insert('paket_pekerjaan_pekerja', $data);
        $insert_id = $this->db->insert_id();
        
        return  $insert_id;
    }
    
    function absen_keluar($id,$data){
        $this->db->where('paket_pekerjaan_pekerja_id', $id)
        ->update('paket_pekerjaan_pekerja', $data);
    }
    
    function addperusahaan($data){
        $this->db->insert('paket_pekerjaan_perusahaan', $data);
    }
    
    function deleteperusahaan($kolom,$id){
        $this->db->where($kolom, $id)
        ->delete('paket_pekerjaan_perusahaan');
    }
    
    function get_all_perusahaan($id){
        $this->db->select('paket_pekerjaan_perusahaan.paket_pekerjaan_perusahaan_id,m_mitra.mitra_nama')
        ->from('paket_pekerjaan_perusahaan')
        ->join($this->table,'paket_pekerjaan_perusahaan.paket_pekerjaan_id = paket_pekerjaan.paket_pekerjaan_id')
        ->join('m_mitra','paket_pekerjaan_perusahaan.mitra_id = m_mitra.mitra_id')
        ->where('paket_pekerjaan_perusahaan.paket_pekerjaan_id', $id)
        ->order_by('m_mitra.mitra_nama', 'ASC');
        return $this->db->get();
    }
    
    function get_count_perusahaan($id){
        $this->db->select('COUNT(paket_pekerjaan_perusahaan.paket_pekerjaan_perusahaan_id) AS jml_mitra')
        ->from('paket_pekerjaan_perusahaan')
        ->join($this->table,'paket_pekerjaan_perusahaan.paket_pekerjaan_id = paket_pekerjaan.paket_pekerjaan_id')
        ->join('m_mitra','paket_pekerjaan_perusahaan.mitra_id = m_mitra.mitra_id')
        ->where('paket_pekerjaan_perusahaan.paket_pekerjaan_id', $id);
        return $this->db->get();
    }
    
    function get_count_pekerja_aktif($id, $kolom = "cbt_user.user_firstname", $isi = ""){
        $this->db->select('COUNT(DISTINCT paket_pekerjaan_pekerja.cbt_user_id) AS jml_pekerja')
        ->from('paket_pekerjaan_pekerja')
        ->join($this->table,'paket_pekerjaan_pekerja.paket_pekerjaan_id = paket_pekerjaan.paket_pekerjaan_id')
        ->join('cbt_user','paket_pekerjaan_pekerja.cbt_user_id = cbt_user.id')
        ->where('paket_pekerjaan_pekerja.paket_pekerjaan_id', $id)
        ->where("$kolom  LIKE '%$isi%'")
        ->where('paket_pekerjaan_pekerja.jam_masuk IS NOT NULL', NULL, FALSE)
        ->where('paket_pekerjaan_pekerja.jam_keluar IS NULL', NULL, FALSE);
        return $this->db->get();
    }
    
    function get_pekerja_aktif($id, $start=0, $rows=1000, $kolom = "cbt_user.user_firstname", $isi = ""){
        $this->db->select('paket_pekerjaan_pekerja.paket_pekerjaan_pekerja_id AS id,paket_pekerjaan_pekerja.paket_pekerjaan_id as id_pekerjaan,paket_pekerjaan_pekerja.cbt_user_id AS user_id,paket_pekerjaan.paket_pekerjaan_nama as nama_proyek,cbt_user.user_firstname as nama_pekerja, paket_pekerjaan_pekerja.jam_masuk as jam_masuk')
        ->from('paket_pekerjaan_pekerja')
        ->join($this->table,'paket_pekerjaan_pekerja.paket_pekerjaan_id = paket_pekerjaan.paket_pekerjaan_id')
        ->join('cbt_user','paket_pekerjaan_pekerja.cbt_user_id = cbt_user.id')
        ->where('paket_pekerjaan_pekerja.paket_pekerjaan_id', $id)
        ->where("$kolom  LIKE '%$isi%'")
        ->where('paket_pekerjaan_pekerja.jam_masuk IS NOT NULL', NULL, FALSE)
        ->where('paket_pekerjaan_pekerja.jam_keluar IS NULL', NULL, FALSE)
        ->limit($rows, $start);
        return $this->db->get();
    }
    
    function get_count_paket_aktif($kolom = "paket_pekerjaan_pekerja.pic_masuk", $isi = ""){
        $this->db->select('COUNT(DISTINCT(paket_pekerjaan.paket_pekerjaan_id)) AS hasil')
        ->from($this->table)
        ->join('paket_pekerjaan_pekerja','paket_pekerjaan.paket_pekerjaan_id = paket_pekerjaan_pekerja.paket_pekerjaan_id')
        ->where("$kolom  LIKE '%$isi%'")
        ->where('paket_pekerjaan_pekerja.jam_masuk IS NOT NULL', NULL, FALSE)
        ->where('paket_pekerjaan_pekerja.jam_keluar IS NULL', NULL, FALSE);
        return $this->db->get();
    }
    
    function get_paket_aktif($start=0, $rows=1000, $kolom = "paket_pekerjaan_pekerja.pic_masuk", $isi = ""){
        $this->db->distinct()
        ->select('paket_pekerjaan.*, (SELECT COUNT(paket_pekerjaan_pekerja.paket_pekerjaan_pekerja_id) FROM paket_pekerjaan_pekerja WHERE paket_pekerjaan_pekerja.paket_pekerjaan_id = paket_pekerjaan.paket_pekerjaan_id AND paket_pekerjaan_pekerja.jam_masuk IS NOT NULL AND paket_pekerjaan_pekerja.jam_keluar IS NULL) as jmlAktif')
        ->from($this->table)
        ->join('paket_pekerjaan_pekerja','paket_pekerjaan.paket_pekerjaan_id = paket_pekerjaan_pekerja.paket_pekerjaan_id')
        ->where("$kolom  LIKE '%$isi%'")
        ->where('paket_pekerjaan_pekerja.jam_masuk IS NOT NULL', NULL, FALSE)
        ->where('paket_pekerjaan_pekerja.jam_keluar IS NULL', NULL, FALSE)
        ->limit($rows, $start);
        return $this->db->get();
    }
    
    function get_data_pekerja_aktif(){
        $this->db->select('paket_pekerjaan_pekerja.paket_pekerjaan_pekerja_id AS id,paket_pekerjaan_pekerja.paket_pekerjaan_id as id_pekerjaan,paket_pekerjaan_pekerja.cbt_user_id AS user_id,paket_pekerjaan.paket_pekerjaan_nama as nama_proyek,cbt_user.user_firstname as nama_pekerja, paket_pekerjaan_pekerja.jam_masuk as jam_masuk')
        ->from('paket_pekerjaan_pekerja')
        ->join($this->table,'paket_pekerjaan_pekerja.paket_pekerjaan_id = paket_pekerjaan.paket_pekerjaan_id')
        ->join('cbt_user','paket_pekerjaan_pekerja.cbt_user_id = cbt_user.id')
        ->where('paket_pekerjaan_pekerja.jam_masuk IS NOT NULL', NULL, FALSE)
        ->where('paket_pekerjaan_pekerja.jam_keluar IS NULL', NULL, FALSE);
        return $this->db->get();
    }
    
    function get_jam_kerja_aman(){
        $this->db->select('SUM(detik_aktif) AS detik_kerja_aman')
        ->from('paket_pekerjaan_pekerja');
        return $this->db->get();
    }
    
    
    function get_sum_pekerja_aktif(){
        $this->db->select('COUNT(DISTINCT paket_pekerjaan_pekerja.cbt_user_id) AS total_pekerja_aktif')
        ->from('paket_pekerjaan_pekerja')
        ->join($this->table,'paket_pekerjaan_pekerja.paket_pekerjaan_id = paket_pekerjaan.paket_pekerjaan_id')
        ->join('cbt_user','paket_pekerjaan_pekerja.cbt_user_id = cbt_user.id')
        ->where('paket_pekerjaan_pekerja.jam_masuk IS NOT NULL', NULL, FALSE)
        ->where('paket_pekerjaan_pekerja.jam_keluar IS NULL', NULL, FALSE);
        return $this->db->get();
    }
    
    function get_sum_paket_aktif(){
        $this->db->select('COUNT(paket_pekerjaan_id) AS jml_aktif')
        ->from('paket_pekerjaan')
        ->where('paket_pekerjaan_aktif', 1);
        return $this->db->get();
    }
    
    
    function get_master_mitra(){
        $this->db->select('*')
        ->from("m_mitra");
        return $this->db->get();
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
        ->where($kolom, $isi, NULL, FALSE)
        ->from($this->table);
        return $this->db->get();
    }
    
    function get_all(){
        $this->db->from($this->table)
        ->order_by('paket_pekerjaan_id', 'DESC');
        return $this->db->get();
    }
    
    function get_by_kolom($kolom, $isi){
        $this->db->where($kolom, $isi)
        ->from($this->table);
        return $this->db->get();
    }
    
    function get_by_kolom_pekerja($kolom, $isi){
        $this->db->where($kolom, $isi)
        ->from('cbt_user');
        return $this->db->get();
    }
    
    function get_absen($kolom, $isi){
        $this->db->where($kolom, $isi)
        ->from('paket_pekerjaan_pekerja');
        return $this->db->get();
    }
    
    function get_count_pekerja_aktif_kolom($id,$id_pekerja){
        $this->db->select('COUNT(DISTINCT paket_pekerjaan_pekerja.cbt_user_id) AS jml_pekerja')
        ->from('paket_pekerjaan_pekerja')
        ->join($this->table,'paket_pekerjaan_pekerja.paket_pekerjaan_id = paket_pekerjaan.paket_pekerjaan_id')
        ->join('cbt_user','paket_pekerjaan_pekerja.cbt_user_id = cbt_user.id')
        ->where('paket_pekerjaan_pekerja.paket_pekerjaan_id', $id)
        ->where('cbt_user.id', $id_pekerja)
        ->where('paket_pekerjaan_pekerja.jam_masuk IS NOT NULL', NULL, FALSE)
        ->where('paket_pekerjaan_pekerja.jam_keluar IS NULL', NULL, FALSE);
        return $this->db->get();
    }
    
    function get_datatable($start, $rows, $kolom, $isi){
        $this->db->where('('.$kolom.' LIKE "%'.$isi.'%")')
        ->from($this->table)
        ->order_by('paket_pekerjaan_id', 'ASC')
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