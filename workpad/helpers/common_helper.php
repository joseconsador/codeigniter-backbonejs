<?php

// --------------------------------------------------------------------

if (!function_exists('create_dropdown')) {
    function create_dropdown($model, $field) {
        $ci =& get_instance();
        $ci->load->model($model, 'dropdown_' . $model);
        $records = $ci->{'dropdown_' . $model}->fetch_all();
        
        $field = explode(',', $field);

        $values = array('' => 'Select...');
        foreach ($records->result_array() as $record) {
            $value = array();
            foreach ($field as $f) {
                 $value[] = $record[$f];
            }

            $values[$record[$ci->{'dropdown_' . $model}->get_primary_key()]] = implode(' ', $value);
        }
        
        return $values;
    }
}

// --------------------------------------------------------------------

/**
 * Add a js file to the footer part.
 * 
 * @param String $file File OR directory relative to js path
 */
function add_js($file) {
    $ci =& get_instance();    
    $ci->load->helper('file');
    
    if (is_dir($ci->config->item('js_dir') . $file)) {
        $files = get_filenames($ci->config->item('js_dir') . $file);
        $_file = array_map(
            function ($f, $dir) {
                return $dir . '/' . $f;
            },
            $files,
            array_fill(1, count($files), $file)
        );

        $file = $_file;        
    }

    $js = $ci->config->item('js');

    if (!$js) {
        $js = array();    
    }    

    if (!is_array($file)) {
        $file = array($file);
    }

    $js = array_unique(array_merge($js, $file));

    $ci->config->set_item('js', $js);
}

// --------------------------------------------------------------------

function load_js($js = null) {
    $ci =& get_instance();

    if (is_null($js)) {
        $js = $ci->config->item('js');
    }

    foreach ($js as $j) {        
        echo '<script type="text/javascript" src="' . js_dir($j) . '"></script>' . "\n";        
    }

    return;
}

// --------------------------------------------------------------------

function add_css($file) {
    $ci =& get_instance();  

    $css = $ci->config->item('css');

    if (!isset($css)) {
        $css = array($file);
    } else {
        $css[] = $file;
    }

    $ci->config->set_item('css', $css);
}

// --------------------------------------------------------------------

function remove_css($file) {
    $ci =& get_instance();  

    $css = $ci->config->item('css');

    if (isset($css) && in_array($file, $css)) {        
        unset($css[array_search($file, $css)]);
    }

    $ci->config->set_item('css', $css);
}

// --------------------------------------------------------------------

function load_css() {
    $ci =& get_instance();

    $css = $ci->config->item('css');    

    if ($css) {
        foreach ($css as $j) {            
            echo '<link type="text/css" rel="stylesheet" href="' . css_dir($j) . '" />' . "\n";
        }
    }
}

/**
* Checks if the hash on the session is valid to increase security.
* This function only checks for the client side login and not API login
*
*/
function is_logged_in() {
    $ci =& get_instance();

    return ($ci->session->userdata('logged_in') && $ci->session->userdata('api_key') != '');
}

/**
 * Return blank if string is empty
 * @param  string $string String to be echoed
 * @return string
 */
function _p($obj, $string) {
    if (!is_array($obj)) {
        $obj = (array) $obj;
    }

    if (!isset($obj[$string])) {
        return '';
    }
    $string = $obj[$string];

    if (trim($string) == '' || !isset($string)) {
        return '';
    }

    return htmlspecialchars($string);
}

// --------------------------------------------------------------------

function _d($date, $format = 'Y-m-d H:i:s') {
    if (is_null($date) || $date == '0000-00-00' || $date == '0000-00-00 00:00:00' || trim($date) == '') {
        return '';
    } else {
        return date($format, strtotime($date));
    }
}

// --------------------------------------------------------------------

if (!function_exists('is_allowed')) {    
    /**
     * Checks the API is resource is accessible
     * @param  string  $resource
     * @return boolean
     */
    function is_allowed($resource) {
        $ci =& get_instance();

        return $ci->rest->get('auth/access', array('resource' => $resource), 'json', FALSE);        
    }
}

// --------------------------------------------------------------------

/**
*  Get Age
*  @var string YYY-MM-DD // MYSQL Format
*  @return int age
**/
function get_age($mysql_date) {    
    list($y,$m,$d) = explode("-",$mysql_date);
    $age = date('Y')-$y;
    date('md')<$m.$d ? $age--:null;
    return $age;
}

function show_access_denied() {
    show_error('Access to this resource is denied.', 403);
}

// --------------------------------------------------------------------

if ( ! function_exists('secure_base_url'))
{
    function secure_base_url($uri = '')
    {
        $CI =& get_instance();
        return $CI->config->item('secure_base_url') . ltrim($uri,'/');
    }
}

// --------------------------------------------------------------------

function force_ssl() {

    if (empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'off'
          || $_SERVER['SERVER_PORT'] != 443) {
        redirect(secure_base_url(uri_string()));
    }
}

function get_modules() 
{
    $ci =& get_instance();    

    // This code is here instead of the Modules class because if so the
    // Modules class would not still not have been found by the autoloader    
    $modulesxml = simplexml_load_file(MODULES_XML_PATH);

    $modules = array('' => array(
            'module_id' => 0,
            'uuid' => 'default',
            'name' => 'default',
            'enabled' => '1',
            'dir' => ''
        )
    );

    foreach ($modulesxml as $module) {
        if ($module->enabled == '1') {
            $modules[(string) $module['uuid']] = (array) $module;
        }
    }

    return $modules;
}

// --------------------------------------------------------------------

/**
 * Add one simplexml to another
 *
 * @param object $simplexml_to
 * @param object $simplexml_from
 * @author Boris Korobkov
 * @link http://www.ajaxforum.ru/
 */
function append_simplexml(&$simplexml_to, &$simplexml_from)
{
    foreach ($simplexml_from->children() as $simplexml_child)
    {
        $simplexml_temp = $simplexml_to->addChild($simplexml_child->getName(), (string) $simplexml_child);
        foreach ($simplexml_child->attributes() as $attr_key => $attr_value)
        {
            $simplexml_temp->addAttribute($attr_key, $attr_value);
        }
       
        append_simplexml($simplexml_temp, $simplexml_child);
    }
} 

// --------------------------------------------------------------------

if (!function_exists('__autoload')) {    
    function __autoload($class) {                
        $path = APPPATH . 'libraries/' . $class . '.php';

        $modules = get_modules();

        if (file_exists($path)) {
            include_once ($path);
            if (!class_exists($class, false) && !interface_exists($class)) {
                trigger_error("Unable to load class: $class", E_USER_WARNING);
            }
        } else {
            // Try to break down directory.
            foreach ($modules as $id => $module) {
                if ($module['dir'] != '') {
                    $module['dir'] = 'modules/' . $module['dir']. '/';
                }

                $path = APPPATH . $module['dir'] . 'libraries/' . str_replace('_', '/', $class) . '.php';

                if (file_exists($path)) {
                    include_once($path);            
                    if (!class_exists($class, false) && !interface_exists($class)) {
                        trigger_error("Unable to load class: $class", E_USER_WARNING);
                    }
                }                             
            }
        }
    }
}