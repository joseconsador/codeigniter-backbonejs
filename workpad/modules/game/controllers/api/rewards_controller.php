<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rewards_controller extends HDI_rest_controller
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('reward_model', 'model');
    }

    // --------------------------------------------------------------------

    function rewards_get()
    {
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('rewards' . serialize($this->_args));
        $last_modified = $this->model->get_last_modified_date();

        if (!$response || $last_modified != $response['_last_modified']) {
            $response = array();
            $response['_count'] = $this->model->count_results($this->_args);
            $response['_last_modified'] = $last_modified;

            if ($response['_count'] > 0)
            {
                $results = $this->model->fetch($this->_args, TRUE);

                $rewards = $results->result();

                foreach ($rewards as $reward) {
                    $e = new Reward();                    
                    $response['data'][] = $e->loadArray($reward)->getData();
                }
            }                 
            
            $cache::save('rewards' . serialize($this->_args), $response);
        }

        $this->response($response);
    }

    // --------------------------------------------------------------------

    function reward_get()
    {
        $reward = new Reward($this->get('id'));

        $this->response($reward->getData());
    }        

    // --------------------------------------------------------------------
    
    function reward_post() 
    {
        if ($this->acl->check_acl('REWARDS_ALL')) {        
            $reward = new Reward();
            $reward->persist($this->_args);

            $this->save($reward);
        } else {
            show_access_denied();
        }
    }

    // --------------------------------------------------------------------
    
    function reward_put() 
    {
        if ($this->acl->check_acl('REWARDS_ALL')) {        
            $reward = new Reward($this->get('id'));

            $reward->persist($this->_args);
            $this->save($reward);
        } else {
            show_access_denied();
        }
    }

    // --------------------------------------------------------------------

    function reward_delete()
    {
        if ($this->acl->check_acl('REWARDS_ALL')) {        
            $this->delete(new Reward($this->get('id')));
        } else {
            show_access_denied();
        }
    }

    // --------------------------------------------------------------------
    
    function redeem_post()
    {        
        $reward_claim = new Reward_Claim();
        $reward_claim->reward_id    = $this->get('id');
        $reward_claim->user_id      = $this->get_user()->user_id;
        $reward_claim->date_claimed = date('Y-m-d H:i:s');

        $this->save($reward_claim);
    }    
}