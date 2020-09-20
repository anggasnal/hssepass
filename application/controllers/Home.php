<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* ZYA CBT
* Achmad Lutfi
* achmdlutfi@gmail.com
* achmadlutfi.wordpress.com
*/
class Home extends Tes_Controller {
	private $kelompok = 'home';
	private $url = 'Home';
	
    function __construct(){
		parent:: __construct();
		$this->load->model('cbt_user_model');
		$this->load->model('cbt_user_grup_model');
		$this->load->model('cbt_tes_model');
		$this->load->model('cbt_tes_token_model');
		$this->load->model('cbt_tes_topik_set_model');
		$this->load->model('paket_pekerjaan_model');
		$this->load->model('cbt_tes_user_model');
		$this->load->model('cbt_tesgrup_model');
		$this->load->model('cbt_soal_model');
		$this->load->model('cbt_jawaban_model');
		$this->load->model('cbt_tes_soal_model');
		$this->load->model('cbt_tes_soal_jawaban_model');
	}
    
    public function index(){
        $this->load->helper('form');
        $data['nama'] = $this->access_tes->get_nama();
        $data['group'] = $this->access_tes->get_group();
        $data['url'] = $this->url;
        $data['timestamp'] = strtotime(date('Y-m-d H:i:s'));
		$data['userlevel'] = $this->session->userdata('cbt_level');
		$data['token'] = base64_encode(base64_encode(date('s:i:H')."##".$this->session->userdata('username')."##".$this->session->userdata('password')."##".date('Y-m-d H:i:s')));
        $username = $this->access_tes->get_username();
        $id = $this->cbt_user_model->get_by_kolom_limit('username', $username, 1)->row()->id;
        $query_tes = $this->cbt_tes_user_model->get_by_user_status($id);
        if($query_tes->num_rows()>0){
        	$query_tes = $query_tes->result();
        	$tanggal = new DateTime();
        	foreach ($query_tes as $tes) {
        		// Cek apakah tes sudah melebihi batas waktu
            	$tanggal_tes = new DateTime($tes->tesuser_creation_time);
            	$tanggal_tes->modify('+'.$tes->tes_duration_time.' minutes');
            	if($tanggal>$tanggal_tes){
            		// jika waktu sudah melebihi waktu ketentuan, maka status tes diubah menjadi 4
            		$data_tes['tesuser_status']=4;
            		$this->cbt_tes_user_model->update('tesid', $tes->tesid, $data_tes);
            	}
        	}
        }


        $this->template->display_home($this->kelompok.'/home', 'Dashboard', $data);
    }
    
    public function designkartu(){
        $this->load->view('home/design');
    }
    
    public function cobaqr(){
        $config = array();
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './uploads/'; //string, the default is application/cache/
        $config['errorlog']     = './uploads/'; //string, the default is application/logs/
        $config['imagedir']     = './uploads/qrcode/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '124'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
        
        $params = array();
        $params['data'] = date("Ym")."000211111"; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$params['data'].".jpg"; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params);
        echo "<img src='".base_url().$config['imagedir'].$params['data'].".jpg"."' >";
    }
    
    
    public function absen(){
        
        $query_pekerjaan = $this->paket_pekerjaan_model->get_datatable(0, 100, 'paket_pekerjaan_alamat', '');
        if($query_pekerjaan->num_rows()>0){
            $select_divisi = '<option value="">-- PILIH PROYEK --</option>';
            $query_divisi = $query_pekerjaan->result();
            foreach ($query_divisi as $temp) {
                 $select_divisi = $select_divisi.'<option value="'.$temp->paket_pekerjaan_id.'">'.$temp->paket_pekerjaan_nama.'</option>';
            }
            
        }else{
            $select_divisi = '<option value="">KOSONG</option>';
        }
        $data['select_divisi'] = $select_divisi;
        
        $query = $this->cbt_user_model->get_datatable(0, 100, 'user_firstname', '', 'semua');
        if($query->num_rows()>0){
            $select_pekerja = '<option value="">-- PILIH NAMA --</option>';
            $query_pekerja = $query->result();
            foreach ($query_pekerja as $temp) {
                $select_pekerja = $select_pekerja.'<option value="'.$temp->id.'">'.$temp->user_firstname.'</option>';
            }
            
        }else{
            $select_pekerja = '<option value="">KOSONG</option>';
        }
        $data['select_perkerja'] = $select_pekerja;
        
        $data['absensi'] = $this->paket_pekerjaan_model->get_data_pekerja_aktif()->result();
        $this->template->display_admin($this->kelompok.'/absensi', 'Absensi', $data);
    }
    
    
}