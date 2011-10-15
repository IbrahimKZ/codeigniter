<?php
class Main extends MX_Controller {
    
    private $modules;
    public $tpl;
    
    function __construct()
    {
        $this->modules=array('news','empty_module_url'); // dostupnye moduli iz urla           
    }

    function index()
    {
        @session_start();  
        $this->check_lang();  // proveryaet yazyk v urle
        $this->check_module();  // proveryaet modul v urle
        $this->tp->load_tpl($this->tp->tpl); // zagruzhaet shablon i proveryaet na moduli
        $this->tp->print_page(); // vyvodit shablon s prorabotannymi modulami na ekran
    }
    
    function check_lang()
    {
        if ($this->uri->segment(1))
        {
            switch ($this->uri->segment(1))
            {
                case 'en': define('LANG','en'); break;
                case 'ru': define('LANG','ru'); $this->config->set_item('language', 'russian');  break;  
                default: show_404('page');
            }    
        }
        else
        {
            define('LANG','en');
        }
        $this->tp->assign("LANG",LANG);
        $this->tp->assign("SITEURL",SITEURL);
        define('URL',SITEURL.'/'.LANG);
        $this->tp->assign("URL",URL);
    }
    
    function check_module()
    {
        if ($m=$this->uri->segment(2))
        {
            if (in_array($m,$this->modules))
            {
                $this->common->load_module($m);
                $this->tp->tpl=$this->$m->tpl;
            }
            else
            {
                show_404('page');   
            }
        }   
        else
        {
            $this->load_main_page(); // esli net vtorogo segmenta, to zagruzhaet glavnuyu stranicu
        }
    }
    
    function load_main_page()
    {
        $this->tp->tpl='p_default.tpl';     
        $this->tp->assign('page_title','Главная страница'); 
        $this->tp->assign('CONTENT','<a href="'.URL.'/news">Новости</a>'); 
    }   
    
}
?>
