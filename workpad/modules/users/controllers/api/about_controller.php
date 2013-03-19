<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class About_controller extends HDI_rest_controller
{    
	function __construct()
	{
		parent::__construct();        
	}

    // --------------------------------------------------------------------
    
    /**
     * Creates a user's about entries.
     * 
     * @return xml
     */
    function about_post()
    {        
        $about = new User_About();

        $this->response($this->_about_save($about, 'post'));
    }  

    // --------------------------------------------------------------------
    
    /**
     * Updates an about entry.
     * 
     * @return xml
     */
    function about_put()
    {
        $about = new User_About($this->put('id'));

        $this->response($this->_about_save($about, 'put'));
    }     

    private function _about_save($about, $mode)
    {
        $delete_photo = FALSE;

        $response = array('status' => 'failed', 'message' => '');

        $about->user_id  = $this->{$mode}('user_id');
        $about->about_me = $this->{$mode}('about_me');
        $about->talent   = $this->{$mode}('talent');
        $about->movies   = $this->{$mode}('movies');
        $about->music    = $this->{$mode}('music');
        $about->website  = $this->{$mode}('website');

        if ($this->{$mode}('photo') != '' && $this->{$mode}('photo') != $about->photo) {
            $delete_photo = $about->photo;
        }

        $about->photo = $this->{$mode}('photo');
        
        $id = $about->save();

        if ($id) {
            $response = $about->getData();
            $response['id'] = $id;
            $response['status']  = 'success';

            if ($delete_photo) {
                $this->load->config('dir');
                $upload_path = $this->config->item('upload_dir');                
                unlink ($upload_path . 'media/' . $delete_photo);
                unlink ($upload_path . 'media/thumbnails/' . $delete_photo);
            }

            $cache = Cache::get_instance();
            $cache->delete('user' . $about->user_id);
        } else {
            $response['message'] = $about->get_validation_errors();
        }

        return $response;
    }
}