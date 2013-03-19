<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2013-01-25
 */

class Todo_model extends MY_Model
{
    protected $_table = 'user_todo';
    protected $_primary = 'todo_id';    

    protected $_allowed_filters = array('user_id', 'completed');    
}