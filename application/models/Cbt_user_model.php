<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* ZYA CBT
* Achmad Lutfi
* achmdlutfi@gmail.com
* achmadlutfi.wordpress.com
*/
class Cbt_user_model extends CI_Model{
	public $table = 'cbt_user';
	public $tbl = 'jabatan';
	
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
        $this->db->select('id,user_grup_id,username,password,mitra_id,no_tlp,no_ktp,alamat,gender,divisi_id,jabatan_id,email,user_level,is_internal,user_firstname,user_regdate, foto, nomor_pass, qr_code, emergency_phone, tglrapidtest, hasilrapidtest, lokasirapidtest')
                 ->where($kolom, $isi)
                 ->from($this->table);
        return $this->db->get();
    }
	
    
    function get_by_column_lengkap($kolom, $isi){
        $select = "cbt_user.id"
            .",cbt_user.id"
            .",cbt_user.user_grup_id"
            .",cbt_user_grup.grup_nama"
            .",cbt_user.username"
            .",cbt_user.mitra_id"
            .",m_mitra.mitra_nama"
            .",cbt_user.no_tlp"
            .",cbt_user.no_ktp"
            .",cbt_user.alamat"
            .",cbt_user.gender"
            .",cbt_user.divisi_id"
            .",divisi.nama as divisi_nama"
            .",cbt_user.jabatan_id"
            .",jabatan.description as jabatan_nama"
            .",cbt_user.email"
            .",cbt_user.user_level"
            .",cbt_user.is_internal"
            .",cbt_user.user_firstname"
            .",cbt_user.user_regdate"
            .",cbt_user.foto"
            .",cbt_user.nomor_pass"
            .",cbt_user.qr_code"
            .",cbt_user.emergency_phone"
            ;
            
            $this->db->select($select)
            ->join('cbt_user_grup', 'cbt_user.user_grup_id = cbt_user_grup.grup_id', 'left')
            ->join('m_mitra', 'cbt_user.mitra_id = m_mitra.mitra_id', 'left')
            ->join('divisi', 'cbt_user.divisi_id = divisi.divisi_id', 'left')
            ->join('jabatan', 'cbt_user.jabatan_id = jabatan.jabatan_id', 'left')
            ->where($kolom, $isi)
            ->from($this->table);
            return $this->db->get();
    }
	function get_by_kolom_limit($kolom, $isi, $limit){
        $this->db->select('id,user_grup_id,username,password,email,user_firstname,user_regdate, foto, nomor_pass, qr_code')
                 ->where($kolom, $isi)
                 ->from($this->table)
				 ->limit($limit);
        return $this->db->get();
    }

    function count_by_username_password($username, $password){
        $this->db->select('COUNT(*) AS hasil')
                 ->where('(username="'.$username.'" AND password="'.$password.'")')
                 ->from($this->table);
        return $this->db->get()->row()->hasil;  
    }

    function get_by_username($username){
        $this->db->join('cbt_user_grup', 'cbt_user.user_grup_id = cbt_user_grup.grup_id')
                 ->where('username',$username)
                 ->limit(1);
        $query = $this->db->get($this->table);
        return ($query->num_rows() > 0) ? $query->row() : FALSE;
    }
	
	function get_datatable($start, $rows, $kolom, $isi, $group){
        $query = '';
        if($group!='semua'){
            $query = 'AND user_grup_id='.$group;
        }
		$this->db->where('(username LIKE "%'.$isi.'%" OR user_firstname LIKE "%'.$isi.'%" OR mitra_nama LIKE "%'.$isi.'%" OR user_jabatan LIKE "%'.$isi.'%" OR grup_nama LIKE "%'.$isi.'%") '.$query.'')
                 ->from($this->table)
				 ->join('m_mitra', 'm_mitra.mitra_id = cbt_user.mitra_id', 'left')
				 ->join('jabatan', 'jabatan.jabatan_id = cbt_user.jabatan_id', 'left')
				 ->join('cbt_user_grup', 'cbt_user_grup.grup_id = cbt_user.user_grup_id', 'left')
				 ->order_by($kolom, 'ASC')
                 ->limit($rows, $start);
        return $this->db->get();
	}
    
    function get_datatable_count($kolom, $isi, $group){
        $query = '';
        if($group!='semua'){
            $query = 'AND user_grup_id='.$group;
        }
		$this->db->select('COUNT(*) AS hasil')
                 ->where('('.$kolom.' LIKE "%'.$isi.'%" '.$query.')')
                 ->from($this->table);
        return $this->db->get();
	}
	
    function get_jabatan_bygroup($str){
        $hasil=$this->db->query("SELECT * FROM jabatan WHERE cbt_user_group_id like '%$str%'");
        return $hasil->result();
    }
}