<?php

// --------------------------------------------------------------------

function get_approver(Employee $employee, $module_code = '')
{
	if ($module_code == '') {
		return new User($employee->employee_id);
	}

	$model = new DummyModel('admin_approvers', 'id');

	$approvers = $model->search(array(
		array('field' => 'employee_id', 'value' => $employee->employee_id),
		array('field' => 'module_code', 'value' => $module_code)
	));

	if ($approvers->num_rows() == 0) {
		$approver = $employee->manager_id;		
	} else {
		$approver = $approvers->row()->approver_id;
	}

	return new User($approver);
}

// --------------------------------------------------------------------

/**
 * Returns employee_id's of user's approvals
 * 
 * @param  User 	$user    User object
 * @param  string   $module_code
 * @return array
 */
function get_employees_for_approval(User $user, $module_code)
{
	$approvals = array();

	$o_emp = new Employee();
	$employee_model = $o_emp->getModel();

	$user_managed_employees = $employee_model->search('manager_id', $user->user_id);

	if ($user_managed_employees->num_rows() > 0) {
		foreach ($user_managed_employees->result() as $employee) {
			$approvals[] = $employee->employee_id;
		}
	}

	$ap_model = new DummyModel('admin_approvers', 'id');

	$approval_table_employees = $ap_model->search(array(
		array('field' => 'approver_id', 'value' => $user->user_id),
		array('field' => 'approver', 'value' => TRUE),
		array('field' => 'module_code', 'value' => $module_code)
		)
	);

	if ($approval_table_employees->num_rows() > 0) {
		foreach ($approval_table_employees->result() as $employee) {
			$approvals[] = $employee->employee_id;
		}
	}

	return $approvals;
}