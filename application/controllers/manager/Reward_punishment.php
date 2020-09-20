<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reward_punishment extends Member_Controller {
	private $kode_menu = 'modul-topik';
	private $kelompok = 'modul';
	private $url = 'manager/reward_punishment';
	
    function __construct(){
		parent:: __construct();
		$this->load->model('trx_reward_model');
		$this->load->model('trx_punishment_model');
		parent::cek_akses($this->kode_menu);
	}
	
    public function index($page=null, $id=null){
        $data['kode_menu'] = $this->kode_menu;
        $data['url'] = $this->url;

		//Query ke tabel cbt user
		$select = '';
		$query_cbt_user = $this->trx_reward_model->get_master_cbt_user_haveid_card();
        if($query_cbt_user->num_rows()>0){
        	$select = '<option value="">--PILIH--</option>';
        	$query_cbt_user = $query_cbt_user->result();
        	foreach ($query_cbt_user as $temp) {
        		$select = $select.'<option value="'.$temp->id.'" data-nomor-pass="'.$temp->nomor_pass.'" data-mitra-id="'.$temp->mitra_id.'" data-jabatan-id="'.$temp->jabatan_id.'">'.$temp->nomor_pass.' - '.$temp->user_firstname.'</option>';
        	}

        }else{
        	$select = '<option value="10000000">KOSONG</option>';
        }
		
        $data['select_cbt_user'] = $select;
		//Query ke tabel cbt user
		//Query ke tabel perusahaan
		$select = '';
		$query_mitra = $this->trx_reward_model->get_master_mitra();
        if($query_mitra->num_rows()>0){
        	$select = '<option value="">--PILIH--</option>';
        	$query_mitra = $query_mitra->result();
        	foreach ($query_mitra as $temp) {
        		$select = $select.'<option value="'.$temp->mitra_id.'">'.$temp->mitra_nama.'</option>';
        	}

        }else{
        	$select = '<option value="10000000">KOSONG</option>';
        }
		
        $data['select_perusahaan'] = $select;
		//Query ke tabel perusahaan
		//Query ke tabel posisi
		$select = '';
		$query_jabatan = $this->trx_reward_model->get_master_jabatan();
        if($query_jabatan->num_rows()>0){
        	$select = '<option value="">--PILIH--</option>';
        	$query_jabatan = $query_jabatan->result();
        	foreach ($query_jabatan as $temp) {
        		$select = $select.'<option value="'.$temp->jabatan_id.'">'.$temp->user_jabatan.'</option>';
        	}

        }else{
        	$select = '<option value="10000000">KOSONG</option>';
        }
		
        $data['select_posisi'] = $select;
		//Query ke tabel posisi
		//Query ke tabel reward
		$select = '';
		$query_reward = $this->trx_reward_model->get_master_reward();
        if($query_reward->num_rows()>0){
        	$select = '';
        	$query_reward = $query_reward->result();
        	foreach ($query_reward as $temp) {
        		$select = $select.'<option value="'.$temp->reward_id.'">'.$temp->name.'</option>';
        	}

        }else{
        	$select = '<option value="10000000">KOSONG</option>';
        }
		
        $data['select_prestasi'] = $select;
		//Query ke tabel reward
        
        $this->template->display_admin($this->kelompok.'/reward_view', 'Daftar Topik', $data);
    }

    function tambah(){
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('nama-pekerja', 'Nama Pekerja','required|strip_tags');
        $this->form_validation->set_rules('tanggal-validasi', 'Tanggal Validasi','required|strip_tags');
        $this->form_validation->set_rules('nama-perusahaan', 'Nama Perusahaan','required|strip_tags');
        $this->form_validation->set_rules('nama-posisi', 'Poisi/ Jabatan','required|strip_tags');
        
		
        if($this->form_validation->run() == TRUE){
			$d1 = explode("/", $this->input->post('tanggal-validasi', true));
        	$data['tgl_validasi'] = $d1[2]."-".$d1[1]."-".$d1[0];
            $data['user_id'] = $this->input->post('nama-pekerja', true);
            $data['mitra_id'] = $this->input->post('nama-perusahaan', true);
            $data['jabatan_id'] = $this->input->post('nama-posisi', true);
            $data['validator'] = $this->session->userdata('username');
            $reward = $this->input->post('nama-prestasi', true);
            $data['reward'] = implode(",", $reward);
            $data['is_active'] = 1;
            $data['created_date'] = date('Y-m-d H:i:s');
            $data['updated_date'] = date('Y-m-d H:i:s');
            $data['updated_by'] = $this->session->userdata('username');
			
			$field_name = 'upload-file';
			if(!empty($_FILES[$field_name]['name'])){
				$config['upload_path'] = 'uploads/documents/';
				$config['allowed_types'] = 'jpg|png|jpeg|doc|docs|pdf';
				$config['max_size']	= '0';
				$config['overwrite'] = true;
				$config['file_name'] = strtolower(date("His").str_replace(" ","",$_FILES[$field_name]['name']));
				$data['filename'] = $config['file_name'];
				if(file_exists('uploads/documents/'.$config['file_name'])){
					$status['status'] = 0;
					$status['pesan'] = 'Nama file sudah terdapat pada direktori, silahkan ubah nama file yang akan di upload';
				}else{
					$this->load->library('upload', $config);
					if (!$this->upload->do_upload($field_name)){
						$status['status'] = 0;
						$status['pesan'] = $this->upload->display_errors();
						echo json_encode($status);
						exit;
					}else{
						$upload_data = $this->upload->data();
						$status['status'] = 1;
						$status['pesan'] = 'File '.$upload_data['file_name'].' BERHASIL di IMPORT';
					}   	
				} 
			}
			
            $this->trx_reward_model->save($data);
                
            $status['status'] = 1;
            $status['pesan'] = 'Data berhasil disimpan ';
            
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }
        
        echo json_encode($status);
    }
    
	
	function tambah_punishment(){
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('nama-pekerja', 'Nama Pekerja','required|strip_tags');
        $this->form_validation->set_rules('tanggal-validasi', 'Tanggal Validasi','required|strip_tags');
        $this->form_validation->set_rules('nama-perusahaan', 'Nama Perusahaan','required|strip_tags');
        $this->form_validation->set_rules('nama-posisi', 'Poisi/ Jabatan','required|strip_tags');
        
		
        if($this->form_validation->run() == TRUE){
        	$tgl_validasi = $this->input->post('tanggal-validasi', true);
			$exp = explode(" - ", $tgl_validasi);
			
			$d1 = explode("/", $exp[0]);
			$d2 = explode("/", $exp[1]);
			$data['punishment_date_start'] = $d1[2]."-".$d1[1]."-".$d1[0];
			$data['punishment_date_end'] = $d2[2]."-".$d2[1]."-".$d2[0];

            $data['user_id'] = $this->input->post('nama-pekerja', true);
            $data['mitra_id'] = $this->input->post('nama-perusahaan', true);
            $data['jabatan_id'] = $this->input->post('nama-posisi', true);
			if($this->input->post('level', true)=='NaN')
				$data['level'] = 1;
			else
				$data['level'] = $this->input->post('level', true);
            $data['validator'] = $this->session->userdata('username');
            $reward = $this->input->post('nama-pelanggaran', true);
            $data['punishment'] = implode(",", $reward);
            $data['is_active'] = 1;
            $data['created_date'] = date('Y-m-d H:i:s');
            $data['updated_date'] = date('Y-m-d H:i:s');
            $data['updated_by'] = $this->session->userdata('username');
			
			$field_name = 'upload-file';
			if(!empty($_FILES[$field_name]['name'])){
				$config['upload_path'] = 'uploads/documents/';
				$config['allowed_types'] = 'jpg|png|jpeg|doc|docs|pdf';
				$config['max_size']	= '0';
				$config['overwrite'] = true;
				$config['file_name'] = strtolower(date("His").str_replace(" ","",$_FILES[$field_name]['name']));
				$data['filename'] = $config['file_name'];
				if(file_exists('uploads/documents/'.$config['file_name'])){
					$status['status'] = 0;
					$status['pesan'] = 'Nama file sudah terdapat pada direktori, silahkan ubah nama file yang akan di upload';
				}else{
					$this->load->library('upload', $config);
					if (!$this->upload->do_upload($field_name)){
						$status['status'] = 0;
						$status['pesan'] = $this->upload->display_errors();
						echo json_encode($status);
						exit;
					}else{
						$upload_data = $this->upload->data();
						$status['status'] = 1;
						$status['pesan'] = 'File '.$upload_data['file_name'].' BERHASIL di IMPORT';
					}   	
				} 
			}
			
            $this->trx_punishment_model->save($data);
                
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
			$query = $this->trx_reward_model->get_by_kolom('trx_reward_id', $id);
			if($query->num_rows()>0){
				$query = $query->row();
				
				$timestamp = strtotime($query->tgl_validasi);
				$dmy1 = date("d/m/Y", $timestamp);
				
				$data['data'] = 1;
				$data['id'] = $query->trx_reward_id;
				$data['user_id'] = $query->user_id;
				$data['mitra_id'] = $query->mitra_id;
				$data['jabatan_id'] = $query->jabatan_id;
				$data['tgl_validasi'] = $dmy1;
				$data['reward'] = $query->reward;
				$data['foto'] = $query->foto;
				$data['file'] = $query->filename;
			}
		}
		echo json_encode($data);
    }
	
    function punishment_get_by_id($id=null){
    	$data['data'] = 0;
		if(!empty($id)){
			$query = $this->trx_punishment_model->get_by_kolom('trx_punishment_id', $id);
			if($query->num_rows()>0){
				$query = $query->row();
			 
				$timestamp = strtotime($query->punishment_date_start);
				$dmy1 = date("d/m/Y", $timestamp);
				
				$timestamp = strtotime($query->punishment_date_end);
				$dmy2 = date("d/m/Y", $timestamp);
				
				$data['data'] = 1;
				$data['id'] = $query->trx_punishment_id;
				$data['user_id'] = $query->user_id;
				$data['mitra_id'] = $query->mitra_id;
				$data['jabatan_id'] = $query->jabatan_id;
				$data['punishment_date_start'] = $dmy1;
				$data['punishment_date_end'] = $dmy2;
				$data['punishment'] = $query->punishment;
				$data['foto'] = $query->foto;
				$data['file'] = $query->filename;
				$data['level'] = $query->level;
			}
		}
		echo json_encode($data);
    }

    /**
     * Menghapus topik yang dipilih
     * @return [type] [description]
     */
    function hapus_daftar_topik(){
    	$this->load->library('form_validation');
        
		$this->form_validation->set_rules('edit-reward-id[]', 'Reward','required|strip_tags');
		if($this->form_validation->run() == TRUE){
			$reward_id = $this->input->post('edit-reward-id', TRUE);
			$error_hapus = 0;
			foreach( $reward_id as $kunci => $isi ) {
				if($isi=="on"){
					// Memulai transaction mysql
					$this->db->trans_start();

            		// hapus topik di database
            		$this->trx_reward_model->delete('trx_reward_id', $kunci);

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


	function hapus_daftar_punishment(){
    	$this->load->library('form_validation');
        
		$this->form_validation->set_rules('edit-punishment-id[]', 'punishment','required|strip_tags');
		if($this->form_validation->run() == TRUE){
			$punishment_id = $this->input->post('edit-punishment-id', TRUE);
			$error_hapus = 0;
			foreach( $punishment_id as $kunci => $isi ) {
				if($isi=="on"){
					// Memulai transaction mysql
					$this->db->trans_start();

            		// hapus topik di database
            		$this->trx_punishment_model->delete('trx_punishment_id', $kunci);

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
        
		$this->form_validation->set_rules('edit-nama-pekerja', 'Nama Pekerja','required|strip_tags');
		$this->form_validation->set_rules('edit-nama-perusahaan', 'Nama Perusahaan','required|strip_tags');
		$this->form_validation->set_rules('edit-nama-posisi', 'Posisi/ Jabatan','required|strip_tags');
        $this->form_validation->set_rules('edit-tanggal-validasi', 'Tanggal Validasi','required|strip_tags');
        
        if($this->form_validation->run() == TRUE){
            $pilihan = $this->input->post('edit-pilihan', true);
            $id = $this->input->post('edit-id', true);
            
            if($pilihan=='hapus'){//hapus
            	
            	// hapus topik di database
            	$this->trx_reward_model->delete('trx_reward_id', $id);

				$status['status'] = 1;
				$status['pesan'] = 'Berhasil dihapus !';
            	
            }else if($pilihan=='simpan'){//simpan
				$d1 = explode("/", $this->input->post('edit-tanggal-validasi', true));
				$data['tgl_validasi'] = $d1[2]."-".$d1[1]."-".$d1[0];
				$data['user_id'] = $this->input->post('edit-nama-pekerja', true);
				$data['mitra_id'] = $this->input->post('edit-nama-perusahaan', true);
				$data['jabatan_id'] = $this->input->post('edit-nama-posisi', true);
				$data['validator'] = $this->session->userdata('username');
				$reward = $this->input->post('edit-nama-prestasi', true);
				$data['reward'] = implode(",", $reward);
				$data['is_active'] = 1;
				$data['updated_date'] = date('Y-m-d H:i:s');
				$data['updated_by'] = $this->session->userdata('username');
				
				$field_name = 'edit-upload-file';
				if(!empty($_FILES[$field_name]['name'])){
					$config['upload_path'] = 'uploads/documents/';
					$config['allowed_types'] = 'jpg|png|jpeg|doc|docs|pdf';
					$config['max_size']	= '0';
					$config['overwrite'] = true;
					$config['file_name'] = strtolower(date("His").str_replace(" ","",$_FILES[$field_name]['name']));
					$data['filename'] = $config['file_name'];
					if(file_exists('uploads/documents/'.$config['file_name'])){
						$status['status'] = 0;
						$status['pesan'] = 'Nama file sudah terdapat pada direktori, silahkan ubah nama file yang akan di upload';
					}else{
						$this->load->library('upload', $config);
						if (!$this->upload->do_upload($field_name)){
							$status['status'] = 0;
							$status['pesan'] = $this->upload->display_errors();
							echo json_encode($status);
							exit;
						}else{
							$upload_data = $this->upload->data();
							$status['status'] = 1;
							$status['pesan'] = 'File '.$upload_data['file_name'].' BERHASIL di IMPORT';
						}   	
					} 
				}

                $this->trx_reward_model->update('trx_reward_id', $id, $data);
                $status['status'] = 1;
                $status['pesan'] = 'Data Berhasil disimpan';
            }
            
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }
        
        echo json_encode($status);
    }
    
	function edit_punishment(){
        $this->load->library('form_validation');
        
		$this->form_validation->set_rules('edit-nama-pekerja', 'Nama Pekerja','required|strip_tags');
		$this->form_validation->set_rules('edit-nama-perusahaan', 'Nama Perusahaan','required|strip_tags');
		$this->form_validation->set_rules('edit-nama-posisi', 'Posisi/ Jabatan','required|strip_tags');
        $this->form_validation->set_rules('edit-tanggal-validasi', 'Tanggal Validasi','required|strip_tags');
        
        if($this->form_validation->run() == TRUE){
            $pilihan = $this->input->post('edit-pilihan', true);
            $id = $this->input->post('edit-id', true);
            
            if($pilihan=='hapus'){//hapus
            	
            	// hapus topik di database
            	$this->trx_punishment_model->delete('trx_punishment_id', $id);

				$status['status'] = 1;
				$status['pesan'] = 'Berhasil dihapus !';
            	
            }else if($pilihan=='simpan'){//simpan
                $tgl_validasi = $this->input->post('edit-tanggal-validasi', true);
				$exp = explode(" - ", $tgl_validasi);
				$d1 = explode("/", $exp[0]);
				$d2 = explode("/", $exp[1]);
				$data['punishment_date_start'] = $d1[2]."-".$d1[1]."-".$d1[0];
				$data['punishment_date_end'] = $d2[2]."-".$d2[1]."-".$d2[0];
				$data['user_id'] = $this->input->post('edit-nama-pekerja', true);
				$data['mitra_id'] = $this->input->post('edit-nama-perusahaan', true);
				$data['jabatan_id'] = $this->input->post('edit-nama-posisi', true);
				$data['validator'] = $this->session->userdata('username');
				$punishment = $this->input->post('edit-nama-pelanggaran', true);
				$data['punishment'] = implode(",", $punishment);
				$data['is_active'] = 1;
				$data['updated_date'] = date('Y-m-d H:i:s');
				$data['updated_by'] = $this->session->userdata('username');
				
				$field_name = 'edit-upload-file';
				if(!empty($_FILES[$field_name]['name'])){
					$config['upload_path'] = 'uploads/documents/';
					$config['allowed_types'] = 'jpg|png|jpeg|doc|docs|pdf';
					$config['max_size']	= '0';
					$config['overwrite'] = true;
					$config['file_name'] = strtolower(date("His").str_replace(" ","",$_FILES[$field_name]['name']));
					$data['filename'] = $config['file_name'];
					if(file_exists('uploads/documents/'.$config['file_name'])){
						$status['status'] = 0;
						$status['pesan'] = 'Nama file sudah terdapat pada direktori, silahkan ubah nama file yang akan di upload';
					}else{
						$this->load->library('upload', $config);
						if (!$this->upload->do_upload($field_name)){
							$status['status'] = 0;
							$status['pesan'] = $this->upload->display_errors();
							echo json_encode($status);
							exit;
						}else{
							$upload_data = $this->upload->data();
							$status['status'] = 1;
							$status['pesan'] = 'File '.$upload_data['file_name'].' BERHASIL di IMPORT';
						}   	
					} 
				}

                $this->trx_punishment_model->update('trx_punishment_id', $id, $data);
                $status['status'] = 1;
                $status['pesan'] = 'Data Berhasil disimpan';
            }
            
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }
        
        echo json_encode($status);
    }
	
	function get_datatable_punishment(){
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
		$punishment = array();
		$query_m_punishment = $this->trx_punishment_model->get_master_punishment();
		$query_m_punishment = $query_m_punishment->result();
	    foreach ($query_m_punishment as $temp_punishment) {
			$punishment[$temp_punishment->punishment_id] = $temp_punishment->name;
		}
		$query = $this->trx_punishment_model->get_datatable($start, $rows, 'a.user_firstname', $search);
		$iFilteredTotal = $query->num_rows();
		
		$iTotal= $this->trx_punishment_model->get_datatable_count('a.user_firstname', $search, $modul)->row()->hasil;
	    
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
            
			$exp = explode(",", $temp->punishment);
			
			$string = '';
			foreach($exp as $e){
				$string .= $punishment[$e]."<br/>"; 
			}
			
			$ymd = $temp->punishment_date_start;
			 
			$timestamp = strtotime($ymd);
			 
			//Convert it to DD-MM-YYYY
			$dmy1 = date("d M Y", $timestamp);
			
			$ymd = $temp->punishment_date_end;
			 
			$timestamp = strtotime($ymd);
			 
			//Convert it to DD-MM-YYYY
			$dmy2 = date("d M Y", $timestamp);
			
			$record[] = ++$i;
            $record[] = $temp->user_firstname;
            $record[] = $temp->mitra_nama;
            $record[] = $temp->user_jabatan;
            $record[] = $string;
            $record[] = $dmy1." s/d ".$dmy2;
            $record[] = $temp->validator;
            $record[] = $temp->level;
            
            $record[] = '<a onclick="edit(\''.$temp->trx_punishment_id.'\')" style="cursor: pointer;" class="btn btn-default btn-xs">Edit</a><a onclick="viewdata(\''.$temp->trx_punishment_id.'\')" style="cursor: pointer;" class="btn btn-default btn-xs">View</a>';
            $record[] = '<input type="checkbox" name="edit-punishment-id['.$temp->trx_punishment_id.']" >';

			$output['aaData'][] = $record;
		}
		// format it to JSON, this output will be displayed in datatable
        
		echo json_encode($output);
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
		$reward = array();
		$query_m_reward = $this->trx_reward_model->get_master_reward();
		$query_m_reward = $query_m_reward->result();
	    foreach ($query_m_reward as $temp_reward) {
			$reward[$temp_reward->reward_id] = $temp_reward->name;
		}
		$query = $this->trx_reward_model->get_datatable($start, $rows, 'a.user_firstname', $search);
		$iFilteredTotal = $query->num_rows();
		
		$iTotal= $this->trx_reward_model->get_datatable_count('a.user_firstname', $search, $modul)->row()->hasil;
	    
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
            
			$exp = explode(",", $temp->reward);
			
			$string = '';
			foreach($exp as $e){
				$string .= $reward[$e]."<br/>"; 
			}
			
			$ymd = $temp->tgl_validasi;
			 
			$timestamp = strtotime($ymd);
			 
			//Convert it to DD-MM-YYYY
			$dmy = date("d M Y", $timestamp);
			
			$record[] = ++$i;
            $record[] = $temp->user_firstname;
            $record[] = $temp->mitra_nama;
            $record[] = $temp->user_jabatan;
            $record[] = $string;
            $record[] = $dmy;
            $record[] = $temp->validator;
            
            $record[] = '<a onclick="edit(\''.$temp->trx_reward_id.'\')" style="cursor: pointer;" class="btn btn-default btn-xs">Edit</a><a onclick="viewdata(\''.$temp->trx_reward_id.'\')" style="cursor: pointer;" class="btn btn-default btn-xs">View</a>';
            $record[] = '<input type="checkbox" name="edit-reward-id['.$temp->trx_reward_id.']" >';

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
	
	public function punishment($page=null, $id=null){
        $data['kode_menu'] = $this->kode_menu;
        $data['url'] = $this->url;

		$pun = array();
		$query_trx_punishment = $this->trx_punishment_model->get_trx_punishment();
        if($query_trx_punishment->num_rows()>0){
			$query_trx_punishment = $query_trx_punishment->result();
        	foreach ($query_trx_punishment as $temp) {
				$pun[$temp->user_id] = $temp->level;
			}
		}
		
		//Query ke tabel cbt user
		$select = '';
		$query_cbt_user = $this->trx_punishment_model->get_master_cbt_user_haveid_card();
        if($query_cbt_user->num_rows()>0){
        	$select = '<option value="">--PILIH--</option>';
        	$query_cbt_user = $query_cbt_user->result();
        	foreach ($query_cbt_user as $temp) {
        		$select = $select.'<option value="'.$temp->id.'" data-level="'.@$pun[$temp->id].'" data-mitra-id="'.$temp->mitra_id.'" data-jabatan-id="'.$temp->jabatan_id.'">'.$temp->nomor_pass.' - '.$temp->user_firstname.'</option>';
        	}

        }else{
        	$select = '<option value="10000000">KOSONG</option>';
        }
		
        $data['select_cbt_user'] = $select;
		//Query ke tabel cbt user
		//Query ke tabel perusahaan
		$select = '';
		$query_mitra = $this->trx_reward_model->get_master_mitra();
        if($query_mitra->num_rows()>0){
        	$select = '<option value="">--PILIH--</option>';
        	$query_mitra = $query_mitra->result();
        	foreach ($query_mitra as $temp) {
        		$select = $select.'<option value="'.$temp->mitra_id.'">'.$temp->mitra_nama.'</option>';
        	}

        }else{
        	$select = '<option value="10000000">KOSONG</option>';
        }
		
        $data['select_perusahaan'] = $select;
		//Query ke tabel perusahaan
		//Query ke tabel posisi
		$select = '';
		$query_jabatan = $this->trx_reward_model->get_master_jabatan();
        if($query_jabatan->num_rows()>0){
        	$select = '<option value="">--PILIH--</option>';
        	$query_jabatan = $query_jabatan->result();
        	foreach ($query_jabatan as $temp) {
        		$select = $select.'<option value="'.$temp->jabatan_id.'">'.$temp->user_jabatan.'</option>';
        	}

        }else{
        	$select = '<option value="10000000">KOSONG</option>';
        }
		
        $data['select_posisi'] = $select;
		//Query ke tabel posisi
		//Query ke tabel reward
		$select = '';
		$query_punishment = $this->trx_punishment_model->get_master_punishment();
        if($query_punishment->num_rows()>0){
        	$select = '';
        	$query_punishment = $query_punishment->result();
        	foreach ($query_punishment as $temp) {
        		$select = $select.'<option value="'.$temp->punishment_id.'">'.$temp->name.'</option>';
        	}

        }else{
        	$select = '<option value="10000000">KOSONG</option>';
        }
		
        $data['select_prestasi'] = $select;
		//Query ke tabel reward
        
        $this->template->display_admin($this->kelompok.'/punishment_view', 'Daftar Topik', $data);
    }

}