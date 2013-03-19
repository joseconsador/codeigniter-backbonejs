<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feeds_controller extends HDI_rest_controller
{
	// --------------------------------------------------------------------

	/**
	* Post a feed to the current user's stream
	* 
	*/
	function feed_post()
	{
		if (!$this->acl->check_acl('FEED_POST', $this->get_user()->login)) {
			$this->response(FALSE, 401);
		} else {
			$this->load->library('feed');

			$response = array('status' => 'failed', 'message' => '');

			$data = array(
				'user_id'  => $this->get_user()->user_id,
				'feeds'	   => $this->post('feeds'),
				'restricted_to' => $this->post('restrict')
				);

			$feed = new Feed($data);

			if (!$feed->save()) {
				$response['message'] = $feed->get_validation_errors();
			} else {				
				$response['status'] = 200;
				$response['id']   = $feed->id;
			}
			
			$this->response($response);
		}

	}

	// --------------------------------------------------------------------

	/**
	* Update a feed
	* 
	*/
	function feed_put()
	{		

	}	

	// --------------------------------------------------------------------

	/**
	* Get a post.
	* 
	*/
	function feed_get()
	{
		$this->load->library('feed');
		$feed = new Feed($this->get('id'));

		$this->response(array('data' => $feed->getData()));
	}

	// --------------------------------------------------------------------

	/**
	* Delete a post.
	* 
	*/
	function feed_delete()
	{
		$this->load->library('feed');
		// Get feed to determine if user is allowed to delete.
		$feed = new Feed($this->get('id'));

		if (!$feed->hasData()) {
			// Throw a 404 if this feed does not exist.
			$this->response(FALSE);
		} else {
			if ($feed->delete()) {
				$this->response(TRUE);
			} else {
				$this->response(array($feed->get_validation_errors()));
			}
		}
	
	}

	// --------------------------------------------------------------------

	/**
	* Get user's feed.
	* 
	*/
	function user_get()
	{
		$this->load->model('feeds_model');
		$this->load->library('user');

		$offset = null;
        $limit = 10;
        if ($this->get('limit') != '') {
            $limit  = $this->get('limit');            
	        
	        if ($this->get('offset') != '') {
	            $offset = $this->get('offset');
	        }
        }        

        $user = new User();
        $user->load($this->get('id'));

		$this->response($this->feeds_model->get_by_user($user->getData(), $limit, $offset));
	}
}