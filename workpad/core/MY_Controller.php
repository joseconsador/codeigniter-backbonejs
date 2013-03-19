<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class that holds common implementations for frontend and admin.
 */
abstract class MY_Controller extends CI_Controller
{
    public $user;

    private $_modules;
    // --------------------------------------------------------------------
    
    public function __construct()
    {
        parent::__construct();        

        // Loads module packages.
        $this->_load_module_packages();

        if (!$this->check_login_status()) {
        	throw new Exception('Please log-in.');
        }
                               
        // Load asset paths config.
        $this->load->config('dir');

        // Load directory helper.
        $this->load->helper('dir');

        // Determine what template to use.
        $this->setLayout();

        $this->_prep_view_data();
    }

    protected function _load_rest_client($key = null)
    {
        $this->load->config('rest');

        $this->load->library('rest', array(
            'server' => site_url('api'),
            // Load the api key retrieved after login.        
            'api_key' => array('key' => $key, 'name' => $this->config->item('rest_key_name'))
        ));

        if (ENVIRONMENT == 'development') {
            $this->rest->option('SSL_VERIFYPEER', TRUE);
            $this->rest->option('CAINFO', getcwd() . '\uploads\settings\system\cert.crt');
        }

        $this->rest->option('SSL_VERIFYHOST', 2);
    }

    // --------------------------------------------------------------------    
    
    /**
     * Have to remap the call to the controller in case there are some uri segments issues.
     */    
    function _remap($method, $params = array())
    {
        if (method_exists($this, $method))
        {
            if (isset($params[0]) && $method == $params[0])
            {
                unset($params[0]);
            }
            
            return call_user_func_array(array($this, $method), $params);
        }
    }
    
    // --------------------------------------------------------------------    
    
