<?php
class Empty_module_Model extends CI_Model {
    
    private $table, $mname;

    public function __construct() {
        parent::__construct();
        $this->table='';
    }
    
    public function index($mname)
    {
        $this->mname=$mname;
    }
    
}