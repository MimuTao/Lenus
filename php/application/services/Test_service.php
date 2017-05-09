<?php
/**
 * Created by PhpStorm.
 * User: WJW
 * Date: 2016/4/11
 * Time: 21:12
 */
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Test_service extends MY_Service
{
    //构造函数
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * test
     */
    public function print_name($param)
    {
        $param = $this->_check_param($param,array(SERVICE_PARAM_STRING));
        $name = $param[0];

        return $this->output(true,1000,$name);
    }
}