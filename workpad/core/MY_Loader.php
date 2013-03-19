<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Modify some methods of CI_Loader to suit our application.
 * Enable separation of client packages.
 * 
 * @author jconsador
 */
class MY_Loader extends CI_Loader {

	/**
	 * Constructor
	 *
	 * Sets the path to the view files and gets the initial output buffering level
	 */
	public function __construct()
	{
        if(!defined('SPARKPATH'))
        {
            define('SPARKPATH', 'sparks/');
        }

        $this->_is_lt_210 = (is_callable(array('CI_Loader', 'ci_autoloader'))
                               || is_callable(array('CI_Loader', '_ci_autoloader')));        

		$this->_ci_ob_level  = ob_get_level();
		$this->_ci_library_paths = array(APPPATH, BASEPATH);
		$this->_ci_helper_paths = array(APPPATH, BASEPATH);
		$this->_ci_model_paths = array(APPPATH);
		$this->_ci_view_paths = array(APPPATH.'views/'	=> TRUE);
		
		log_message('debug', "Loader Class Initialized");
	}	

	// --------------------------------------------------------------------

	/**
	 * Class Loader
	 *
	 * This function lets users load and instantiate classes.
	 * It is designed to be called from a user's app controllers.
	 *
	 * @access	public
	 * @param	string	the name of the class
	 * @param	mixed	the optional parameters
	 * @param	string	an optional object name
	 * @return	void
	 */
	function library($library = '', $params = NULL, $object_name = NULL)
	{
		if (is_array($library))
		{
			foreach($library as $read)
			{
				$this->library($read);
			}

			return;
		}

		if ($library == '' OR isset($this->_base_classes[$library]))
		{
			return FALSE;
		}

		if ( ! is_null($params) && ! is_array($params))
		{
			$params = NULL;
		}

		if (is_array($library))
		{
			foreach ($library as $class)
			{
				$this->_ci_load_class($class, $params, $object_name);
			}
		}
		else
		{
			$this->_ci_load_class($library, $params, $object_name);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Load Helper
	 *
	 * This function loads the specified helper file.
	 *
	 * @access	public
	 * @param	mixed
	 * @return	void
	 */
	function helper($helpers = array())
	{
		foreach ($this->_ci_prep_filename($helpers, '_helper') as $helper)
		{
			if (isset($this->_ci_helpers[$helper]))
			{
				continue;
			}

			$ext_helper = APPPATH.'helpers/'.config_item('subclass_prefix').$helper.EXT;

			// Is this a helper extension request?
			if (file_exists($ext_helper))
			{
				$base_helper = BASEPATH.'helpers/'.$helper.EXT;

				if ( ! file_exists($base_helper))
				{
					show_error('Unable to load the requested file: helpers/'.$helper.EXT);
				}

				include_once($ext_helper);
				include_once($base_helper);

				$this->_ci_helpers[$helper] = TRUE;
				log_message('debug', 'Helper loaded: '.$helper);
				continue;
			}

			// Try to load the helper
			foreach ($this->_ci_helper_paths as $path)
			{
				if (file_exists($path.'helpers/'.$helper.EXT))
				{
					include_once($path.'helpers/'.$helper.EXT);

					$this->_ci_helpers[$helper] = TRUE;
					log_message('debug', 'Helper loaded: '.$helper);
					break;
				}
			}

			// unable to load the helper
			if ( ! isset($this->_ci_helpers[$helper]))
			{
				show_error('Unable to load the requested file: helpers/'.$helper.EXT);
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Get Package Paths
	 *
	 * Return a list of all package paths, by default it will ignore BASEPATH.
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	function get_package_paths($include_base = FALSE)
	{
		return $include_base === TRUE ? $this->_ci_library_paths : $this->_ci_model_paths;
	}

	// --------------------------------------------------------------------

	/**
	 * Remove Package Path
	 *
	 * Remove a path from the library, model, and helper path arrays if it exists
	 * If no path is provided, the most recently added path is removed.
	 *
	 * @access	public
	 * @param	type
	 * @return	type
	 */
	function remove_package_path($path = '', $remove_config_path = TRUE)
	{
		$config =& $this->_ci_get_component('config');

		if ($path == '')
		{
			$void = array_shift($this->_ci_library_paths);
			$void = array_shift($this->_ci_model_paths);
			$void = array_shift($this->_ci_helper_paths);
			$void = array_shift($config->_config_paths);
		}
		else
		{
			$path = rtrim($path, '/').'/';

			foreach (array('_ci_library_paths', '_ci_model_paths', '_ci_helper_paths') as $var)
			{
				if (($key = array_search($path, $this->{$var})) !== FALSE)
				{
					unset($this->{$var}[$key]);
				}
			}

			if (($key = array_search($path, $config->_config_paths)) !== FALSE)
			{
				unset($config->_config_paths[$key]);
			}
		}

		// make sure the application default paths are still in the array
		$this->_ci_library_paths = array_unique(array_merge($this->_ci_library_paths, array(APPPATH, BASEPATH)));
		$this->_ci_helper_paths = array_unique(array_merge($this->_ci_helper_paths, array(APPPATH, BASEPATH)));
		$this->_ci_model_paths = array_unique(array_merge($this->_ci_model_paths, array(APPPATH)));
		$config->_config_paths = array_unique(array_merge($config->_config_paths, array(APPPATH)));
	}

	// --------------------------------------------------------------------

	/**
	 * Loader
	 *
	 * This function is used to load views and files.
	 * Variables are prefixed with _ci_ to avoid symbol collision with
	 * variables made available to view files
	 *
	 * @access	private
	 * @param	array
	 * @return	void
	 */
	function _ci_load($_ci_data, $cache = TRUE)
	{	
		// Set the default data variables
		foreach (array('_ci_view', '_ci_vars', '_ci_path', '_ci_return') as $_ci_val)
		{
			$$_ci_val = ( ! isset($_ci_data[$_ci_val])) ? FALSE : $_ci_data[$_ci_val];
		}

		$file_exists = FALSE;

		// Set the path to the requested file
		if ($_ci_path != '')
		{
			$_ci_x = explode('/', $_ci_path);
			$_ci_file = end($_ci_x);
		}
		else
		{
			$_ci_ext = pathinfo($_ci_view, PATHINFO_EXTENSION);
			$_ci_file = ($_ci_ext == '') ? $_ci_view.'.php' : $_ci_view;

			foreach ($this->_ci_view_paths as $view_file => $cascade)
			{
				if (file_exists($view_file.$_ci_file))
				{
					$_ci_path = $view_file.$_ci_file;					
					$file_exists = TRUE;
					break;
				}

				if ( ! $cascade)
				{
					break;
				}
			}
		}

		if ( ! $file_exists && ! file_exists($_ci_path))
		{
			show_error('Unable to load the requested file: '.$_ci_file);
		}

		// This allows anything loaded using $this->load (views, files, etc.)
		// to become accessible from within the Controller and Model functions.

		$_ci_CI =& get_instance();
		foreach (get_object_vars($_ci_CI) as $_ci_key => $_ci_var)
		{
			if ( ! isset($this->$_ci_key))
			{
				$this->$_ci_key =& $_ci_CI->$_ci_key;
			}
		}

		/*
		 * Extract and cache variables
		 *
		 * You can either set variables using the dedicated $this->load_vars()
		 * function or via the second parameter of this function. We'll merge
		 * the two types and cache them so that views that are embedded within
		 * other views can have access to these variables.
		 */
		$_vars = $this->_ci_cached_vars;
		if (is_array($_ci_vars))
		{			
			if ($cache) {
				$this->_ci_cached_vars = array_merge($this->_ci_cached_vars, $_ci_vars);
				$_vars = $this->_ci_cached_vars;
			} else {
				// Vars for this view instance only.
				$_temp_vars = array_merge($this->_ci_cached_vars, $_ci_vars);
				$_vars = $_temp_vars;
			}
		}
		extract($_vars);

		/*
		 * Buffer the output
		 *
		 * We buffer the output for two reasons:
		 * 1. Speed. You get a significant speed boost.
		 * 2. So that the final rendered template can be
		 * post-processed by the output class.  Why do we
		 * need post processing?  For one thing, in order to
		 * show the elapsed page load time.  Unless we
		 * can intercept the content right before it's sent to
		 * the browser and then stop the timer it won't be accurate.
		 */
		ob_start();

		// If the PHP installation does not support short tags we'll
		// do a little string replacement, changing the short tags
		// to standard PHP echo statements.

		if ((bool) @ini_get('short_open_tag') === FALSE AND config_item('rewrite_short_tags') == TRUE)
		{
			echo eval('?>'.preg_replace("/;*\s*\?>/", "; ?>", str_replace('<?=', '<?php echo ', file_get_contents($_ci_path))));
		}
		else
		{
			include($_ci_path); // include() vs include_once() allows for multiple views with the same name
		}

		log_message('debug', 'File loaded: '.$_ci_path);

		// Return the file data if requested
		if ($_ci_return === TRUE)
		{
			$buffer = ob_get_contents();
			@ob_end_clean();
			return $buffer;
		}

		/*
		 * Flush the buffer... or buff the flusher?
		 *
		 * In order to permit views to be nested within
		 * other views, we need to flush the content back out whenever
		 * we are beyond the first level of output buffering so that
		 * it can be seen and included properly by the first included
		 * template and any subsequent ones. Oy!
		 *
		 */
		if (ob_get_level() > $this->_ci_ob_level + 1)
		{
			ob_end_flush();
		}
		else
		{
			$_ci_CI->output->append_output(ob_get_contents());
			@ob_end_clean();
		}
	}

	
	// --------------------------------------------------------------------

	/**
	 * Get value of a cached var.
	 * @param  string $key 
	 * @return mixed
	 */
	public function get_var($key) {
		if (!in_array($key, $this->_ci_cached_vars)) {
			show_error('Var not found.');
		}
		
		return $this->_ci_cached_vars[$key];
	}

	// --------------------------------------------------------------------

	/**
	 * Return all cached vars.
	 * @return array
	 */
	public function get_vars() {
		return $this->_ci_cached_vars;
	}

	// --------------------------------------------------------------------

	/**
	 * Replace cached vars with $vars.
	 * @param  array $vars 
	 * @return void
	 */
	public function reload_vars($vars = array()) {
		$this->_ci_cached_vars = $vars;
	}	


    /**
     * Keep track of which sparks are loaded. This will come in handy for being
     *  speedy about loading files later.
     *
     * @var array
     */
    var $_ci_loaded_sparks = array();

    /**
     * Is this version less than CI 2.1.0? If so, accomodate
     * @bubbafoley's world-destroying change at: http://bit.ly/sIqR7H
     * @var bool
     */
    var $_is_lt_210 = false;

    /**
     * To accomodate CI 2.1.0, we override the initialize() method instead of
     *  the ci_autoloader() method. Once sparks is integrated into CI, we
     *  can avoid the awkward version-specific logic.
     * @return Loader
     */
    function initialize()
    {
        parent::initialize();

        if(!$this->_is_lt_210)
        {
            $this->ci_autoloader();
        }

        return $this;
    }

    /**
     * Load a spark by it's path within the sparks directory defined by
     *  SPARKPATH, such as 'markdown/1.0'
     * @param string $spark The spark path withint he sparks directory
     * @param <type> $autoload An optional array of items to autoload
     *  in the format of:
     *   array (
     *     'helper' => array('somehelper')
     *   )
     * @return <type>
     */
    function spark($spark, $autoload = array())
    {
        if(is_array($spark))
        {
            foreach($spark as $s)
            {
                $this->spark($s);
            }
        }

        $spark = ltrim($spark, '/');
        $spark = rtrim($spark, '/');

        $spark_path = SPARKPATH . $spark . '/';
        $parts      = explode('/', $spark);
        $spark_slug = strtolower($parts[0]);

        # If we've already loaded this spark, bail
        if(array_key_exists($spark_slug, $this->_ci_loaded_sparks))
        {
            return true;
        }

        # Check that it exists. CI Doesn't check package existence by itself
        if(!file_exists($spark_path))
        {
            show_error("Cannot find spark path at $spark_path");
        }

        if(count($parts) == 2)
        {
            $this->_ci_loaded_sparks[$spark_slug] = $spark;
        }

        $this->add_package_path($spark_path);

        foreach($autoload as $type => $read)
        {
            if($type == 'library')
                $this->library($read);
            elseif($type == 'model')
                $this->model($read);
            elseif($type == 'config')
                $this->config($read);
            elseif($type == 'helper')
                $this->helper($read);
            elseif($type == 'view')
                $this->view($read);
            else
                show_error ("Could not autoload object of type '$type' ($read) for spark $spark");
        }

        // Looks for a spark's specific autoloader
        $this->ci_autoloader($spark_path);

        return true;
    }

	/**
	 * Pre-CI 2.0.3 method for backward compatility.
	 *
	 * @param null $basepath
	 * @return void
	 */
	function _ci_autoloader($basepath = NULL)
	{
		$this->ci_autoloader($basepath);
	}

	/**
	 * Specific Autoloader (99% ripped from the parent)
	 *
	 * The config/autoload.php file contains an array that permits sub-systems,
	 * libraries, and helpers to be loaded automatically.
	 *
	 * @param array|null $basepath
	 * @return void
	 */
	function ci_autoloader($basepath = NULL)
	{
        if($basepath !== NULL)
        {
            $autoload_path = $basepath.'config/autoload'.EXT;
        }
        else
        {
            $autoload_path = APPPATH.'config/autoload'.EXT;
        }

        if(! file_exists($autoload_path))
        {
            return FALSE;
        }

		include($autoload_path);

		if ( ! isset($autoload))
		{
			return FALSE;
		}

        if($this->_is_lt_210 || $basepath !== NULL)
        {
            // Autoload packages
            if (isset($autoload['packages']))
            {
                foreach ($autoload['packages'] as $package_path)
                {
                    $this->add_package_path($package_path);
                }
            }
        }

        // Autoload sparks
		if (isset($autoload['sparks']))
		{
			foreach ($autoload['sparks'] as $spark)
			{
				$this->spark($spark);
			}
		}

        if($this->_is_lt_210 || $basepath !== NULL)
        {
            if (isset($autoload['config']))
            {
                // Load any custom config file
                if (count($autoload['config']) > 0)
                {
                    $CI =& get_instance();
                    foreach ($autoload['config'] as $key => $val)
                    {
                        $CI->config->load($val);
                    }
                }
            }

            // Autoload helpers and languages
            foreach (array('helper', 'language') as $type)
            {
                if (isset($autoload[$type]) AND count($autoload[$type]) > 0)
                {
                    $this->$type($autoload[$type]);
                }
            }

            // A little tweak to remain backward compatible
            // The $autoload['core'] item was deprecated
            if ( ! isset($autoload['libraries']) AND isset($autoload['core']))
            {
                $autoload['libraries'] = $autoload['core'];
            }

            // Load libraries
            if (isset($autoload['libraries']) AND count($autoload['libraries']) > 0)
            {
                // Load the database driver.
                if (in_array('database', $autoload['libraries']))
                {
                    $this->database();
                    $autoload['libraries'] = array_diff($autoload['libraries'], array('database'));
                }

                // Load all other libraries
                foreach ($autoload['libraries'] as $item)
                {
                    $this->library($item);
                }
            }

            // Autoload models
            if (isset($autoload['model']))
            {
                $this->model($autoload['model']);
            }
        }
	}	
}

/* End of file Loader.php */
/* Location: ./system/core/Loader.php */