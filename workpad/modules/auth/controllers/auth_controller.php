<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth_controller extends Front_Controller
{
	// --------------------------------------------------------------------	
	
	function login()	
	{
		if (is_logged_in()) {
			redirect('profile');
		}

		add_js('modules/login.js');
		$this->layout->view('login');
	}

	// --------------------------------------------------------------------	

	function logout()
	{		
		$this->session->sess_destroy();
		redirect('auth/login');
	}

	// --------------------------------------------------------------------	

	function get_redirect_url()
	{
		$this->load->view('ajax', array('html' => $this->session->userdata('redirect_url')));
	}

	// --------------------------------------------------------------------	

	function client_login()
	{
		$username = $this->input->post('username');
		$password = md5($this->input->post('password'));

		$this->_load_rest_client('');
		// Request keys from the API server.
		$valid = $this->rest->post('auth/login', array('username' => $username, 'password' => $password), null, FALSE);

		if ($this->rest->status() == 200) {
			// Get user id
			$user = $this->rest->get('user', array($this->config->item('rest_key_name') => $valid->key));
			
			$this->session->set_userdata('user_id', $user->user_id);
			$this->session->set_userdata('api_key', $valid->key);
			$this->session->set_userdata('logged_in', TRUE);
		}

		$this->load->view('ajax', array('json' => array('status' => $this->rest->status())));
	}
}