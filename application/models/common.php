<?php
class Common extends CI_Model{
        
    public function __construct() {
        parent::__construct();
    }
    
    function load_module($module)
    {
        if (is_dir('application/modules/'.$module))  // proveryaet, sushestvuet li modul
        {
            $this->load->module($module);
            $this->$module->index();
        }        
    }
    
    function load_controller($module, $contr)
    {
        if (is_file('application/modules/'.$module.'/controllers/'.$contr.'.php'))
        {
            $this->load->module($module.'/'.$contr);
            $this->$contr->index($module);   
        }
        else
        {
            show_404('page');
        }
    }
    
    function load_model($module, $model, $folder='')
    {
        $model.='_model';
        if ($folder) $folder.='/';
        if (is_file('application/modules/'.$module.'/models/'.$folder.$model.'.php'))
        {
            $this->load->model($module.'/'.$folder.$model);
            $this->$model->index($module);   
        }
        else
        {
            show_404('page');
        }
    }  
        
}
