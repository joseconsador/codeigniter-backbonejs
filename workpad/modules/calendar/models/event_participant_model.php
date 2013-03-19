<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Event_participant_model extends MY_Model
{
    protected $_table = 'time_calendar_event_participant';
    protected $_primary = 'event_participant_id';

    // --------------------------------------------------------------------        

	public function get_by_event_id($event_id)
	{
		return $this->search($this->get_table_name() . '.event_id', $event_id);
	}    

	// --------------------------------------------------------------------        
	
	protected function _set_join() 
	{
		$this->db->select($this->get_table_name() . '.*, CONCAT(first_name, " ", last_name) full_name,
			time_calendar_event.date_from, time_calendar_event.date_to'
			, FALSE);
		$this->db->join('user', 'user.user_id = ' . $this->get_table_name() . '.user_id', 'left');
		$this->db->join('time_calendar_event', 'time_calendar_event.event_id = time_calendar_event_participant.event_id', 'left');		
	}

	// --------------------------------------------------------------------        
	
	public function get_by_user($user_id, $args = array())
	{
		$search = array(
			array(
				'field' => $this->get_table_name() .'.user_id',
				'type'  => 'eq',
				'value' => $user_id
				)
			);

		return parent::fetch($args, FALSE, $search);
	}	

	// --------------------------------------------------------------------        
	
	public function get_by_date_user_participant($user_id, $from, $to, $args = array())
	{
		$this->load->model('event_participant_model');

		$search = array(			
			array(
				'field' => $this->get_table_name() . '.user_id',
				'type'  => 'eq',
				'value' => $user_id
				),
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

		return parent::fetch($args, FALSE, $search);		
	}
}