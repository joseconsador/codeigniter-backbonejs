<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
    // --------------------------------------------------------------------
    
    if (!function_exists('image_dir'))
    {
        function image_dir($dir = null)
        {
            $ci =& get_instance();
            
            $config = $ci->config->item('image_dir');

            if (!is_null($dir))
            {
                $config .= $dir;
            }

            return get_asset_url($config);
        }
    }

    // --------------------------------------------------------------------

    if (!function_exists('css_dir'))
    {
        function css_dir($dir = null)
        {
            $ci =& get_instance();

            $config = $ci->config->item('css_dir');

            if (!is_null($dir))
            {
                $config .= $dir;
            }

            return get_asset_url($config);
        }
    }

    // --------------------------------------------------------------------

    if (!function_exists('js_dir'))
    {
        function js_dir($dir = null)
        {
            $ci =& get_instance();

            $config = $ci->config->item('js_dir');

            if (!is_null($dir))
            {
                $config .= $dir;
            }

            return get_asset_url($config);
        }
    }

    function get_asset_url($asset)
    {
        return _get_current_base() . $asset;
    }

    function _get_current_base()
    {
        $ci =& get_instance();

        if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
            || $_SERVER['SERVER_PORT'] == 443) {

            return $ci->config->item('secure_base_url');
        }

        return base_url();
    }
    
/* End of file dir_helper.php */
/* Location: ./application/helpers/dir_helper.php */ 