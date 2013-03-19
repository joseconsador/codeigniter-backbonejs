<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Event_model extends MY_Model
{
    protected $_table = 'time_calendar_event';
    protected $_primary = 'event_id';

    protected $_allowed_filters = array('user_id', 'date_from', 'date_to', 'exclude_ids');

    // --------------------------------------------------------------------        

    public function fetch_calendar_events(User $user, $date_from, $date_to, $args)
    {   
    	$this->load->model(array('holiday_model', 'event_participant_model'));

    	$args['user_id'] = $user->user_id;
        
        if ($user->isEmployee()) {
            $args['employee_id'] = $user->employee_id;
        }

        $o_events = $this->fetch_in_dates($date_from, $date_to, $args);        

        $events = array();
		
		$events['event'] = array();

        if ($o_events->num_rows() > 0) {
            $events['event'] = $o_events->result();
        }

        $p_events = $this->event_participant_model->get_by_date_user_participant($user->user_id, $date_from, $date_to);

        if ($p_events->num_rows() > 0) {
            $events['involvedEvent'] = $p_events->result();
        }

        $holidays = $this->holiday_model->fetch(array(), FALSE, array(
			array(
				'field' => 'calendar',
				'type'  => 'gte',
				'value' => date('Y-m-d', $date_from)
				),
			array(
				'field' => 'calendar',
				'type'  => 'lte',
				'value' => date('Y-m-d', $date_to)
				),		
        	)
        );

        if ($holidays->num_rows() > 0) {
        	$events['holiday'] = $holidays->result();
        }

        if ($user->isEmployee()) {
            $leaves = $this->form_application_model->get_employee_leaves($user->employee_id, $args);
            $leaves = $leaves->result();

            $events['form'] = $leaves;
        	
//        	$sp_events = $this->model->s_fetch_all($date_from, $date_to, $user->employee_id, $user->user_id);
        } else {
//        	$sp_events = $this->model->s_fetch_all($date_from, $date_to, 0, $user->user_id);
        }

/*        $sp_events = $this->model->s_fetch_all($date_from, $date_to, $user->employee_id, $user->user_id);
        $events['default'] = $sp_events->result();*/
        
        return $events;
    }

    // --------------------------------------------------------------------

	/**
	 * Fetch all events using the stored proc
	 * 
	 * @param  timestamp $from
	 * @param  timestamp $to   
	 * 
	 * @return object      
	 */
	public function s_fetch_all($from, $to, $employee_id, $user_id)
	{
		return $this->db->query('CALL sp_time_calendar("'
			. date('Y-m-d H:i:s', $from) . '", 
			"'. date('Y-m-d H:i:s', $to) .'", 
			'. $employee_id .',
			'. $user_id . ')');
	}

	// --------------------------------------------------------------------
	// 
	public function fetch_in_dates($from, $to, $args = array())
	{
		$search = $this->_get_date_search($from, $to);

		return parent::fetch($args, FALSE, $search);
	}

	// --------------------------------------------------------------------

	private function _get_date_search($from, $to)
	{
		if (isset($args['date_from'])) unset($args['date_from']);
		if (isset($args['date_to'])) unset($args['date_to']);

		$search = array(
			array(
				'field' => 'date_from',
				'type'  => 'gte',
				'value' => date('Y-m-d', $from)
				),
			array(
				'field' => 'date_to',
				'type'  => 'lte',
				'value' => date('Y-m-d', $to)
				),
			);

		return $search;		
	}	
}