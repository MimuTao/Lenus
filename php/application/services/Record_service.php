<?php
/**
 * Created by PhpStorm.
 * User: wa
 * Date: 2017/3/23
 * Time: 15:54
 */
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Record_service extends MY_Service
{
    //构造函数
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Record_model");
    }

    public function IsBind($param)
    {
        $param = $this->_check_param($param,array(SERVICE_PARAM_INT));
        $user_id = $param[0];
        $recordInfo = $this->Record_model->GetInfoByUserId($user_id);
        if(empty($recordInfo)){
            return $this->output(false,1034);
        }
        $data['report'] = intval($recordInfo['report']);
        return $this->output(true,1000,$data);
    }

    public function BindReport($param){
        $param = $this->_check_param($param,array(SERVICE_PARAM_INT,SERVICE_PARAM_STRING,SERVICE_PARAM_STRING,SERVICE_PARAM_STRING));
        $user_id  = $param[0];
        $code = $param[1];
        $bind_time = $param[2];
        $ins_mobile = $param[3];

        $recordInfo = $this->Record_model->GetInfoByUserId($user_id);
        if(empty($recordInfo)){
            $this->Record_model->Add($user_id,$code,$bind_time,$ins_mobile);
            return $this->output(true,1000);
        }else{
            return $this->output(false,1035);
        }
    }
}