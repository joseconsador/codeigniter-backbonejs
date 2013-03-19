<?php

class Form_Application_FeedRenderer extends Activity_Renderer
{
    private $_verb;

    public function create()
    {
        $ci =& get_instance();

        $data = $this->get_data();

        if ($this->get_source()->user_id == $ci->get_user()->user_id) {
            $data['full_name'] = 'You';
        }

        $this->_prefix = anchor('#', _p($data, 'full_name'));
        $this->_verb = 'filed for a';
        $this->_suffix = anchor('supervisor/form_applications#/form/' . $data['id'], '<strong>' . _p($data, 'form_type') . '</strong>');
            
        if ($data['date_from'] == $data['date_to']) {
            $this->_suffix .= ' on ' . _d($data['date_from'], 'M d');
        } else {
            $this->_suffix .= ' from ' 
                . _d($data['date_from'], 'M d') . ' to ' . _d($data['date_to'], 'M d');
        }

        return $this->render();
    }

    public function approve()
    {
        $ci =& get_instance();

        $data = $this->get_data();

        if ($data['modified_by_id'] == $ci->get_user()->user_id) {
            $data['modified_by_name'] = 'You';
        }

        if ($this->get_source()->user_id == $ci->get_user()->user_id) {
            $data['full_name'] = 'your';
        } else {
            $data['full_name'] .= '\'s';
        }

        $this->_prefix = anchor('#', _p($data, 'modified_by_name'));

        $this->_verb = 'approved';
        $this->_suffix = anchor('#', '<strong>' . _p($data, 'full_name') . '</strong>') 
            . ' ' . _p($data, 'form_type');        
        return $this->render();
    }

    public function decline()
    {
        $ci =& get_instance();

        $data = $this->get_data();

        if ($data['modified_by_id'] == $ci->get_user()->user_id) {
            $data['modified_by_name'] = 'You';
        }

        if ($this->get_source()->user_id == $ci->get_user()->user_id) {
            $data['full_name'] = 'your';
        } else {
            $data['full_name'] .= '\'s';
        }

        $this->_prefix = anchor('#', _p($data, 'modified_by_name'));

        $this->_verb = 'declined';
        $this->_suffix = anchor('#', '<strong>' . _p($data, 'full_name') . '</strong>') 
            . ' ' . _p($data, 'form_type');        
        return $this->render();
    }    

	public function render()
	{
        $ci =& get_instance();
        $ci->load->library('parser');

        return $ci->parser->parse(
            'template/feed_form_application_template', 
            array(
            	'prefix' => $this->_prefix,
            	'suffix' => $this->_suffix,
                'verb' => $this->_verb,
            )
            , TRUE
        );        
	}
}