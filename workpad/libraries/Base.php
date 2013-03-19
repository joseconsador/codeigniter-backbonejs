<?php

abstract class Base 
{
	protected $_cache;
	// Contains data mapped from tables to child classes
	protected $_data = array();
	protected $_id;

	protected $_original_values = array();

	protected $_validators = array();
	protected $_validation_errors = array();

	protected $_created_by = null;

	// --------------------------------------------------------------------
	
	/**
	 * Load an entity, if first parameter is int ,takes from the model.
	 *
	 * @param $id mixed
	 */
	public function __construct($id = null)
	{
		if (!is_null($id)) {
			$cache = Cache::get_instance();
			if (!is_array($id) && !is_object($id)) {
				$_o = $cache->get('_o' . get_class($this) . $id);

				if ($_o) {
					$this->loadArray($_o->getData());
				} else {
					$this->load($id);
					$cache->save('_o' . get_class($this) . $id, $this);
				}
			} else {
				$this->loadArray($id);
			}
		}		
	}

	// --------------------------------------------------------------------
	
	/**
	 * Save data to the model.
	 *
	 * @return mixed
	 */
	public function save()
	{
		if ($this->validates() == FALSE) {			
			return FALSE;			
		}

		$model = $this->getModel();
		$this->{$model->get_primary_key(FALSE)} = $model->do_save($this->getData());

		$cache = Cache::get_instance();
		
		$_o = $cache->delete('_o' . get_class($this) . $this->getId());

		$this->load($this->getId());

		return $this->getId();
	}

	// --------------------------------------------------------------------
	
	/**
	 * Delete the entity.
	 *
	 * @return boolean
	 */
	public function delete()
	{
		return $this->getModel()->delete($this->getId());
	}


	public function getId()
	{
		$model = $this->getModel();

		if (isset($this->_data[$model->get_primary_key(FALSE)])) {
			return $this->_data[$model->get_primary_key(FALSE)];
		} else {
			return null;
		}
	}

	// --------------------------------------------------------------------
	
	/**
	 * Load properties via database.
	 *
	 * @param int $key
	 * @param string $field
	 */
	public function load($key, $field = '')
	{
		$data = $this->getModel()->get($key, $field);

		$this->loadArray($data);

		return $this;
	}

	// --------------------------------------------------------------------
	
	/**
	 * sync to database
	 *	 
	 * @return  $this
	 */
	public function refresh()
	{
		return $this->load($this->getId());
	}

	// --------------------------------------------------------------------
	
	/**
	 * Load properties from array.
	 * Store original values in a different array for comparison.
	 * 
	 * @param array $data
	 */
	public function loadArray($data)
	{
		if ($data && (is_array($data) || is_object($data))) {
			$this->persist($data);
			$this->_original_values = $data;
		}

		return $this;
	}

	// --------------------------------------------------------------------
	
	/**
	 * PHP magic method to populate our $_data array.
	 * 
	 * @param string $name 
	 * @param mixed $value 
	 */
	public function __set($name, $value)
	{
		$this->_data[$name] = $value;
	}

	// --------------------------------------------------------------------
	 
	public function __get($name)
	{
		return @$this->_data[$name];
	}

	// --------------------------------------------------------------------
	
	public function hasData()
	{
		return count($this->getData()) > 0;
	}

	// --------------------------------------------------------------------
	
	public function getData()
	{
		return $this->_data;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Checks whether a property has been updated 
	 * 
	 * @param  string  $prop 
	 * @return boolean
	 */
	public function hasChanged($prop)
	{
		if ($this->isNew()) {
			return FALSE;
		}

		return $this->get_original_value($prop) != $this->_data[$prop];
	}

	// --------------------------------------------------------------------

	public function get_original_value($prop)
	{
		return _p($this->_original_values, $prop);
	}

	// --------------------------------------------------------------------
	
	public function isNew()
	{
		$id = $this->getId();
		return (is_null($id) || $id <= 0);
	}

	// --------------------------------------------------------------------

	/**
	 * Return validation errors after saving.
	 * @return [type] [description]
	 */
	public function get_validation_errors()
	{
		return $this->_validation_errors;
	}

	// --------------------------------------------------------------------

	public function get_created_by()
	{
		if (is_null($this->_created_by)) {
			$this->_created_by = new User($this->created_by);
		}

		return $this->_created_by;
	}

	// --------------------------------------------------------------------
	// 
	// Declare abstract to force implementing classes to have this method
	// 
	// --------------------------------------------------------------------
	abstract function getModel(); 

	/**
	 * Sets validators
	 * @return [type] [description]
	 */
	protected function set_validators() {}

	// --------------------------------------------------------------------
	
	/**
	 * Checks if the entity conforms to business rules. Putting this method here instead of the 
	 * model, want to keep the model as database layer as much as possible hopefully.
	 * 
	 * @return boolean
	 */
	protected function validates()
	{
		$this->set_validators();

		foreach ($this->_validators as $element => $rules)
		{
			// Use Zend_Validate because CI's validation library only works form form inputs.
			$validator = new Zend_Validate();
			foreach ($rules as $i => $rule) {
				// Chaining validators.
				if ($rule instanceof Zend_Validate_Abstract) {
					$validator->addValidator($rule);
				} else if (!is_array($rule)) {
					$validator->addValidator(new $rule());
				} else {
					// Set options if any (passed as array)
					$validator->addValidator(new $i($rule));
				}
			}

			if ($validator->isValid($this->{$element}) == FALSE) {
				$this->_validation_errors[$element] = $validator->getMessages();
			}
		}

		return count($this->_validation_errors) == 0;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Matches params to the object elements.
	 * 
	 * @param  array $params
	 * @return $this
	 */
	public function persist($params)
	{
		foreach ($params as $key => $value) {			
			$this->_data[$key] = $value;			
		}

		return $this;
	}
}