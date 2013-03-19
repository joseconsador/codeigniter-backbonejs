<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dev extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->_load_module_packages();

        // Load asset paths config.
        $this->load->config('dir');

        // Load directory helper.
        $this->load->helper('dir');

        add_js('libs/bootstrap/bootstrap.min.js');
        add_js('libs/bootstrapx-clickover.js');

        add_js('libs/jquery-ui-1.8.16.custom.min.js');
        add_js('libs/jquery.validate.min.js');        

        add_js('libs/date.js');    

        add_js('libs/underscore.js');
        add_js('libs/backbone-min.js');
        
        add_js('libs/enhance.min.js');
        add_js('libs/fileinput.jquery.js');
        add_js('app.js');        		
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{$this->output->enable_profiler(TRUE);
		$this->load->view('blank');
	}

	public function test()
	{
		var_dump($this->uri->uri_to_assoc());
	}

	public function populate_all()
	{
		$this->cleanup();

		$this->populate_users();
		$this->populate_timerecord();
	}

	public function cleanup()
	{
		$this->db->where('employee_id >', 3);
		$this->db->delete('employee');

		$this->db->where('user_id >', 3);
		$this->db->delete('user');

		$this->db->where('id >', 3);
		$this->db->delete('user_about');

		$this->db->where('id >', 3);
		$this->db->delete('user_ref');

		$this->db->where('person_id >', 3);
		$this->db->delete('person');

		$this->db->where('id >', 3);
		$this->db->delete('person_details');		
	}

	public function populate_users()
	{

		$names = array(
		'Allison',
		'Arthur',
		'Ana',
		'Alex',
		'Arlene',
		'Alberto',
		'Barry',
		'Bertha',
		'Bill',
		'Bonnie',
		'Bret',
		'Beryl',
		'Chantal',
		'Cristobal',
		'Claudette',
		'Charley',
		'Cindy',
		'Chris',
		'Dean',
		'Dolly',
		'Danny',
		'Danielle',
		'Dennis',
		'Debby',
		'Erin',
		'Edouard',
		'Erika',
		'Earl',
		'Emily',
		'Ernesto',
		'Felix',
		'Fay',
		'Fabian',
		'Frances',
		'Franklin',
		'Florence',
		'Gabielle',
		'Gustav',
		'Grace',
		'Gaston',
		'Gert',
		'Gordon',
		'Humberto',
		'Hanna',
		'Henri',
		'Hermine',
		'Harvey',
		'Helene',
		'Iris',
		'Isidore',
		'Isabel',
		'Ivan',
		'Irene',
		'Isaac',
		'Jerry',
		'Josephine',
		'Juan',
		'Jeanne',
		'Jose',
		'Joyce',
		'Karen',
		'Kyle',
		'Kate',
		'Karl',
		'Katrina',
		'Kirk',
		'Lorenzo',
		'Lili',
		'Larry',
		'Lisa',
		'Lee',
		'Leslie',
		'Michelle',
		'Marco',
		'Mindy',
		'Maria',
		'Michael',
		'Noel',
		'Nana',
		'Nicholas',
		'Nicole',
		'Nate',
		'Nadine',
		'Olga',
		'Omar',
		'Odette',
		'Otto',
		'Ophelia',
		'Oscar',
		'Pablo',
		'Paloma',
		'Peter',
		'Paula',
		'Philippe',
		'Patty',
		'Rebekah',
		'Rene',
		'Rose',
		'Richard',
		'Rita',
		'Rafael',
		'Sebastien',
		'Sally',
		'Sam',
		'Shary',
		'Stan',
		'Sandy',
		'Tanya',
		'Teddy',
		'Teresa',
		'Tomas',
		'Tammy',
		'Tony',
		'Van',
		'Vicky',
		'Victor',
		'Virginie',
		'Vince',
		'Valerie',
		'Wendy',
		'Wilfred',
		'Wanda',
		'Walter',
		'Wilma',
		'William',
		'Kumiko',
		'Aki',
		'Miharu',
		'Chiaki',
		'Michiyo',
		'Itoe',
		'Nanaho',
		'Reina',
		'Emi',
		'Yumi',
		'Ayumi',
		'Kaori',
		'Sayuri',
		'Rie',
		'Miyuki',
		'Hitomi',
		'Naoko',
		'Miwa',
		'Etsuko',
		'Akane',
		'Kazuko',
		'Miyako',
		'Youko',
		'Sachiko',
		'Mieko',
		'Toshie',
		'Junko');

		$this->load->library('employee');
		$this->load->library('user');

		foreach (range(1, 1000) as $index) {
			$employee = new Employee();			

			$employee->first_name    = $names[rand(0, count($names) - 1)];
			$employee->last_name     = $names[rand(0, count($names) - 1)];
			$employee->department_id = rand(1,5);
			$employee->position_id   = rand(1,5);			
			$employee->website		 = 'www.'. $employee->first_name .'.com';
			$employee->company_id 	 = 1;
			$employee->email     	 = $employee->first_name . '@' . $employee->last_name . '.com';	
			/*$employee->user_id       = $employee->user_id;			*/
			$employee->status_id     = rand(18,22);
			$employee->hire_date     = date('Y-m-d');
			$employee->regular_date  = date('Y-m-d');
			$employee->login         = md5($employee->first_name . $employee->last_name . time());

			if (!$employee->save()) {				
				var_dump($employee->get_validation_errors());exit();
			}
		}
	}

	public function populate_timerecord($offset = 0)
	{
		$this->load->library('timerecord');
		$this->load->model('employee_model');

		$total = $this->employee_model->count_results();
		
		$this->db->limit(1000, $offset);
		$this->db->order_by('employee_id', 'asc');
		$_e = $this->employee_model->fetch_all();
		$employees = $_e->result();

		$now = time();
		$last_month = strtotime('-1 month', $now);

		foreach ($employees as $employee) {
			$log_date = $last_month;
			// Load data for 1 month		
			while ($log_date < $now) {
				$log = new Timerecord();
				$log->employee_id = $employee->employee_id;
				$log->date 		  = date('Y-m-d', $log_date);
				$log->time_in 	  = $log->date . ' 09:' . rand(10,59) . ':00';
				$log->time_out 	  = $log->date . ' 18:' . rand(10,59) . ':00';
				
				if (!$log->save()) {
					var_dump($log->get_validation_errors());
				}

				$log_date = strtotime('+1 day', $log_date);
			}
		}

		if ($_e->num_rows() > 0) {
			redirect(site_url('dev/populate_timerecord/') . '/' . ($offset + 1000));
		}
	}

	public function test_relational_model()
	{
		$this->layout->setLayout('layout/front');
		
		add_js('libs/backbone.relational.js');		
		add_js('modules/employee/model.js');
		
		$this->layout->view('blank');
	}

	public function test_employee_get($employee_id)
	{
		$this->load->library('employee');
		$e = new Employee($employee_id);
		var_dump($e->getData());
	}	

	public function flush_cache()
	{
		$cache = Cache::get_instance();
		var_dump($cache->clean());exit();
	}

	private function _load_module_packages()
	{
        $this->load->config('modules');
        
        $modules = $this->config->item('modules');
        
        foreach ($modules as $module)
        {
            $this->load->add_package_path(MODPATH . $module);
        }		
	}	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */