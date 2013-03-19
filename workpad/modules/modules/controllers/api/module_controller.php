<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Module_controller extends HDI_rest_controller
{
    function modules_get()
    {
        $modulesCollection = new Modules();
        $modulesCollection->load_from_xml(MODULES_XML_PATH);

        /*print_r($modulesCollection->modules->xpath('//*[@uuid="201"]'));exit();*/

        $modules = array(0 => array(
                'module_id' => 0,
                'uuid' => 'default',
                'name' => 'default',
                'enabled' => '1',
                'dir' => ''
            )
        );

        foreach ($modulesCollection->modules as $module) {                        
            $modules[] = $this->_format($module);
        }

        $this->response($modules, 200);
    }

    // --------------------------------------------------------------------

    function module_get()
    {
        $module = new Module($this->get('id'));

        $this->response($module->getData());
    }        

    // --------------------------------------------------------------------
    
    function module_post() 
    {
     
    }

    // --------------------------------------------------------------------
    
    function module_put() 
    {        
        $modules = Modules::get_default_modules_xml();
        
        foreach ($modules as $module) {
            if ($module['uuid'] == $this->get('id')) {
                $module->enabled = (int) $this->put('enabled');
                $module->name    = $this->put('name');
                $module->dir     = $this->put('dir');
                $module['uuid']  = $this->put('uuid');

                $response = $this->_format($module);
            }
        }

        $modules->asXml(MODULES_XML_PATH);

        $this->response($response);
    }

    // --------------------------------------------------------------------

    function module_delete()
    {
        $this->delete(new Module($this->get('id')));
    }


    private function _format($module)
    {
        $m = (array) $module;
        $m['module_id'] = (string) $module['uuid'];
        $m['uuid'] = (string) $module['uuid'];

        return $m;
    }
}