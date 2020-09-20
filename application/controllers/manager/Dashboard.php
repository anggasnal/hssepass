<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Member_Controller {
    private $url = 'manager/dashboard';
    
    function __construct(){
        parent:: __construct();
        $this->load->model('paket_pekerjaan_model');
        $this->load->model('cbt_user_grup_model');
        $this->load->model('hsse_pass_model');
    }
    
    function secToHR($seconds) {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds / 60) % 60);
        $seconds = $seconds % 60;
        return "$hours J, $minutes M, $seconds D";
    }
    
    public function index(){
        $this->load->helper('form');
        $data['nama'] = $this->access->get_nama();
        $data['url'] = $this->url;
        
        $data['post_max_size'] = ini_get('post_max_size');
        $data['upload_max_filesize'] = ini_get('upload_max_filesize');
        $data['waktu_server'] = date('Y-m-d H:i:s');
        
        $dir1 = './public/uploads/';
        $dir2 = './uploads/';
        
        $data['dir_public_uploads'] = 'Not Writeable';
        if(is_writable($dir1)){
            $data['dir_public_uploads'] = 'Writeable';
        }
        
        $data['dir_uploads'] = 'Not Writeable';
        if(is_writable($dir2)){
            $data['dir_uploads'] = 'Writeable';
        }
        
        $queryPemegangKartu = $this->hsse_pass_model->get_datatable_count('user_id', '');
        $data['total_hsse_pass'] = $queryPemegangKartu->row()->hasil." Pekerja";
        
        $queryJamKerjaAman = $this->paket_pekerjaan_model->get_jam_kerja_aman();
        if($queryJamKerjaAman->row()->detik_kerja_aman > 0){
            $data['jam_kerja_aman'] = $this->secToHR($queryJamKerjaAman->row()->detik_kerja_aman);
        }else{
            $data['jam_kerja_aman'] = "0 <small>Jam</small> 00 <small>Menit</small> 00 <small>Detik</small> ";
        }
        
        $queryTotalPekerjaAktif = $this->paket_pekerjaan_model->get_sum_pekerja_aktif();
        $data['total_pekerja_aktif'] = $queryTotalPekerjaAktif->row()->total_pekerja_aktif." Pekerja";
        
        $queryAktif = $this->paket_pekerjaan_model->get_sum_paket_aktif();
        $data['total_aktif'] = $queryAktif->row()->jml_aktif." Paket pekerjaan";
        
        $query_divisi = $this->cbt_user_grup_model->get_divisi();
        $data['divisi'] = $query_divisi->result();
        
        $this->template->display_admin('manager/dashboard_view', 'Dashboard', $data);
    }
    
    
    function get_datatable(){
        // variable initialization
        $modul = $this->input->get('modul');
        
        $search = "";
        $start = 0;
        $rows = 5;
        
        // get search value (if any)
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
            
            $search = $_GET['sSearch'];
        }
        
        $q = "paket_pekerjaan_aktif = 1";
        
        // limit
        $start = $this->get_start();
        $rows = $this->get_rows();
        
        
        // run query
        $query = $this->paket_pekerjaan_model->get_datatable($start, $rows, 'paket_pekerjaan_nama', $search, $q);
        $iFilteredTotal = $query->num_rows();
        
        $iTotal= $this->paket_pekerjaan_model->get_datatable_count('paket_pekerjaan_nama', $search, $q)->row()->hasil;
        
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
            $string = '';
            $record[] = ++$i;
            $record[] = $temp->paket_pekerjaan_nama;
            $record[] = $temp->paket_pekerjaan_alamat;
            $record[] = $this->paket_pekerjaan_model->get_count_perusahaan($temp->paket_pekerjaan_id)->row()->jml_mitra;
            $jmAktif = $this->paket_pekerjaan_model->get_count_pekerja_aktif($temp->paket_pekerjaan_id)->row()->jml_pekerja;
            if($jmAktif > 0)
                $record[] = '<a href="'.site_url()."/manager/paket_pekerjaan/get_pekerja/".$temp->paket_pekerjaan_id.'">'.$jmAktif."</a>";
                else
                    $record[] = $jmAktif;
                    
                    $output['aaData'][] = $record;
        }
        // format it to JSON, this output will be displayed in datatable
        
        echo json_encode($output);
    }
    
    /**
     * funsi tambahan
     *
     *
     */
    
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
    
    
    function password(){
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('password-old', 'Password Lama','required|strip_tags');
        $this->form_validation->set_rules('password-new', 'Password Baru','required|strip_tags');
        $this->form_validation->set_rules('password-confirm', 'Confirm Password','required|strip_tags');
        
        if($this->form_validation->run() == TRUE){
            $old = $this->input->post('password-old', TRUE);
            $new = $this->input->post('password-new', TRUE);
            $confirm = $this->input->post('password-confirm', TRUE);
            
            $username = $this->access->get_username();
            
            if($this->users_model->get_user_count($username, $old)>0){
                if($new==$confirm){
                    $this->users_model->change_password($username, $new);
                    $status['status'] = 1;
                    $status['error'] = '';
                }else{
                    $status['status'] = 0;
                    $status['error'] = 'Kedua password baru tidak sama';
                }
            }else{
                $status['status'] = 0;
                $status['error'] = 'Password Lama tidak Sesuai';
            }
        }else{
            $status['status'] = 0;
            $status['error'] = validation_errors();
        }
        
        echo json_encode($status);
    }
}