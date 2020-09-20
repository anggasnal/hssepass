<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* ZYA CBT
* Achmad Lutfi
* achmdlutfi@gmail.com
* achmadlutfi.wordpress.com
*/
class Access_tes{
	function __construct(){
		$this->CI =& get_instance();
		
		$this->CI->load->helper('cookie');
		$this->CI->load->model('cbt_user_model');
		
		$this->users_model =& $this->CI->cbt_user_model;
	}
	
	
	/**
	 * proses login
	 * 0 = username tak ada
	 * 1 = sukses
	 * 2 = password salah
	 * @param unknown_type $username
	 * @param unknown_type $password
	 * @return boolean
	 */
	function login($username, $password){
		$result = $this->users_model->get_by_username($username);
		if($result){
			if(md5($password) === $result->password){
				$this->CI->session->set_userdata('cbt_tes_id',$result->username);
                $this->CI->session->set_userdata('cbt_tes_nama',stripslashes($result->user_firstname));
                $this->CI->session->set_userdata('cbt_tes_group',$result->grup_nama);
                $this->CI->session->set_userdata('cbt_tes_group_id',$result->grup_id);
                $this->CI->session->set_userdata('idUser',$result->id);
                $this->CI->session->set_userdata('username',$result->username);
                $this->CI->session->set_userdata('password',$result->password);
                $this->CI->session->set_userdata('accesslevel',$result->accesslevel);
                $this->CI->session->set_userdata('divisi',$result->divisi_id);
                $this->CI->session->set_userdata('multilogin',false);
				#echo $url = 'http://localhost:82/pgn/filemanager/index.php?loginapi=WahyuOKSbgD887289&username='.base64_encode($result->username).'&password='.base64_encode($result->password);
				#$result = file_get_contents($url);
                #var_dump($result);exit;        
				#header('Location: ' . $url, true, 302);
					
				return 1;
			}else{
				return 2;
			}
		}
		return 0;
	}
	
	/**
	 * cek apakah sudah login
	 * @return boolean
	 */
	function is_login(){
		return (($this->CI->session->userdata('cbt_tes_id')) ? TRUE : FALSE);
	}
	
	function get_username(){
		return $this->CI->session->userdata('cbt_tes_id');
	}
    
    function get_nama(){
		return $this->CI->session->userdata('cbt_tes_nama');
	}
    
    function get_group(){
		return $this->CI->session->userdata('cbt_tes_group');
	}
    
    function get_group_id(){
		return $this->CI->session->userdata('cbt_tes_group_id');
	}
	
	/**
	 * logout
	 */
	function logout(){
		$this->CI->session->unset_userdata('cbt_tes_id');
		$this->CI->session->unset_userdata('cbt_tes_nama');
		$this->CI->session->unset_userdata('cbt_tes_group_id');
		$this->CI->session->unset_userdata('cbt_tes_group');
	}
}