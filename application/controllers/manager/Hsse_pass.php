<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ZYA CBT
 * Achmad Lutfi
 * achmdlutfi@gmail.com
 * achmadlutfi.wordpress.com
 */
class Hsse_pass extends Member_Controller {
    private $kode_menu = 'tes-cetak-hsse';
    private $kelompok = 'tes';
    private $url = 'manager/hsse_pass';
    
    function __construct(){
        parent:: __construct();
        $this->load->model('cbt_user_model');
        $this->load->model('cbt_user_grup_model');
        $this->load->model('cbt_tes_model');
        $this->load->model('cbt_tes_token_model');
        $this->load->model('cbt_tes_topik_set_model');
        $this->load->model('cbt_tes_user_model');
        $this->load->model('cbt_tesgrup_model');
        $this->load->model('cbt_soal_model');
        $this->load->model('cbt_jawaban_model');
        $this->load->model('cbt_tes_soal_model');
        $this->load->model('cbt_tes_soal_jawaban_model');
        $this->load->model('hsse_pass_model');
        
        parent::cek_akses($this->kode_menu);
    }
    
    public function index(){
        $data['kode_menu'] = $this->kode_menu;
        $data['url'] = $this->url;
        $this->template->display_admin($this->kelompok.'/tes_peserta_daftar_view', 'Daftar Peserta', $data);
    }
    
    public function save_pass(){
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('user_id', 'Perserta','required|strip_tags');
        $this->form_validation->set_rules('tesuser_id[]', 'Data Tes','required|strip_tags');
        $data = array();
        $status = array();
        if($this->form_validation->run() == TRUE){
            $now = date("Y-m-d H:i:s");
            $exp = date('Y-m-d', strtotime("+6 months", strtotime($now)));
            $idUserTes = implode(",", $this->input->post('tesuser_id', true));
            
            $data['user_id'] = $this->input->post('user_id', true);
            $data['date_created'] = $now;
            $data['user_created'] = $this->session->userdata('username');
            $data['date_expired'] = $exp;
            $data['testuser_id'] = $idUserTes;
            
            $this->hsse_pass_model->save($data);
            $nomor = $this->hsse_pass_model->generate_nomor($this->input->post('user_id', true));
            
            $status['status'] = 1;
            $status['pesan'] = 'Data berhasil disimpan dengan nomor '.$nomor;
            
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }
        
        echo json_encode($status);
    }
    
    public function get($id=null){
        $data['kode_menu'] = $this->kode_menu;
        $data['url'] = $this->url;
        
        $tanggal_awal = date('Y-m-d H:i', strtotime('- 6 month'));
        $tanggal_akhir = date('Y-m-d H:i', strtotime('+ 1 days'));
        
        $data['rentang_waktu'] = $tanggal_awal.' - '.$tanggal_akhir;
        $data['data_user'] = $this->cbt_user_model->get_by_kolom('id', $id)->row();
        
        $data['hsse_pass'] = $this->hsse_pass_model->get_by_kolom_limit('user_id', $id, 1)->row();
        
        $this->template->display_admin($this->kelompok.'/tes_hasil_cetak', 'Hasil Tes', $data);
    }
    
    
    function get_datatable_peserta(){
        // variable initialization
        $search = "";
        $start = 0;
        $rows = 10;
        
        // get search value (if any)
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
            $search = $_GET['sSearch'];
        }
        
        // limit
        $start = $this->get_start();
        $rows = $this->get_rows();
        
        // run query to get user listing
        $query = $this->cbt_user_model->get_datatable($start, $rows, 'user_firstname', $search, 'semua');
        $iFilteredTotal = $query->num_rows();
        
