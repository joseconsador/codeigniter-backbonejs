<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2012-10-18
 */

class Feeds_model extends MY_Model
{
    protected $_table = 'log_feeds';
    protected $_primary = 'id';

    // --------------------------------------------------------------------

    public function get_by_user($user, $limit = null, $offset = null, $sort = null, $order = 'desc')
    {                
        $search = array(
            array(
                'type'  => 'eq',
                'field' => 'user_id',
                'value' => $user['user_id']
            )
        );

        $ci =& get_instance();
        
        if ($ci->get_user()->department_id != $user['department_id']) {
            $search[] = array(
                'type'  => 'eq',
                'field' => 'restricted_to',
                'value' => 0
            );
        }

        $o_feeds = $this->search($search, null, $limit, $offset, $sort, $order);

        if ($o_feeds->num_rows() == 0) {
            return FALSE;
        } else {
            $feeds = array();
            $this->load->library('feed');

            foreach ($o_feeds->result() as $rfeed) {
                $cache = Cache::get_instance();
                $feed = $cache::get('feed' . $rfeed->id);

                if (!$feed) {
                    $o_feed = new Feed($rfeed->id);
                    $feed = $o_feed->getData();
                    $cache::save('feed' . $rfeed->id, $feed);
                }

                $feeds[] = $feed;
            }

            return $feeds;
        }
    }
}