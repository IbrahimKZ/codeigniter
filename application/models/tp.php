<?php
class Tp extends CI_Model{
    
    public $D, $tpl;
    
    function __construct()
    {
        $this->D=array();   
    }
    
    function load_tpl($tpl_name)
    {
        $TPL=$this->load->view('templates/'.$tpl_name, FALSE, TRUE);
        $pattern = '/{[A-Z0-9_]+}/';
        $pattern2 = '/{[a-z_]+}/';
        preg_match_all($pattern, $TPL, $MODULES); // nahodit metki na shaplony
        preg_match_all($pattern2, $TPL, $VALUES); // nahodit metki na peremennye
        
        foreach ($MODULES[0] as $MODULE)
        {
            $module=substr($MODULE,1,-1);
            if (!isset($this->D[$module]))
            {
                $this->D[$module]='';
                $this->common->load_module(strtolower($module));     
            }
        }
        foreach ($VALUES[0] as $VALUE)
        {
            $value=substr($VALUE,1,-1);
            if (!isset($this->D[$value]))
            {
                $this->D[$value]='';
            }
        }
        $this->D['TPL']=$tpl_name;
    }  
    
    function print_page()
    {
        $this->parser->parse('templates/'.$this->D['TPL'], $this->D);    
    }
    
    function parse($label, $tpl)
    {
        $TPL=$this->load->view($tpl, FALSE, TRUE);
        $pattern = '/{[A-Za-z0-9_]+}/';
        preg_match_all($pattern, $TPL, $MODULES); // nahodit metki v shaplone
        foreach ($MODULES[0] as $MODULE)
        {
            $module=substr($MODULE,1,-1);
            if (!isset($this->D[$module])) $this->D[$module]=$this->lang->line($module); // esli oni ne opredeleny, to smotrit v langs
        } 
        if (isset($this->D[$label]))
        {
            $this->D[$label].=$this->parser->parse($tpl, $this->D, TRUE);   
        }
        else
        {
            $this->D[$label]=$this->parser->parse($tpl, $this->D, TRUE);    
        } 
    }
    
    function clear($label)
    {
        $this->D[$label]='';        
    }
    
    function kill($label)
    {
        unset($this->D[$label]);        
    }
    
    function assign($label, $value='')
    {
        if (is_array($label))
        {
            foreach ($label as $l=>$v)
            {
                $this->D[$l]=$v;
            }
        }
        else
        $this->D[$label]=$value;
    }
    
    function megaassign($label, $value)
    {
        if (isset($this->D[$label])) $this->D[$label].=$value;
        else $this->D[$label]=$value;
    }
    
    function get_value($table, $col, $id)
    {
        $q='SELECT `'.$col.'` FROM `'.$table.'` WHERE id=\''.$id.'\' LIMIT 1';
        $r=mysql_query($q);
        if (mysql_num_rows($r))
        {
            $row=mysql_fetch_array($r);
            return $row[$col];   
        }   
        else
        {
            return '';
        }
    }
    
    function get_count($table, $col, $id)
    {
        $q='SELECT count(id) as c FROM `'.$table.'` WHERE `'.$col.'`=\''.$id.'\'';
        $r=mysql_query($q);
        if (mysql_num_rows($r))
        {
            $row=mysql_fetch_array($r);
            return $row['c'];   
        }   
        else
        {
            return '0';
        }
    }
    
    
    function print_array($array)
    {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }
    
    function show_msg($msg, $class='msg_error', $label='MSG')
    {
        $this->megaassign($label, '<div class="'.$class.'">'.$msg.'</div>');
    }
    
    function content($label)
    {
        $r=false;
        if (isset($this->D[$label]))
        {
            if ($this->D[$label]) $r=$this->D[$label];
        }
        return $r;
    }
        
}