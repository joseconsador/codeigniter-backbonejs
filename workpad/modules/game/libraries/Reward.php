<?php

/**
 * This class represents a reward item.
 */
class Reward extends Base
{
    private $_upload_options = array(
        'upload_path' => 'uploads/hr/rewards/',
        'allowed_types' => 'jpg|png',
        'max_size'  => '2000',
        'field_name' => 'file_attachment',
        'encrypt_name' => TRUE
    );  

    // --------------------------------------------------------------------

    public function getModel()
    {
        $CI =& get_instance();
        $CI->load->model('reward_model', '' ,true);

        return $CI->reward_model;
    }

    // --------------------------------------------------------------------
    
    public function set_validators()    
    {   
        $this->_validators['name'] = array(new Zend_Validate_NotEmpty());
        $this->_validators['description'] = array(new Zend_Validate_NotEmpty());
    }

    // -------------------------------------------------------------------- 

    public function getAttachment()
    {
        if ($this->image_upload_id > 0) {
            $file = new Hdi_UploadedFile($this->image_upload_id);
            return $file;
        } else {
            return null;
        }
    }

    // --------------------------------------------------------------------

    public function save()
    {
        $id = FALSE;

        if (array_key_exists('file_attachment', $_FILES)) {
            $handle = new Hdi_UploadHandler($this->_upload_options);

            $id = parent::save();

            if ($id && !$handle->upload()) {
                $this->_validation_errors['file_attachment'] = $handle->get_errors();

                return FALSE;
            } else if ($id) {
                $filedata = $handle->get_data();

                if ($this->image_upload_id > 0) {                    
                    $old = $this->getAttachment();
                    $old->delete();
                }                

                $log = new Hdi_UploadedFile();

                $log->filename = $filedata['orig_name'];
                $log->user_id  = $this->created_by;
                $log->upload   = $this->_upload_options['upload_path'] . $filedata['file_name'];

                $this->image_upload_id = $log->save();

                $ci =& get_instance();
                // Resize the image
                $config['image_library'] = 'gd2';
                $config['source_image'] = $log->upload;
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = FALSE;
                $config['width'] = 260;
                $config['height'] = 180;

                $ci->load->library('image_lib', $config);

                if ( ! $ci->image_lib->resize())
                {
                    echo $ci->image_lib->display_errors();
                }              
            }
        }
        
        return parent::save();
    }


}