        $iTotal= $this->cbt_user_model->get_datatable_count('user_firstname', $search, 'semua')->row()->hasil;
        
        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iTotal,
            "aaData" => array()
        );
        
        // get result after running query and put it in array
        $i=$start;
        $query = $query->result();
        foreach ($query as $temp) {
            $record = array();
            
            $record[] = ++$i;
            $record[] = $temp->username;
            $record[] = $temp->user_firstname;
            
            $query_group = $this->cbt_user_grup_model->get_by_kolom_limit('grup_id', $temp->user_grup_id, 1)->row();
            
            $record[] = $query_group->grup_nama;
            
            $record[] = '<a href="'.base_url().'index.php/manager/hsse_pass/get/'.$temp->id.'" style="cursor: pointer;" class="btn btn-default btn-xs">Lihat Hasil</a>';
            
            $output['aaData'][] = $record;
        }
        // format it to JSON, this output will be displayed in datatable
        
        echo json_encode($output);
    }
    
    
    /**
     * Tabel Ujian
     *
     *
     */
    
    function get_datatable($id = null){
        // variable initialization
        $tes_id = $this->input->get('tes');
        $grup_id = $this->input->get('group');
        $urutkan = $this->input->get('urutkan');
        $waktu = $this->input->get('waktu');
        $tanggal = explode(" - ", $waktu);
        
        $search = "";
        $start = 0;
        $rows = 50;
        
        // get search value (if any)
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
            $search = $_GET['sSearch'];
        }
        
        // limit
        $start = $this->get_start();
        $rows = $this->get_rows();
        
        // run query to get user listing
        $query = $this->cbt_tes_user_model->get_datatable($start, $rows, $tes_id, $grup_id, $urutkan, $tanggal, $id);
        $iFilteredTotal = $query->num_rows();
        
        $iTotal= $this->cbt_tes_user_model->get_datatable_count($tes_id, $grup_id, $urutkan, $tanggal, $id)->row()->hasil;
        
        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iTotal,
            "aaData" => array()
        );
        
        // get result after running query and put it in array
        $i=$start;
        $query = $query->result();
        foreach ($query as $temp) {
            $record = array();
            $ymd = $temp->tesuser_creation_time;
			 
			$timestamp = strtotime($ymd);
			 
			//Convert it to DD-MM-YYYY
			$dmy = date("d M Y", $timestamp);
            $record[] = ++$i;
            $record[] = $dmy;
            $record[] = $temp->tes_duration_time.' menit';
            $record[] = $temp->topik_nama;
            $record[] = $temp->grup_nama;
            $record[] = stripslashes($temp->user_firstname);
            $record[] = $temp->nilai;
            if($temp->tesuser_status==1){
                $tanggal = new DateTime();
                // Cek apakah tes sudah melebihi batas waktu
                $tanggal_tes = new DateTime($temp->tesuser_creation_time);
                $tanggal_tes->modify('+'.$temp->tes_duration_time.' minutes');
                if($tanggal>$tanggal_tes){
                    $record[] = 'Selesai';
                }else{
                    $tanggal = $tanggal_tes->diff($tanggal);
                    $menit_sisa = ($tanggal->h*60)+($tanggal->i);
                    $record[] = 'Berjalan (-'.$menit_sisa.' menit)';
                }
            }else{
                $record[] = 'Selesai<input type="hidden" name="tesuser_id[]" value="'.$temp->tesuser_id.'">';
            }
            
            
            $output['aaData'][] = $record;
        }
        // format it to JSON, this output will be displayed in datatable
        
        echo json_encode($output);
    }
    
    function get_start() {
        $start = 0;
        if (isset($_GET['iDisplayStart'])) {
            $start = intval($_GET['iDisplayStart']);
            
            if ($start < 0)
                $start = 0;
        }
        
        return $start;
    }
    
    function get_rows() {
        $rows = 10;
        if (isset($_GET['iDisplayLength'])) {
            $rows = intval($_GET['iDisplayLength']);
            if ($rows < 5 || $rows > 500) {
                $rows = 10;
            }
        }
        
        return $rows;
    }
    
    function get_sort_dir() {
        $sort_dir = "ASC";
        $sdir = strip_tags($_GET['sSortDir_0']);
        if (isset($sdir)) {
            if ($sdir != "asc" ) {
                $sort_dir = "DESC";
            }
        }
        
        return $sort_dir;
    }
}
?>