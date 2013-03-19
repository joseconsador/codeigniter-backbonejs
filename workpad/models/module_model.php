<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'core/MY_Model.php');
/**
 *
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2012-11-18
 */

class Module_model extends MY_Model
{
    protected $_table = 'admin_module';
    protected $_primary = 'module_id';
}