<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2012-10-18
 */

class Activity_model extends MY_Model
{
    protected $_table = 'log_activity';
    protected $_primary = 'log_id';

    protected $_allowed_filters = array('exclude_ids');


    // --------------------------------------------------------------------

    public function do_create($params)
    {
    	$params['created_date'] = date('Y-m-d');
    	$params['modified_date'] = date('Y-m-d');

    	return parent::do_create($params);
    }

    // --------------------------------------------------------------------

    public function do_update($params)
    {
    	$params['modified_date'] = date('Y-m-d');

    	return parent::do_update($params);
    }        
}