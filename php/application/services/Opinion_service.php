<?php
/**
 * Created by PhpStorm.
 * User: wa
 * Date: 2017/3/27
 * Time: 18:26
 */
class Opinion_service extends MY_Service
{
    //构造函数
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Opinion_model");
    }

    public function Add($param){
        $param = $this->_check_param($param, array(SERVICE_PARAM_INT,SERVICE_PARAM_STRING));
        $user_id = $param[0];
        $opinion = $param[1];
        $this->Opinion_model->Add($user_id,$opinion,time());
        return $this->output(true, 1000);
    }

}