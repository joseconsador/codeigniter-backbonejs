<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Oauth extends CI_Controller {

	public function __construct()
	{		
		parent::__construct();			
	}

	public function callback()
	{
		if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
          || $_SERVER['SERVER_PORT'] == 443) {          	
			//redirect('oauth/callback');
		}

		$this->load->helper('dir');
		$this->load->config('dir');
		add_js('libs/google/tokenparser.js');
		
		$this->load->view('header');
		$this->load->view('footer');
	}

	public function catchtoken()
	{
		if ($this->input->get('error') != 'access_denied') {
			$this->_load_rest_client($this->session->userdata('api_key'));

			$this->rest->put('user', array('oauth_token' => $this->input->get('access_token')));

			$uri = 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $this->input->get('access_token');

			$curl = curl_init($uri);

			curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

			$json_response = json_decode(curl_exec($curl));
			curl_close($curl);

			$this->rest->put('user', array('google_id' => $json_response->id));

			$this->load->view('ajax');
		}
	}

    protected function _load_rest_client($key)
    {
        $this->load->config('rest');

        $this->load->library('rest', array(
            'server' => site_url('api'),
            // Load the api key retrieved after login.        
            'api_key' => array('key' => $key, 'name' => $this->config->item('rest_key_name'))
        ));

        if (ENVIRONMENT == 'development') {
            $this->rest->option('SSL_VERIFYPEER', TRUE);
            $this->rest->option('CAINFO', getcwd() . '\uploads\settings\system\cert.crt');
        }

        $this->rest->option('SSL_VERIFYHOST', 2);
    }
}

/* End of file oauth.php */
/* Location: ./application/controllers/oauth.php */