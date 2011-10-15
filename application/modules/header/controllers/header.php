<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Header extends MX_Controller {
    
    public $mname, $tag; 
    
    function __construct()
    {
        $this->mname=strtolower(get_class());// imya modulya               
        $this->tag=strtoupper($this->mname); // TAG v shablone   
    } 

    public function index()
    {     
        $this->load->model($this->mname.'/'.$this->mname.'_model');
        $model=$this->mname.'_model';
        $this->$model->index($this->mname);
        $this->tp->parse($this->tag, $this->mname.'/'.$this->mname.'.tpl');
    }
    
}
