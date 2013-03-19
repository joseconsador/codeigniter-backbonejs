<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Allows to use caching drivers that are available on the server.
 *
 *  @author     Jose Mari Consador
 *  @version    0.1
 *  @date       2012-10-08
 */

class Cache
{	
	private static $instance;	
	private static $adapter;

	// --------------------------------------------------------------------

	private function __construct()
	{
		$ci =& get_instance();
		$ci->load->driver('cache');		

		// Load cache drivers.
		if ($ci->cache->apc->is_supported()) {
			self::$adapter = 'apc';
		} else if ($ci->cache->memcached->is_supported()) {
			self::$adapter = 'memcached';
		} else {		
		}
			self::$adapter = 'file';
	}

	// --------------------------------------------------------------------

	public static function get_instance()
	{
		if (!self::$instance)
		{
			self::$instance = new Cache();
		}

		return self::$instance;
	}

	// --------------------------------------------------------------------

	/**
	 * Get item from cache store.
	 * @param  string $id 
	 * @return mixed
	 */
	public static function get($id)
	{
		$ci =& get_instance();
		return $ci->cache->{self::$adapter}->get(md5($id));
	}

	// --------------------------------------------------------------------

	/**
	 * Save item to cache store.
	 * 
	 * @param  string  $id   unique identifier of the item in the cache
	 * @param  mixed   $data data to be cached
	 * @param  integer $ttl  time in seconds to store in cache
	 * @return [type]        [description]
	 */
	public static function save($id, $data, $ttl = 180)
	{
		$ci =& get_instance();

		return $ci->cache->{self::$adapter}->save(md5($id), $data, $ttl);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete from Cache
	 *
	 * @param 	mixed		unique identifier of the item in the cache
	 * @return 	boolean		true on success/false on failure
	 */
	public static function delete($id)
	{
		$ci =& get_instance();
				
		return @$ci->cache->{self::$adapter}->delete(md5($id));		
	}

	// ------------------------------------------------------------------------

	/**
	 * Flush
	 *	 
	 * @return 	boolean		true on success/false on failure
	 */
	public static function clean()
	{
		$ci =& get_instance();
				
		return @$ci->cache->{self::$adapter}->clean();		
	}
}