<?php
namespace app\index\controller;

class Index extends Common
{
    public function index()
    {

		
		//var_dump($this->_settings);
        //return 'Version1.0';
		return $this->fetch();
    }
}
