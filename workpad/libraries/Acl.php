<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Acl
{
	// Set the instance variable
	var $CI;

	function __construct()
	{
		// Get the instance
		$this->CI =& get_instance();

		$cache = Cache::get_instance();
		// Set the include path and require the needed files
		$this->acl = $cache::get('acl');

		if (!$this->acl) {
	 		$this->acl = new Zend_Acl();	 		

			// Set the default ACL
			$this->acl->addRole(new Zend_Acl_Role('default'));

			$query = $this->CI->db->get('admin_resource');		
			foreach($query->result() AS $row){
				$this->acl->add(new Zend_Acl_Resource($row->resource_code));
				if($row->default_value == 'true'){
					$this->acl->allow('default', $row->resource_code);
				}
			}
			// Get the ACL for the roles
			$this->CI->db->order_by("role_order", "ASC");
			$query = $this->CI->db->get('admin_role');
			foreach($query->result() AS $row){
				$role = (string)$row->role_id;
				$this->acl->addRole(new Zend_Acl_Role($role), 'default');
				$this->CI->db->from('admin_permission');
				$this->CI->db->join('admin_resource', 'admin_resource.resource_id = admin_permission.resource_id');
				$this->CI->db->where('type', 'role');
				$this->CI->db->where('type_id', $row->role_id);
				$subquery = $this->CI->db->get();
				foreach($subquery->result() AS $subrow){					
					if($subrow->action == "allow"){
						$this->acl->allow($role, $subrow->resource_code);
					} else {
						$this->acl->deny($role, $subrow->resource_code);
					}				
				}
				// Get the ACL for the users
				$this->CI->db->from('user_ref');			
				$this->CI->db->join('user', 'user.user_id = user_ref.user_id');
				$this->CI->db->where('role_id', $row->role_id);
				$userquery = $this->CI->db->get();

				foreach($userquery->result() AS $userrow){
					$this->acl->addRole(new Zend_Acl_Role($userrow->login), $role);
					$this->CI->db->from('admin_permission');
					$this->CI->db->join('admin_resource', 'admin_resource.resource_id = admin_permission.resource_id');
					$this->CI->db->where('type', 'user');
					$this->CI->db->where('type_id', $userrow->user_id);
					$usersubquery = $this->CI->db->get();
					foreach($usersubquery->result() AS $usersubrow){
						if($usersubrow->action == "allow"){
							$this->acl->allow($userrow->login, $usersubrow->resource_code);
						} else {
							$this->acl->deny($userrow->login, $usersubrow->resource_code);
						}
					}
				}
			}			

			$cache::save('acl', $this->acl, 7200);
		}
	}

	// Function to check if the current or a preset role has access to a resource
	function check_acl($resource, $role = '')
	{
		if (!$this->acl->has($resource))
		{
			return TRUE;
		}

		if (empty($role)) {
			// Try for login
			if (!$this->check_acl($resource, $this->CI->get_user()->role_id)) {
				return $this->check_acl($resource, $this->CI->get_user()->login);
			} else {
				return TRUE;
			}
		}

		// Check if user has all_access
		if ($this->acl->isAllowed($role, 'ALL_ACCESS')) 
		{
			return TRUE;
		}

		return $this->acl->isAllowed($role, $resource);
	}
}