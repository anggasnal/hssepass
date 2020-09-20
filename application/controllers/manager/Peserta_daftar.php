<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Peserta_daftar extends Member_Controller {
    private $kode_menu = 'peserta-daftar';
    private $kelompok = 'peserta';
    private $url = 'manager/peserta_daftar';
    
    function __construct(){
        parent:: __construct();
        $this->load->model('cbt_user_grup_model');
        $this->load->model('cbt_user_model');
        $this->load->model('users_model');
        
        parent::cek_akses($this->kode_menu);
    }
    
    public function index(){
        $data['kode_menu'] = $this->kode_menu;
        $data['url'] = $this->url;
        
        $query_group = $this->cbt_user_grup_model->get_group();
        
        if($query_group->num_rows()>0){
            $select = '';
            $query_group = $query_group->result();
            foreach ($query_group as $temp) {
                $select = $select.'<option value="'.$temp->grup_id.'">'.$temp->grup_nama.'</option>';
            }
            
        }else{
            $select = '<option value="100000">KOSONG</option>';
        }
        $data['select_group'] = $select;
        
        
        $query_mitra = $this->cbt_user_grup_model->get_mitra();
        
        if($query_mitra->num_rows()>0){
            $select_mitra = '';
            $query_mitra = $query_mitra->result();
            foreach ($query_mitra as $temp) {
                $select_mitra = $select_mitra.'<option value="'.$temp->mitra_id.'">'.$temp->mitra_nama.'</option>';
            }
            
        }else{
            $select_mitra = '<option value="100000">KOSONG</option>';
        }
        $data['select_mitra'] = $select_mitra;
        
        
        $query_divisi = $this->cbt_user_grup_model->get_divisi();
        
        if($query_divisi->num_rows()>0){
            $select_divisi = '';
            $query_divisi = $query_divisi->result();
            foreach ($query_divisi as $temp) {
                $select_divisi = $select_divisi.'<option value="'.$temp->divisi_id.'">'.$temp->nama.'</option>';
            }
            
        }else{
            $select_divisi = '<option value="100000">KOSONG</option>';
        }
        $data['select_divisi'] = $select_divisi; 
		$data['userlevel'] = $this->session->userdata('cbt_level');
        $this->template->display_admin($this->kelompok.'/peserta_daftar_view', 'Daftar Peserta', $data);
    }
    
    function tambah(){
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('tambah-username', 'Username','required|strip_tags');
        $this->form_validation->set_rules('tambah-password', 'Password','required|strip_tags');
        $this->form_validation->set_rules('tambah-nama', 'Nama Lengkap','required|strip_tags');
        $this->form_validation->set_rules('tambah-email', 'Email','strip_tags');
        $this->form_validation->set_rules('tambah-group', 'Group','required|strip_tags');
        $this->form_validation->set_rules('tambah-mitra', 'Mitra','strip_tags');
        $this->form_validation->set_rules('tambah-divisi', 'Divisi','strip_tags');
        $this->form_validation->set_rules('notlp', 'No Tlp','required|strip_tags');
        $this->form_validation->set_rules('jabatan', 'Jabatan','required|strip_tags');
        $this->form_validation->set_rules('noktp', 'No KTP','required|strip_tags');
        $this->form_validation->set_rules('alamat', 'Alamat','required|strip_tags');
// tambahan
        $this->form_validation->set_rules('tglrapidtest', 'tglrapidtest','required|strip_tags');
        $this->form_validation->set_rules('hasilrapidtest', 'hasilrapidtest','required|strip_tags');
        $this->form_validation->set_rules('lokasirapidtest', 'lokasirapidtest','required|strip_tags');
        
        if($this->form_validation->run() == TRUE){
            $data['username'] = $this->input->post('tambah-username', true);
            $data['password'] = md5($this->input->post('tambah-password', true));
            $data['email'] = $this->input->post('tambah-email', true);
            $data['user_firstname'] = $this->input->post('tambah-nama', true);
            $data['user_grup_id'] = $this->input->post('tambah-group', true);
            $data['jabatan_id'] = $this->input->post('jabatan', true);
            $data['mitra_id'] = $this->input->post('tambah-mitra', true);
            $data['emergency_phone'] = $this->input->post('emergency-phone', true);
            if($this->input->post('tambah-mitra', true)=='1'){
                $data['is_internal'] = 1;
                $data['divisi_id'] = $this->input->post('tambah-divisi', true);
            }else{
                $data['is_internal'] = 0;
                $data['divisi_id'] = NULL;
            }
            $data['gender'] = $this->input->post('gender', true);
            $data['no_tlp'] = $this->input->post('notlp', true);
            $data['no_ktp'] = $this->input->post('noktp', true);
            $data['alamat'] = $this->input->post('alamat', true);
// tambahan
            $data['tglrapidtest'] = $this->input->post('tglrapidtest', true);
            $data['hasilrapidtest'] = $this->input->post('hasilrapidtest', true);
            $data['lokasirapidtest'] = $this->input->post('lokasirapidtest', true);

            
            if($this->input->post('is_admin', true)=='admin' && $data['is_internal']==1){
                $data['user_level'] = '1';
                $data['extensions'] = 'AVI,BMP,DOC,DOCX,GIF,JPEG,JPG,MP3,MP4,PDF,RAR,TXT,XLS,XLSX,ZIP,PPT,PPTX';
                $data['quota'] = '10000';
                $data['filesize'] = '10000';
                $data['active'] = '1';
                $data['accesslevel'] = 'abcdefghijklmnopqrstuvwxyz';
                $data['upload_dir'] = 'uploads';
                $data['upload_dirs'] = '4,2,3';
            }elseif($this->input->post('is_admin', true)=='operator' && $data['is_internal']==1){
                $data['user_level'] = '9';
                $data['extensions'] = 'AVI,BMP,DOC,DOCX,GIF,JPEG,JPG,MP3,MP4,PDF,RAR,TXT,XLS,XLSX,ZIP,PPT,PPTX';
                $data['quota'] = '10000';
                $data['filesize'] = '10000';
                $data['active'] = '1';
                $data['accesslevel'] = 'tgihko';
                $data['upload_dir'] = 'uploads';
                $data['upload_dirs'] = '4,2,3';
            }elseif($data['is_internal']==1){
                $data['user_level'] = '10';
                $data['extensions'] = 'AVI,BMP,DOC,DOCX,GIF,JPEG,JPG,MP3,MP4,PDF,RAR,TXT,XLS,XLSX,ZIP,PPT,PPTX';
                $data['quota'] = '100';
                $data['filesize'] = '100';
                $data['active'] = '1';
                $data['accesslevel'] = 'tio';
                $data['upload_dir'] = 'uploads';
                if($data['user_grup_id']==1)
                    $data['upload_dirs'] = '3';
                    if($data['user_grup_id']==2)
                        $data['upload_dirs'] = '4';
                        if($data['user_grup_id']==3)
                            $data['upload_dirs'] = '2';
            }else{
                $data['user_level'] = '10';
                $data['extensions'] = 'AVI,BMP,DOC,DOCX,GIF,JPEG,JPG,MP3,MP4,PDF,RAR,TXT,XLS,XLSX,ZIP,PPT,PPTX';
                $data['quota'] = '100';
                $data['filesize'] = '100';
                $data['active'] = '1';
                $data['accesslevel'] = 'ti';
                $data['upload_dir'] = 'uploads';
                if($data['user_grup_id']==1)
                    $data['upload_dirs'] = '3';
                    if($data['user_grup_id']==2)
                        $data['upload_dirs'] = '4';
                        if($data['user_grup_id']==3)
                            $data['upload_dirs'] = '2';
            }
            
            if($this->cbt_user_grup_model->count_by_kolom('grup_id', $data['user_grup_id'])->row()->hasil>0){
                if($this->cbt_user_model->count_by_kolom('username', $data['username'])->row()->hasil>0){
                    $status['status'] = 0;
                    $status['pesan'] = 'Username sudah terpakai !';
                }else{
                    $field_name = 'imgInp';
                    if(!empty($_FILES[$field_name]['name'])){
                        $config['upload_path'] = 'uploads/photos/';
                        $config['allowed_types'] = 'jpg|png|jpeg';
                        $config['max_size']	= '0';
                        $config['overwrite'] = true;
                        $config['file_name'] = strtolower(date("His").$_FILES[$field_name]['name']);
                        if(file_exists('uploads/photos/'.$config['file_name'])){
                            $status['status'] = 0;
                            $status['pesan'] = 'Nama file sudah terdapat pada direktori, silahkan ubah nama file yang akan di upload';
                        }else{
                            $this->load->library('upload', $config);
                            if (!$this->upload->do_upload($field_name)){
                                $status['status'] = 0;
                                $status['pesan'] = $this->upload->display_errors();
                            }else{
                                $upload_data = $this->upload->data();
                                $data['foto'] = $upload_data['file_name'];
                                $status['status'] = 1;
                                $status['pesan'] = 'File '.$upload_data['file_name'].' BERHASIL di IMPORT';
                            }
                        }
                    }
// tambahan foto hasil rapid test
                    // $field_names = 'imghasilrapidtest';
                    // if(!empty($_FILES[$field_names]['name'])){
                    //     $config['upload_path'] = 'uploads/photos/';
                    //     $config['allowed_types'] = 'jpg|png|jpeg';
                    //     $config['max_size'] = '0';
                    //     $config['overwrite'] = true;
                    //     $config['file_name'] = strtolower(date("His").$_FILES[$field_names]['name']);
                    //     if(file_exists('uploads/photos/'.$config['file_name'])){
                    //         $status['status'] = 0;
                    //         $status['pesan'] = 'Nama file sudah terdapat pada direktori, silahkan ubah nama file yang akan di upload';
                    //     }else{
                    //         $this->load->library('upload', $config);
                    //         if (!$this->upload->do_upload($field_names)){
                    //             $status['status'] = 0;
                    //             $status['pesan'] = $this->upload->display_errors();
                    //         }else{
                    //             $upload_data = $this->upload->data();
                    //             $data['imghasilrapidtest'] = $upload_data['file_name'];
                    //             $status['status'] = 1;
                    //             $status['pesan'] = 'File '.$upload_data['file_name'].' BERHASIL di IMPORT';
                    //         }
                    //     }
                    // }
                    
                    $this->cbt_user_model->save($data);
                    if($data['user_level']=='1' || $data['user_level']=='9'){
                        $data_user['username'] = $this->input->post('tambah-username', true);
                        $data_user['password'] = md5($this->input->post('tambah-password', true));
                        $data_user['nama'] = $this->input->post('tambah-nama', true);
                        $data_user['level'] = $this->input->post('is_admin', true);
                        $data_user['opsi1'] = '';
                        $data_user['opsi2'] = '';
                        $data_user['keterangan'] = '';
                        
                        $this->users_model->save($data_user);
                    }
                    $status['status'] = 1;
                    $status['pesan'] = 'Data Peserta berhasil disimpan ';
                }
            }else{
                $status['status'] = 0;
                $status['pesan'] = 'Data Group tidak tersedia, Silahkan tambah data Group';
            }
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }
        
        echo json_encode($status);
    }
    
    function get_jabatan(){
        $id=$this->input->post('id');
        $data=$this->cbt_user_model->get_jabatan_bygroup($id);
        echo json_encode($data);
    }
    
    function get_by_id($id=null){
        $data['data'] = 0;
        if(!empty($id)){
            $query = $this->cbt_user_model->get_by_kolom('id', $id);
            if($query->num_rows()>0){
                $query = $query->row();
                $data['data'] = 1;
                $data['id'] = $query->id;
                $data['username'] = $query->username;
                $data['password'] = $query->password;
                $data['nama'] = $query->user_firstname;
                $data['email'] = $query->email;
                $data['group'] = $query->user_grup_id;
                $data['user_level'] = $query->user_level;
                $data['is_internal'] = $query->is_internal;
                $data['mitra_id'] = $query->mitra_id;
                $data['no_tlp'] = $query->no_tlp;
                $data['no_ktp'] = $query->no_ktp;
                $data['alamat'] = $query->alamat;
                $data['gender'] = $query->gender;
                $data['divisi_id'] = $query->divisi_id;
                $data['emergency_phone'] = $query->emergency_phone;
                $data['foto'] = $query->foto;
                $data['jabatan_id'] = $query->jabatan_id;
// tambahan
                $data['tglrapidtest'] = $query->tglrapidtest;
                $data['hasilrapidtest'] = $query->hasilrapidtest;
                $data['lokasirapidtest'] = $query->lokasirapidtest;
            }
        }
        echo json_encode($data);
    }
    
    /**
     * Menghapus siswa yang dipilih
     * @return [type] [description]
     */
    function hapus_daftar_siswa(){
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('edit-user-id[]', 'Siswa','required|strip_tags');
        if($this->form_validation->run() == TRUE){
            $id = $this->input->post('edit-user-id', TRUE);
            foreach( $id as $kunci => $isi ) {
                if($isi=="on"){
                    $this->cbt_user_model->delete('id', $kunci);
                }
            }
            $status['status'] = 1;
            $status['pesan'] = 'Daftar Siswa berhasil dihapus';
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }
        
        echo json_encode($status);
    }
    
    function edit(){
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('edit-id', 'ID','required|strip_tags');
        $this->form_validation->set_rules('edit-pilihan', 'Pilihan','required|strip_tags');
        
        $this->form_validation->set_rules('edit-username', 'Username','required|strip_tags');
        #$this->form_validation->set_rules('edit-password', 'Password','required|strip_tags');
        $this->form_validation->set_rules('edit-nama', 'Nama Lengkap','required|strip_tags');
        $this->form_validation->set_rules('edit-email', 'Email','strip_tags');
        $this->form_validation->set_rules('edit-group', 'Group','required|strip_tags');
        $this->form_validation->set_rules('edit-mitra', 'Mitra','strip_tags');
        $this->form_validation->set_rules('edit-divisi', 'Divisi','strip_tags');
        $this->form_validation->set_rules('edit-notlp', 'No Tlp','required|strip_tags');
        $this->form_validation->set_rules('edit-jabatan', 'Jabatan','required|strip_tags');
        $this->form_validation->set_rules('edit-noktp', 'No KTP','required|strip_tags');
        $this->form_validation->set_rules('edit-alamat', 'Alamat','required|strip_tags');
// tambahan
        $this->form_validation->set_rules('edit-tglrapidtest', 'tglrapidtest','required|strip_tags');
        $this->form_validation->set_rules('edit-hasilrapidtest', 'hasilrapidtest','required|strip_tags');
        $this->form_validation->set_rules('edit-lokasirapidtest', 'lokasirapidtest','required|strip_tags');
        
        if($this->form_validation->run() == TRUE){
            $pilihan = $this->input->post('edit-pilihan', true);
            $id = $this->input->post('edit-id', true);
            
            if($pilihan=='hapus'){//hapus
                $query = $this->cbt_user_model->get_by_kolom('id', $id);
                if($query->num_rows()>0){
                    $query = $query->row();
                    $this->cbt_user_model->delete($query->username);
                }
                $this->cbt_user_model->delete('id', $id);
                $status['status'] = 1;
                $status['pesan'] = 'Data Peserta berhasil dihapus !';
                
            }else if($pilihan=='simpan'){//simpan
                
                
                #$data['username'] = $this->input->post('edit-username', true);
                if(!empty($this->input->post('edit-password', true)))
                    $data['password'] = md5($this->input->post('edit-password', true));
                    $data['email'] = $this->input->post('edit-email', true);
                    $data['user_firstname'] = $this->input->post('edit-nama', true);
                    $data['user_grup_id'] = $this->input->post('edit-group', true);
                    $data['jabatan_id'] = $this->input->post('edit-jabatan', true);
                    $data['mitra_id'] = $this->input->post('edit-mitra', true);
                    $data['emergency_phone'] = $this->input->post('edit-emergency-phone', true);
                    if($this->input->post('edit-mitra', true)=='1'){
                        $data['is_internal'] = 1;
                        $data['divisi_id'] = $this->input->post('edit-divisi', true);
                    }else{
                        $data['is_internal'] = 0;
                        $data['divisi_id'] = NULL;
                    }
                    $data['gender'] = $this->input->post('edit-gender', true);
                    $data['no_tlp'] = $this->input->post('edit-notlp', true);
                    $data['no_ktp'] = $this->input->post('edit-noktp', true);
                    $data['alamat'] = $this->input->post('edit-alamat', true);
// tambahan
                    $data['tglrapidtest'] = $this->input->post('edit-tglrapidtest', true);
                    $data['hasilrapidtest'] = $this->input->post('edit-hasilrapidtest', true);
                    $data['lokasirapidtest'] = $this->input->post('edit-lokasirapidtest', true);
                    
                    if($this->input->post('edit-is_admin', true)=='admin' && $data['is_internal']==1){
                        $data['user_level'] = '1';
                        $data['extensions'] = 'AVI,BMP,DOC,DOCX,GIF,JPEG,JPG,MP3,MP4,PDF,RAR,TXT,XLS,XLSX,ZIP,PPT,PPTX';
                        $data['quota'] = '10000';
                        $data['filesize'] = '10000';
                        $data['active'] = '1';
                        $data['accesslevel'] = 'abcdefghijklmnopqrstuvwxyz';
                        $data['upload_dir'] = 'uploads';
                        $data['upload_dirs'] = '4,2,3';
                    }elseif($this->input->post('edit-is_admin', true)=='operator' && $data['is_internal']==1){
                        $data['user_level'] = '9';
                        $data['extensions'] = 'AVI,BMP,DOC,DOCX,GIF,JPEG,JPG,MP3,MP4,PDF,RAR,TXT,XLS,XLSX,ZIP,PPT,PPTX';
                        $data['quota'] = '10000';
                        $data['filesize'] = '10000';
                        $data['active'] = '1';
                        $data['accesslevel'] = 'tgihko';
                        $data['upload_dir'] = 'uploads';
                        $data['upload_dirs'] = '4,2,3';
                    }elseif($data['is_internal']==1){
                        $data['user_level'] = '10';
                        $data['extensions'] = 'AVI,BMP,DOC,DOCX,GIF,JPEG,JPG,MP3,MP4,PDF,RAR,TXT,XLS,XLSX,ZIP,PPT,PPTX';
                        $data['quota'] = '100';
                        $data['filesize'] = '100';
                        $data['active'] = '1';
                        $data['accesslevel'] = 'tio';
                        $data['upload_dir'] = 'uploads';
                        if($data['user_grup_id']==1)
                            $data['upload_dirs'] = '3';
                            if($data['user_grup_id']==2)
                                $data['upload_dirs'] = '4';
                                if($data['user_grup_id']==3)
                                    $data['upload_dirs'] = '2';
                    }else{
                        $data['user_level'] = '10';
                        $data['extensions'] = 'AVI,BMP,DOC,DOCX,GIF,JPEG,JPG,MP3,MP4,PDF,RAR,TXT,XLS,XLSX,ZIP,PPT,PPTX';
                        $data['quota'] = '100';
                        $data['filesize'] = '100';
                        $data['active'] = '1';
                        $data['accesslevel'] = 'ti';
                        $data['upload_dir'] = 'uploads';
                        if($data['user_grup_id']==1)
                            $data['upload_dirs'] = '3';
                            if($data['user_grup_id']==2)
                                $data['upload_dirs'] = '4';
                                if($data['user_grup_id']==3)
                                    $data['upload_dirs'] = '2';
                    }
                    
                    $field_name = 'edit-imgInp';
                    if(!empty($_FILES[$field_name]['name'])){
                        $config['upload_path'] = 'uploads/photos/';
                        $config['allowed_types'] = 'jpg|png|jpeg';
                        $config['max_size']	= '0';
                        $config['overwrite'] = true;
                        $config['file_name'] = strtolower(date("His").$_FILES[$field_name]['name']);
                        #$data['foto'] = $config['file_name'];
                        if(file_exists('uploads/photos/'.$config['file_name'])){
                            $status['status'] = 0;
                            $status['pesan'] = 'Nama file sudah terdapat pada direktori, silahkan ubah nama file yang akan di pload';
                        }else{
                            $this->load->library('upload', $config);
                            if (!$this->upload->do_upload($field_name)){
                                $status['status'] = 0;
                                $status['pesan'] = $this->upload->display_errors();
                            }else{
                                $upload_data = $this->upload->data();
                                $status['status'] = 1;
                                $data['foto'] = $upload_data['file_name'];
                                $status['pesan'] = 'File '.$upload_data['file_name'].' BERHASIL di IMPORT';
                            }
                        }
                    }
                    
                    
                    $this->cbt_user_model->update('id', $id, $data);
                    if($data['user_level']=='1' || $data['user_level']=='9'){
                        $data_user['username'] = $this->input->post('edit-username', true);
                        if(!empty($this->input->post('edit-password', true)))
                            $data_user['password'] = md5($this->input->post('edit-password', true));
                            $data_user['nama'] = $this->input->post('edit-nama', true);
                            $data_user['level'] = $this->input->post('edit-is_admin', true);
                            $data_user['opsi1'] = '';
                            $data_user['opsi2'] = '';
                            $data_user['keterangan'] = '';
                            
                            $query_user = $this->users_model->get_user_by_username($this->input->post('edit-username', true));
                            if($query_user->num_rows()>0)
                                $this->users_model->update($data_user,$this->input->post('edit-username', true));
                                else
                                    $this->users_model->save($data_user);
                    }else{
                        $query_user_cbt = $this->cbt_user_model->get_by_username($this->input->post('edit-username', true));
                        if($query_user_cbt)
                            $this->users_model->delete($this->input->post('edit-username', true));
                            
                    }
                    $status['status'] = 1;
                    $status['pesan'] = 'Data Peserta berhasil disimpan ';
            }
            
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }
        
        echo json_encode($status);
    }
    
    function get_datatable(){
        // variable initialization
        $group = $this->input->get('group');
        
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
        $query = $this->cbt_user_model->get_datatable($start, $rows, 'user_firstname', $search, $group);
        $iFilteredTotal = $query->num_rows();
        
        $iTotal= $this->cbt_user_model->get_datatable_count('user_firstname', $search, $group)->row()->hasil;
        
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
            
            $query_jabatan = $this->cbt_user_grup_model->get_jabatan('jabatan_id', $temp->jabatan_id, 1)->row();
            $query_mitra = $this->cbt_user_grup_model->get_mitra_by_id('mitra_id', $temp->mitra_id, 1)->row();
            $query_group = $this->cbt_user_grup_model->get_by_kolom_limit('grup_id', $temp->user_grup_id, 1)->row();
            
            $record[] = @$query_mitra->mitra_nama;
            $record[] = $query_group->grup_nama;
            $record[] = @$query_jabatan->user_jabatan;
            
            $record[] = '<a onclick="edit(\''.$temp->id.'\')" style="cursor: pointer;" class="btn btn-default btn-xs">Edit</a>';
            $record[] = '<input type="checkbox" name="edit-user-id['.$temp->id.']" >';
            
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
}