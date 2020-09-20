<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* ZYA CBT
* Achmad Lutfi
* achmdlutfi@gmail.com
* achmadlutfi.wordpress.com
*/
class Welcome extends CI_Controller {
	private $kelompok = 'ujian';
	private $url = 'welcome';

	function __construct(){
		parent:: __construct();
		$this->load->model('cbt_konfigurasi_model');
		$this->load->library('access_tes');
		$this->load->library('user_agent');
	}
    
	public function index(){
		$data['url'] = $this->url;
		$data['timestamp'] = strtotime(date('Y-m-d H:i:s'));
		if ($this->agent->is_browser()){
            if($this->agent->browser()=='Internet Explorer' ){
                $this->template->display_user('blokbrowser_view', 'Browser yang didukung');
            }else{
                if(!$this->access_tes->is_login()){
					$data['link_login_operator'] = "tidak";
					$query_konfigurasi = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'link_login_operator', 1);
					if($query_konfigurasi->num_rows()>0){
						$data['link_login_operator'] = $query_konfigurasi->row()->konfigurasi_isi;
					}
                    $this->template->display_login($this->kelompok.'/welcome_login', 'Selamat Datang', $data);
        		}else{
					if(!$this->session->userdata('multilogin')){
						/*
						$url = '../../filemanager/index.php?loginapi=WahyuOKSbgD887289&username='.base64_encode($this->session->userdata('username')).'&password='.base64_encode($this->session->userdata('password'));
						$this->session->set_userdata('multilogin',true);
						echo '<script>window.location = "'.$url.'";</script>';
						*/
						#header('Location: ' . $url, true);
						redirect('home');
					}else
						redirect('home');
        		}
            }
        }else{
            $this->template->display_user('blokbrowser_view', 'Browser yang didukung');
        }
	}

	function login(){
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('username', 'Username','required|strip_tags');
        $this->form_validation->set_rules('password', 'Password','required|strip_tags');
        if($this->form_validation->run() == TRUE){
            $this->form_validation->set_rules('token','token','callback_check_login');
			if($this->form_validation->run() == FALSE){
				//Jika login gagal
                $status['status'] = 0;
                $status['error'] = validation_errors();
			}else{
				//Jika sukses
                $status['status'] = 1;
			}
        }else{
            $status['status'] = 0;
            $status['error'] = validation_errors();
        }
        echo json_encode($status);
    }
    
    function logout(){
		$this->access_tes->logout();
		redirect('manager/welcome/logout');
	}
	
	function check_login(){	
		$username = base64_decode(base64_decode($this->input->post('username',TRUE)));
		$password = base64_decode(base64_decode($this->input->post('password',TRUE)));
		
		$login = $this->access_tes->login($username, $password, $this->input->ip_address());
		if($login==1){
			$this->access->login($username, $password, $this->input->ip_address());
			return TRUE;
		}else if($login==2){
			$this->form_validation->set_message('check_login','Password yang dimasukkan salah');
			return FALSE;
		}else{
			$this->form_validation->set_message('check_login','Username yang dimasukkan tidak dikenal');
			return FALSE;
		}
	}
	
	function testhome(){
	    $this->template->display_home($this->kelompok.'/welcome_login', 'Selamat Datang', null);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */