<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* ZYA CBT
* Achmad Lutfi
* achmdlutfi@gmail.com
* achmadlutfi.wordpress.com
*/
class Hsse_pass_model extends CI_Model{
	public $table = 'hsse_pass';
	
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
        $this->db->select('*')
                 ->where($kolom, $isi)
                 ->from($this->table);
        return $this->db->get();
    }
	
	function get_by_kolom_limit($kolom, $isi, $limit){
        $this->db->select('*')
                 ->where($kolom, $isi)
                 ->from($this->table)
				 ->limit($limit);
        return $this->db->get();
    }

	
	function get_datatable($start, $rows, $kolom, $isi){
        $query = '';
		$this->db->where('('.$kolom.' LIKE "%'.$isi.'%" '.$query.')')
                 ->from($this->table)
				 ->order_by($kolom, 'ASC')
                 ->limit($rows, $start);
        return $this->db->get();
	}
    
    function get_datatable_count($kolom, $isi){
        $query = '';
		$this->db->select('COUNT(*) AS hasil')
                 ->where('('.$kolom.' LIKE "%'.$isi.'%" '.$query.')')
                 ->from($this->table);
        return $this->db->get();
	}
	
	function generate_nomor($id){
	    $m = date("Ym");
	    $this->db->select('COUNT(*) AS jumlah')
	    ->where('(nomor_pass LIKE "'.$m.'%")')
	    ->from('cbt_user');
	    
	    $count = $this->db->get()->row()->jumlah;
	    $cek = 1;
	    $data = array();
	    $nomor = "";
	    while ($cek > 0){
	        $nomor = $m.(sprintf('%06d', ++$count));
    	    $this->db->select('COUNT(*) AS jumlah')
    	    ->where('(nomor_pass LIKE "'.$nomor.'")')
    	    ->from('cbt_user');
    	    $cek = $this->db->get()->row()->jumlah;
	    }
	    
	    $data['nomor_pass'] = $nomor;
	    $data['qr_code'] = $nomor.".jpg";
	    
	    $this->db->where('id', $id)->update('cbt_user', $data);
	    $this->generate_qr_code($nomor, $nomor.".jpg");
	    
	    return $nomor;
	}
	
	function generate_qr_code($nomor,$file){
	    $config = array();
	    $config['cacheable']    = true; //boolean, the default is true
	    $config['cachedir']     = './uploads/'; //string, the default is application/cache/
	    $config['errorlog']     = './uploads/'; //string, the default is application/logs/
	    $config['imagedir']     = './uploads/qrcode/'; //direktori penyimpanan qr code
	    $config['quality']      = true; //boolean, the default is true
	    $config['size']         = '120'; //interger, the default is 1024
	    $config['black']        = array(224,255,255); // array, default is array(255,255,255)
	    $config['white']        = array(70,130,180); // array, default is array(0,0,0)
	    $this->ciqrcode->initialize($config);
	    
	    $params = array();
	    $params['data'] = $nomor; //data yang akan di jadikan QR CODE
	    $params['level'] = 'H'; //H=High
	    $params['size'] = 10;
	    $params['savename'] = FCPATH.$config['imagedir'].$file; //simpan image QR CODE ke folder assets/images/
	    $this->ciqrcode->generate($params);
	}
	
}