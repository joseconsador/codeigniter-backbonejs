<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2013-03-15
 */

class Points_model extends MY_Model
{
    protected $_table = 'user_point';
    protected $_primary = 'user_point_id';

    protected $_allowed_filters = array('user_id');

    public function get_user_points($user_id)
    {
    	$points = $this->search('user_id', $user_id);
    	
    	
    }
}