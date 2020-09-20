<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paket_pekerjaan extends Member_Controller {
    private $kode_menu = 'jam-kerja-aman-daftar';
    private $kelompok = 'jam_kerja';
    private $url = 'manager/paket_pekerjaan';
    
    function __construct(){
        parent:: __construct();
        $this->load->model('paket_pekerjaan_model');
        $this->load->model('cbt_user_grup_model');
        parent::cek_akses($this->kode_menu);
    }
    
    function secToHR($seconds) {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds / 60) % 60);
        $seconds = $seconds % 60;
        return "$hours Jam $minutes Menit $seconds Detik";
    }
    
    public function index($page=null, $id=null){
        $data['kode_menu'] = $this->kode_menu;
        $data['url'] = $this->url;
        
        //Query ke tabel perusahaan
        $select = '';
        $query_mitra = $this->paket_pekerjaan_model->get_master_mitra();
        if($query_mitra->num_rows()>0){
            $select = '<option value="">--PILIH--</option>';
            $query_mitra = $query_mitra->result();
            foreach ($query_mitra as $temp) {
                $select = $select.'<option value="'.$temp->mitra_id.'">'.$temp->mitra_nama.'</option>';
            }
            
        }else{
            $select = '<option value="">KOSONG</option>';
        }
        
        //Divisi//
        $lv = $this->session->userdata("cbt_level");
        $dv = $this->session->userdata("divisi");
        $query_divisi = $this->cbt_user_grup_model->get_divisi();
        
        if($query_divisi->num_rows()>0){
            $select_divisi = '<option value="">-- PILIH LOKASI --</option>';
            $query_divisi = $query_divisi->result();
            foreach ($query_divisi as $temp) {
                if($lv=='admin')
                    $select_divisi = $select_divisi.'<option value="'.$temp->nama.'">'.$temp->nama.'</option>';
                    else if($dv==$temp->divisi_id)
                        $select_divisi = $select_divisi.'<option value="'.$temp->nama.'">'.$temp->nama.'</option>';
            }
            
        }else{
            $select_divisi = '<option value="100000">KOSONG</option>';
        }
        $data['select_divisi'] = $select_divisi;
        
        $data['select_perusahaan'] = $select;
        //Query ke tabel perusahaan
        
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

        $this->template->display_admin($this->kelompok.'/paket_pekerjaan_view', 'Daftar Paket Pekerjaan', $data);
    }
    
    
    function get($id=null){
        $data['kode_menu'] = $this->kode_menu;
        $data['url'] = $this->url;
        if(!empty($id)){
            $query = $this->paket_pekerjaan_model->get_by_kolom('paket_pekerjaan_id', $id);
            if($query->num_rows()>0){
                $query = $query->row();
                $data['paket_pekerjaan_id'] = $query->paket_pekerjaan_id;
                $data['paket_pekerjaan_nama'] = $query->paket_pekerjaan_nama;
                $data['paket_pekerjaan_alamat'] = $query->paket_pekerjaan_alamat;
                $data['paket_pekerjaan_aktif'] = $query->paket_pekerjaan_aktif;
            }
        }
        $select = '';
        $query_mitra = $this->paket_pekerjaan_model->get_master_mitra();
        if($query_mitra->num_rows()>0){
            $select = '<option value="">--PILIH--</option>';
            $query_mitra = $query_mitra->result();
            foreach ($query_mitra as $temp) {
                $select = $select.'<option value="'.$temp->mitra_id.'">'.$temp->mitra_nama.'</option>';
            }
            
        }else{
            $select = '<option value="0">KOSONG</option>';
        }
        
        $data['select_perusahaan'] = $select;
        
        $this->template->display_admin($this->kelompok.'/mitra_paket_pekerjaan_view', $query->paket_pekerjaan_nama, $data);
    }
    
    function get_pekerja($id=null){
        $data['kode_menu'] = $this->kode_menu;
        $data['url'] = $this->url;
        if(!empty($id)){
            $query = $this->paket_pekerjaan_model->get_by_kolom('paket_pekerjaan_id', $id);
            if($query->num_rows()>0){
                $query = $query->row();
                $data['paket_pekerjaan_id'] = $query->paket_pekerjaan_id;
                $data['paket_pekerjaan_nama'] = $query->paket_pekerjaan_nama;
                $data['paket_pekerjaan_alamat'] = $query->paket_pekerjaan_alamat;
                $data['paket_pekerjaan_aktif'] = $query->paket_pekerjaan_aktif;
            }
        }        
        
        $this->template->display_admin($this->kelompok.'/pekerja_paket_pekerjaan_view', $query->paket_pekerjaan_nama, $data);
    }
    
    function tambah(){
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('paket_pekerjaan_nama', 'Nama Proyek','required|strip_tags');
        $this->form_validation->set_rules('paket_pekerjaan_alamat', 'Alamat Proyek','required|strip_tags');
        $this->form_validation->set_rules('paket_pekerjaan_aktif', 'Aktif','required|strip_tags');
        
        if($this->form_validation->run() == TRUE){
            $data['paket_pekerjaan_nama'] = $this->input->post('paket_pekerjaan_nama', true);
            $data['paket_pekerjaan_alamat'] = $this->input->post('paket_pekerjaan_alamat', true);
            $data['paket_pekerjaan_aktif'] = $this->input->post('paket_pekerjaan_aktif', true);
            $data['created_date'] = date('Y-m-d H:i:s');
            $data['created_by'] = $this->session->userdata('username');
            $data['updated_date'] = date('Y-m-d H:i:s');
            $data['updated_by'] = $this->session->userdata('username');
            
            $this->paket_pekerjaan_model->save($data);
            
            $status['status'] = 1;
            $status['pesan'] = 'Data berhasil disimpan ';
            
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }
        
        echo json_encode($status);
    }
    
    function tambahperusahaan(){
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('paket_pekerjaan_id', 'Nama Proyek','required|strip_tags');
        $this->form_validation->set_rules('mitra_id', 'Perusahaan','required|strip_tags');
        
        if($this->form_validation->run() == TRUE){
            $data['paket_pekerjaan_id'] = $this->input->post('paket_pekerjaan_id', true);
            $data['mitra_id'] = $this->input->post('mitra_id', true);
            $data['created_date'] = date('Y-m-d H:i:s');
            $data['created_by'] = $this->session->userdata('username');
            $data['updated_date'] = date('Y-m-d H:i:s');
            $data['updated_by'] = $this->session->userdata('username');
            
            $this->paket_pekerjaan_model->addperusahaan($data);
            
            $status['status'] = 1;
            $status['pesan'] = 'Data berhasil disimpan ';
            
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }
        
        echo json_encode($status);
    }
    
    
    function get_by_id($id=null){
        $data['data'] = 0;
        if(!empty($id)){
            $query = $this->paket_pekerjaan_model->get_by_kolom('paket_pekerjaan_id', $id);
            if($query->num_rows()>0){
                $query = $query->row();
                $data['data'] = 1;
                $data['paket_pekerjaan_id'] = $query->paket_pekerjaan_id;
                $data['paket_pekerjaan_nama'] = $query->paket_pekerjaan_nama;
                $data['paket_pekerjaan_alamat'] = $query->paket_pekerjaan_alamat;
                $data['paket_pekerjaan_aktif'] = $query->paket_pekerjaan_aktif;
            }
        }
        echo json_encode($data);
    }
    
    function hapusmitra(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id_pekerjaan_mitra', 'Data Mitra','required|strip_tags');
        
        $mitra_pekerjaan = $this->input->post('id_pekerjaan_mitra', TRUE);
        if($this->form_validation->run() == TRUE){
            // Memulai transaction mysql
            $this->db->trans_start();
            
            // hapus topik di database
            $this->paket_pekerjaan_model->deleteperusahaan('paket_pekerjaan_perusahaan_id', $mitra_pekerjaan);
            
            // Menutup transaction mysql
            $this->db->trans_complete();
            
            $status['status'] = 1;
            $status['pesan'] = 'Berhasil dihapus';
        }else{
            $status['status'] = 0;
            $status['pesan'] = 'Tidak berhasil dihapus';
        }
        
        echo json_encode($status);
    }
    
    function hapus(){
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('paket_pekerjaan_id[]', 'punishment','required|strip_tags');
        if($this->form_validation->run() == TRUE){
            $punishment_id = $this->input->post('paket_pekerjaan_id', TRUE);
            $error_hapus = 0;
            foreach( $punishment_id as $kunci => $isi ) {
                if($isi=="on"){
                    // Memulai transaction mysql
                    $this->db->trans_start();
                    
                    // hapus topik di database
                    $this->paket_pekerjaan_model->delete('paket_pekerjaan_id', $kunci);
                    
                    // Menutup transaction mysql
                    $this->db->trans_complete();
                    
                }
                
            }
            $status['status'] = 1;
            if($error_hapus>0){
                $status['pesan'] = 'Sebagian tidak dapat dihapus karena masih digunakan Tes !';
            }else{
                $status['pesan'] = 'Berhasil dihapus';
            }
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }
        
        echo json_encode($status);
    }
    
    function edit(){
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('edit_paket_pekerjaan_nama', 'Nama Proyek','required|strip_tags');
        $this->form_validation->set_rules('edit_paket_pekerjaan_alamat', 'Alamat Proyek','required|strip_tags');
        $this->form_validation->set_rules('edit_paket_pekerjaan_aktif', 'Aktif','required|strip_tags');
        
        if($this->form_validation->run() == TRUE){
            $pilihan = $this->input->post('edit-pilihan', true);
            $id = $this->input->post('edit_paket_pekerjaan_id', true);
            
            if($pilihan=='hapus'){//hapus
                
                // hapus topik di database
                $this->paket_pekerjaan_model->delete('paket_pekerjaan_id', $id);
                
                $status['status'] = 1;
                $status['pesan'] = 'Berhasil dihapus !';
                
            }else if($pilihan=='simpan'){//simpan
                $data['paket_pekerjaan_nama'] = $this->input->post('edit_paket_pekerjaan_nama', true);
                $data['paket_pekerjaan_alamat'] = $this->input->post('edit_paket_pekerjaan_alamat', true);
                $data['paket_pekerjaan_aktif'] = $this->input->post('edit_paket_pekerjaan_aktif', true);
                $data['updated_date'] = date('Y-m-d H:i:s');
                $data['updated_by'] = $this->session->userdata('username');
                
                $this->paket_pekerjaan_model->update('paket_pekerjaan_id', $id, $data);
                
                $status['status'] = 1;
                $status['pesan'] = 'Data Berhasil disimpan';
            }
            
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }
        
        echo json_encode($status);
    }
    
    
    
    function get_datatable(){
        // variable initialization
        $modul = $this->input->get('modul');
        
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
        
        // run query
        $query = $this->paket_pekerjaan_model->get_datatable($start, $rows, 'paket_pekerjaan_nama', $search);
        $iFilteredTotal = $query->num_rows();
        
        $iTotal= $this->paket_pekerjaan_model->get_datatable_count('paket_pekerjaan_nama', $search, $modul)->row()->hasil;
        
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
            //$record[] = $this->paket_pekerjaan_model->get_count_pekerja($temp->paket_pekerjaan_id)->row()->jml_pekerja;
            $jmAktif = $this->paket_pekerjaan_model->get_count_pekerja_aktif($temp->paket_pekerjaan_id)->row()->jml_pekerja;
            if($jmAktif > 0)
                $record[] = '<a href="'.site_url()."/".$this->url.'/get_pekerja/'.$temp->paket_pekerjaan_id.'">'.$jmAktif."</a>";
            else
                $record[] = $jmAktif;
                
            $record[] = ($temp->paket_pekerjaan_aktif > 0 ? "Aktif" : "Tidak Aktif");
            
            $record[] = '<a onclick="edit(\''.$temp->paket_pekerjaan_id.'\')" style="cursor: pointer;" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i> Edit data</a>'
                . '<br><br><a href="'.base_url().'index.php/manager/paket_pekerjaan/get/'.$temp->paket_pekerjaan_id.'" style="cursor: pointer;" class="btn btn-default btn-xs"><i class="fa fa-plus"></i> Tambah Mitra</a>';
                $record[] = '<input type="checkbox" name="paket_pekerjaan_id['.$temp->paket_pekerjaan_id.']" >';
                
                $output['aaData'][] = $record;
        }
        // format it to JSON, this output will be displayed in datatable
        
        echo json_encode($output);
    }
    
    function get_datatable_mitra($id = null){
        // variable initialization
        $modul = $this->input->get('modul');
        
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
        
        // run query
        $query = $this->paket_pekerjaan_model->get_all_perusahaan($id);
        
        // get result after running query and put it in array
        $i=$start;
        $query = $query->result();
        
        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => count($query),
            "iTotalDisplayRecords" => count($query),
            "aaData" => array()
        );
        //var_dump($query);die();
        
        foreach ($query as $temp) {
            $record = array();
            
            $record[] = ++$i;
            $record[] = $temp->mitra_nama;
            
            $record[] = '<a onclick="hapus(\''.$temp->paket_pekerjaan_perusahaan_id.'\')" style="cursor: pointer;" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> Hapus</a>';
            $record[] = '<input type="checkbox" name="paket_pekerjaan_perusahaan_id['.$temp->paket_pekerjaan_perusahaan_id.']" >';
                
                $output['aaData'][] = $record;
        }
        // format it to JSON, this output will be displayed in datatable
        
        echo json_encode($output);
    }
    
    
    function get_datatable_pekerja_aktif($id = null){
        // variable initialization
        $modul = $this->input->get('modul');
        
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
        
        // run query
        $query = $this->paket_pekerjaan_model->get_pekerja_aktif($id, $start, $rows, 'cbt_user.user_firstname', $search);
        
        // get result after running query and put it in array
        $i=$start;
        $query = $query->result();
        
        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => count($query),
            "iTotalDisplayRecords" => count($query),
            "aaData" => array()
        );
        //var_dump($query);die();
        
        foreach ($query as $temp) {
            $record = array();
            
            $record[] = ++$i;
            $record[] = $temp->nama_pekerja;
            $record[] = $temp->jam_masuk;
            
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
    
    
    function absen_pekerja_masuk($id,$id_paket_pekerjaan){
        $data = array();
        $query = $this->paket_pekerjaan_model->get_by_kolom_pekerja('id', $id);
        $query2 = $this->paket_pekerjaan_model->get_by_kolom('paket_pekerjaan_id', $id_paket_pekerjaan);
        if($query != null){
            if($query2 != null){
                $query3 = $this->paket_pekerjaan_model->get_count_pekerja_aktif_kolom($id_paket_pekerjaan, $id);
                if($query3->row()->jml_pekerja > 0){
                    $data['status'] = 0;
                    $data['pesan'] = "Pekerja ".$query->row()->user_firstname." belum absen keluar";
                }else{
                    $this->db->trans_start();
                    $data['paket_pekerjaan_id'] = $id_paket_pekerjaan;
                    $data['cbt_user_id'] = $id;
                    $data['jam_masuk'] = date("Y-m-d H:i:s");
                    $data['pic_masuk'] = $this->session->userdata('username');;
                    
                    $masukId = $this->paket_pekerjaan_model->absen_masuk($data);
                    $this->db->trans_complete();
                    $data['status'] = 1;
                    $data['pesan'] = "Absen Masuk : ".$data['jam_masuk'] ;
                    $data['data']['Id Absen'] =  $masukId;
                    $data['data']['Nama Pekerja'] =  $query->row()->user_firstname;
                    $data['data']['Paket Pekerja'] =  $query2->row()->paket_pekerjaan_nama;
                    $data['data']['Jam Masuk'] =  $data['jam_masuk'];
                    
                }
            }else{
                $data['status'] = 0;
                $data['pesan'] = "Data Paket pekerjaan tidak ada";
            }
        }else{
            $data['status'] = 0;
            $data['pesan'] = "Data Pekerja tidak ada";
            
        }
        echo json_encode($data);
        redirect('/home/absen', 'refresh');
    }
    
    function absen_pekerja_keluar($id,$id_paket_pekerjaan,$id_absen){
        $data = array();
        $query = $this->paket_pekerjaan_model->get_by_kolom_pekerja('id', $id);
        $query2 = $this->paket_pekerjaan_model->get_by_kolom('paket_pekerjaan_id', $id_paket_pekerjaan);
        if($query != null){
            if($query2 != null){
                $query3 = $this->paket_pekerjaan_model->get_count_pekerja_aktif_kolom($id_paket_pekerjaan, $id);
                if($query3->row()->jml_pekerja > 0){
                    $queryAbsen = $this->paket_pekerjaan_model->get_absen('paket_pekerjaan_pekerja_id', $id_absen);
                    if($queryAbsen->row() != null){
                        $this->db->trans_start();
                        $jamMasuk = $queryAbsen->row()->jam_masuk;
                        $jamKeluar = date("Y-m-d H:i:s");
                        $diff = strtotime($jamKeluar) - strtotime($jamMasuk);
                        $data['paket_pekerjaan_id'] = $id_paket_pekerjaan;
                        $data['cbt_user_id'] = $id;
                        $data['jam_keluar'] = $jamKeluar;
                        $data['detik_aktif'] = floor($diff);
                        $data['pic_keluar'] = $this->session->userdata('username');;
                        
                        $this->paket_pekerjaan_model->absen_keluar($id_absen, $data);
                        $this->db->trans_complete();
                        $data['status'] = 1;
                        $data['pesan'] = "Absen Keluar : ".$data['jam_keluar'] ;
                        $data['data']['Nama Pekerja'] =  $query->row()->user_firstname;
                        $data['data']['Paket Pekerja'] =  $query2->row()->paket_pekerjaan_nama;
                        $data['data']['Jam Masuk'] =  $queryAbsen->row()->jam_masuk;
                        $data['data']['Jam Keluar'] =  $data['jam_keluar'];
                    }else{
                        $data['status'] = 0;
                        $data['pesan'] = "Data Absen pekerja tidak ada";
                    }
                }else{
                    $data['status'] = 0;
                    $data['pesan'] = "Pekerja ".$query->row()->user_firstname." sudah absen keluar";
                    
                }
            }else{
                $data['status'] = 0;
                $data['pesan'] = "Data Paket pekerjaan tidak ada";
            }
        }else{
            $data['status'] = 0;
            $data['pesan'] = "Data Pekerja tidak ada";
            
        }
        
        echo json_encode($data);
        redirect('/home/absen', 'refresh');
    }
    
    
}