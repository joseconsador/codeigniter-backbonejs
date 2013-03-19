<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2012-10-23
 */

class Contact_model extends MY_Model
{
    protected $_table = 'user_contact';
    protected $_primary = 'id';	

	// --------------------------------------------------------------------

    public function get_by_user($user_id)
    {
        $this->db->order_by('is_primary', 'desc');
        $this->db->where('user_id', $user_id);
        $contacts = $this->db->get($this->_table);

        $c = array();
        if ($contacts->num_rows() > 0) {

            foreach ($contacts->result() as $contact) {
                $o_c = new User_Contact($contact);
                $c[] = $o_c->getData();
            }

            return $c;
        }

        return FALSE;
    }
}