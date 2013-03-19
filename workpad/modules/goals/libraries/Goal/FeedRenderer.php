<?php

class Goal_FeedRenderer extends Activity_Renderer
{
	public function create()
	{
        return $this->render();
	}

    public function render()
    {
        $ci =& get_instance();
        $ci->load->library('parser');        

        $data = unserialize($this->get_source()->data);

        if (_p($data, 'created_by') == $ci->get_user()->user_id) {
            $data['created_by_name'] = 'You';
        }

        if ($this->get_source()->user_id == $ci->get_user()->user_id) {
            $data['full_name'] = 'You';
        }

        return $ci->parser->parse(
            'goals/template/feed_goal_template', 
            array(
                'created_by_name' => _p($data, 'created_by_name'),
                'full_name' => _p($data, 'full_name'),
                'target' => _p($data, 'target'),
                'title' => _p($data, 'title'),
            )
            , TRUE
        );   
    }
}