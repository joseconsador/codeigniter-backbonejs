<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Photo_controller extends HDI_rest_controller
{    
	function __construct()
	{
		parent::__construct();

        $this->load->library('user');
	}

    // --------------------------------------------------------------------
    
    /**
     * Returns photo URL of user.     
     */
    public function photo_get()
    {        
        if (($id = $this->get('id')) == FALSE) {
            $id = $this->get_user()->user_id;            
        }

        $user = new User($id);    

        if ($this->get('thumbnail') == TRUE) {
            $url = $user->getThumbnailUrl();
        } else {
            $url = $user->getPhotoUrl();
        }         

        $response = array('url' => $url);

        $this->response($response, 200, 'html');
    }
}