    function _load_module_packages()
    {
        $modules = get_modules();
        
        foreach ($modules as $module)
        {
            if ($module['enabled']) {
                $this->load->add_package_path(MODPATH . $module['dir']);
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * 
     */
    protected function _prep_view_data()
    {
        add_js('libs/bootstrap/bootstrap.min.js');
        add_js('libs/bootstrapx-clickover.js');
            
        /*add_js('libs/jquery-ui-1.8.16.custom.min.js');*/
        add_js('libs/jquery-ui-1.9.2.custom.min.js');
        add_js('libs/jquery.validate.min.js');        

        add_js('libs/date.js');    

        add_js('libs/underscore.js');
        add_js('libs/backbone-min.js');
        add_js('libs/backbone-paginator.min.js');

        add_js('libs/jquery.timeago.js');
        add_js('libs/enhance.min.js');
        add_js('libs/fileinput.jquery.js');
        add_js('app.js');

        add_css('table-responsive.css');

        add_css('modalmanager/bootstrap-modal.css');

        add_js('libs/modalmanager/bootstrap-modalmanager.js');
        add_js('libs/modalmanager/bootstrap-modal.js');
    }

    // --------------------------------------------------------------------
    
    /**
     * Determines which template to use depending on the current location.
     */
    private function _define_template()
    {
        // Load our custom layout library.
        $this->load->library('layout');
        $this->layout->setLayout('layout/base');
    }

	// ------------------------------------------------------------------------

	/**
	 * Define what layout to use for controller
	 */
	abstract function setLayout();

    // ------------------------------------------------------------------------

    /**
     * Force extending classes to check login
     */
	abstract function check_login_status();
}

// ------------------------------------------------------------------------

/**
 * Frontend specific 
 */
class Front_Controller extends MY_Controller
{	
    protected function _prep_view_data()
    {
        parent::_prep_view_data();
        if (is_logged_in()) {            
            add_js('modules/user.js');
            add_js('modules/message/app.js');
            add_js('modules/message/model.js');
            add_js('modules/message/collection.js');
            add_js('modules/message/view.js');
            add_js('modules/message/modal_message.js');
            add_js('notifications.js');
        }
    }

	// ------------------------------------------------------------------------
	
	function setLayout()
	{
		$this->layout->setLayout('layout/front');
	}

    // ------------------------------------------------------------------------

	function check_login_status()
	{
        if (!is_logged_in() && $this->uri->segment(1) != 'auth' && $this->uri->segment(1) != 'notifications') {
            $this->session->set_userdata('redirect_url', $this->uri->uri_string());
            redirect('auth/login');
        } elseif (is_logged_in() && $this->uri->segment(1) != 'logout') {
            $this->_load_rest_client($this->session->userdata('api_key'));

            $this->user = $this->rest->get('user');
        }

        return TRUE;
	}

    // ------------------------------------------------------------------------

    function get_user()
    {
        return $this->user;
    }

    // ------------------------------------------------------------------------
    
    function render_nav()
    {
        $this->load->helper('html');

        $navxml_path = APPPATH . 'config/nav.xml';
        $top = simplexml_load_file($navxml_path);
        $modules = get_modules();        

        foreach ($modules as $module) {
            $navxml_path = MODPATH . $module['dir'] . '/config/nav.xml';
            if (file_exists($navxml_path)) {
                $modnavs = simplexml_load_file($navxml_path);
                foreach ($modnavs as $parent => $nav) {
                    if (isset($nav->children)) {
                        append_simplexml($top->{$parent}->children, $nav->children);
                    }
                }
            }
        }

        $nav = '<ul class="nav">';

        foreach ($top as $t) {
            if (is_allowed((string) $t->access)) {
                $li = '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'
                        . (string) $t->label . ' <b class="caret visible-desktop"></b></a>';
                $nav .= '<li class="dropdown">' . $li;

                if (count($t->children) > 0) {
                    $nav .= '<ul class="dropdown-menu visible-desktop">';
                    // Assign $t->children[0] because it cannot be passed by reference.
                    
                    $children = (array) $t->children[0];
                    // Sorts according to order
                    usort($children, function($a, $b) {
                        
                        if (!isset($a->order)) $a->order = '9999';
                        if (!isset($b->order)) $b->order = '9999';

                        return strnatcmp((string) $a->order, (string) $b->order);
                    });

                    foreach ($children as $child) {
                        $nav .= '<li>' . anchor($child->link, $child->label) . '</li>';
                    }

                    $nav .= '</ul>';
                }

                $nav .= '</li>';
            }
        }

        $nav .= '</ul>';

        return $nav;
    }
}

// ------------------------------------------------------------------------

class Admin_Controller extends MY_Controller
{
	function check_login_status()
	{
        if (!is_logged_in() && $this->uri->segment(1) != 'auth' && !$this->is_admin()) {
        	redirect('auth/login');
        } elseif (is_logged_in() && $this->uri->segment(1) != 'logout') {
            $this->_load_rest_client($this->session->userdata('api_key'));

            $this->user = $this->rest->get('user');
        }

        return TRUE;
	}

	// ------------------------------------------------------------------------

	function setLayout()
	{
		$this->layout->setLayout('layout/front');
	}

	// ------------------------------------------------------------------------
	
    function is_admin() 
    {
        return ($this->user->group_id == 1);
    }		

    protected function _prep_view_data()
    {
        parent::_prep_view_data();
        if (is_logged_in()) {            
            add_js('modules/user.js');
            add_js('modules/message/app.js');
            add_js('modules/message/model.js');
            add_js('modules/message/collection.js');
            add_js('modules/message/view.js');
            add_js('modules/message/modal_message.js');
            add_js('notifications.js');
        }
    }
    
}

require_once (APPPATH . 'libraries/REST_Controller.php');

// ------------------------------------------------------------------------

class HDI_rest_controller extends REST_controller
{    
    private $_user = null;

    public function __construct()
    {
        parent::__construct();

        $this->load->library('acl');
    }

    /**
     * When the client is logged in we can retrieve the credentials.
     * @return [type] [description]
     */
    public function get_user()
    {
        if (is_null($this->_user)) {
            $this->load->library('user');

            // Get the api key name variable set in the rest config file
            $api_key_variable = config_item('rest_key_name');

            // Work out the name of the SERVER entry based on config
            $key_name = 'HTTP_'.strtoupper(str_replace('-', '_', $api_key_variable));

            $key = isset($this->_args[$api_key_variable]) ? $this->_args[$api_key_variable] : $this->input->server($key_name);

            $this->db->where('key', $key);
            $user = $this->db->get($this->config->item('rest_keys_table'));

            $user = new User($user->row()->user_id);

            $this->_user = (object) $user->getData();

        }

        return $this->_user;
    }

    // ------------------------------------------------------------------------

    protected function early_checks()
    {
        if ($this->uri->segment(2) == 'modules' || $this->uri->segment(2) == 'auth') {
            $this->config->set_item('rest_enable_keys', FALSE);
        }

        $this->_load_module_packages();

        // Disable keys for login
        if ($this->uri->segment(2) == 'auth') {
            // Only get valid logins when a request is for authorization.
            $cache = Cache::get_instance();
            $id = 'restlogins';
            $logins = $cache::get($id);

            if (!$logins) {
                $this->load->model('users_model');
                $logins = $this->users_model->get_login_array();
                $cache::save($id, $logins);
            }

            $this->config->set_item('rest_valid_logins', $logins);
        }
    }

    // ------------------------------------------------------------------------

    public function save(Base $obj)
    {
        if ($obj->isNew()) {
            $status = 201;
        } else {
            $status = 200;
        }

        $id = $obj->save();

        if (!$id) {
            $this->response(array('message' => $obj->get_validation_errors()), 403);
        } else {
            $this->response($obj->refresh()->getData(), $status);
        }        
    }

    // ------------------------------------------------------------------------
    
    public function delete(Base $obj)
    {
        $this->response($obj->delete());
    }

    // --------------------------------------------------------------------    
    
    /**
     * Loads the dir of all modules that we have.
     */      
    protected function _load_module_packages()
    {
        $modules = get_modules();
        
        foreach ($modules as $module)
        {
            if ($module['enabled']) {
                $this->load->add_package_path(MODPATH . $module['dir']);
            }
        }
    }     
}
/* End of file */
/* Location: application/core */