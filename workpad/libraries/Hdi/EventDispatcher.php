<?php

class Hdi_EventDispatcher
{
	private static $_observers = null;

	private function __construct() {}

	/**
	 * Dispatches the event and calls the observers
	 * @param  string $event  Trigger name
	 * @param  array $params Any parameter to be passed to the observer [OPTIONAL]
	 * @return [type]         [description]
	 */
	static function dispatch_event($event, $params = array())
	{
		if (is_null(self::$_observers)) {
			self::_load_observers();
		}

		if (array_key_exists($event, self::$_observers)) {
			foreach (self::$_observers[$event] as $observer) {
				$_o = new $observer['class']();

				foreach ($observer['methods'] as $method) {
					$_o->$method($params);
				}
			}
		}
	}

	private static function _load_observers()
	{
		$ci =& get_instance();
		$ci->load->config('modules');

		$modules = $ci->config->item('modules');
		if (isset($modules) && count($modules) > 0)
		{
		    foreach ($modules as $module)
		    {
				$config_file = MODPATH . $module . '/config/observers.php';
				if (file_exists($config_file)) {
					require_once($config_file);
				}
		    }
		}

		self::$_observers = $config['observers'];
	}
}