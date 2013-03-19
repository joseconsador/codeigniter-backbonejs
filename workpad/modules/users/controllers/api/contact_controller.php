<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Contact_controller extends HDI_rest_controller
{    
	function __construct()
	{
		parent::__construct();     
	}

    // --------------------------------------------------------------------
    
    /**
     * Get a user's contact entries.
     * 
     * @return xml
     */
    function contact_get()
    {
        $this->load->model('contact_model');
        $contacts = $this->contact_model->get_by_user($this->get('user_id'));
        
        $this->response($contacts);
    }

    // --------------------------------------------------------------------
    
    /**
     * Creates a user's contact entries.
     * 
     * @return xml
     */
    function contact_post()
    {        
        $contact = new User_Contact();

        $this->_contact_save($contact, 'post');
    }  

    // --------------------------------------------------------------------
    
    /**
     * Updates an contact entry.
     * 
     * @return xml
     */
    function contact_put()
    {        
        $contact = new User_Contact($this->put('id'));

        $this->_contact_save($contact, 'put');
    }     

    private function _contact_save($contact, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');

        $contact->user_id      = $this->get_user()->user_id;
        $contact->contact_type = $this->{$mode}('contact_type');
        $contact->mobile       = $this->{$mode}('mobile');
        $contact->contact      = $this->{$mode}('contact');
        $contact->im_tag       = $this->{$mode}('im_tag');
        $contact->is_primary   = $this->{$mode}('is_primary');
        
        $this->save($contact);
    }
}