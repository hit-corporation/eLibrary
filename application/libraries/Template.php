<?php

class template {

     public $template; 
     private $ci;

    public function __construct() {
        $this->template = new League\Plates\Engine(VIEWPATH.'');
        $this->ci =& get_instance();

        $this->template->loadExtension(new League\Plates\Extension\URI(base_url()));
    }

    public function instance() {
        return $this->template;
    }

    public function registerFunction($folder, $cb) {
        if(!is_callable($cb)) {
            throw $cb.' is not callable';
        }
        
        return $this->template->registerFunction($folder, $cb);
    }

    public function render($template='', $data=[], $folder=NULL) {
        $f = empty($folder) ? $this->ci->router->class : $folder;
        $this->template->loadExtension(new \League\Plates\Extension\Asset(getcwd().'/', FALSE));
        $this->template->addFolder($f, VIEWPATH.$f, TRUE);
        $this->template->addFolder('layouts', VIEWPATH.'layouts', TRUE);
       
        return $this->template->render($f.'::'.$template, $data);
    }
}