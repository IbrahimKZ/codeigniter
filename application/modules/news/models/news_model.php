<?php
class News_Model extends CI_Model {
    
    private $table, $mname;

    public function __construct() {
        parent::__construct();
    }
    
    public function index($mname)
    {
        $this->mname=$mname;
    }
    
}