<?php
/**
 * Created by PhpStorm.
 * User: wa
 * Date: 2017/3/20
 * Time: 22:12
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 短信
 */
class Sms_service extends MY_Service
{
    /**
     *构造方法
     */
    public function __construct() {
        parent::__construct();
        $this->load->model("Sms_model");
        $this->load->library("Curl");
        $this->curl->init();
        //require_once APPPATH.'third_party/sms/ChuanglanSmsApi.php';
    }

    /**
     * 发送短信
     * 这里检查能不能发，发送数据就好了
     */
    public function RegSendMsg($param){
        $param = $this->_check_param($param, array(SERVICE_PARAM_STRING));
        $mobile = $param[0];
        $code = rand(1000,9999);
        if(check_mobile($mobile)==false){
            return $this->output(false, 1005,"","手机号码不合法");
        }
        $sms_id = $this->Sms_model->Add($code,time(),time()+60*5,2,$mobile,'register');
        $url = "http://api.91jianmi.com/sdk/SMS";
        $data = array(
            "uid"=>3728,
            "psw"=>"e007a6ee9829c1664ab8685e7521514a",
            "cmd"=>"send",
            "mobiles"=>$mobile,
            "msgid"=>"",
            "subid"=>"",
            "msg"=> iconv("UTF-8", "GB2312//IGNORE", "【我是谁】您的验证码是".$code)
        );
        $this->curl->get($url,$data);
//        $params = json_encode(array(
//            "mobile"=>$mobile,
//            "code"=>$code,
//            "sms_id"=>$sms_id
//        ));
//        $time = time();
//        $queue_id = $this->Queue_model->add("sms",0,$params,$time);
//        $this->Queue_log_model->add($queue_id,"sms",0,$params,$time,time());
        //
//        $clapi  = new ChuanglanSmsApi();
//        $result = $clapi->sendSMS($mobile, '您好，您的验证码是'.$code,'true');
//        $result = $clapi->execResult($result);
//        if($result[1]==0){
//            $this->Sms_model->update_status($sms_id,2);
//        }else{
//            $this->Sms_model->update_status($sms_id,1);
//        }
        $this->Sms_model->update_status($sms_id,2);
        return $this->output(true, 1000);
    }

    public function ConfirmReg($param){
        $param = $this->_check_param($param, array(SERVICE_PARAM_STRING,SERVICE_PARAM_STRING));
        $mobile = $param[0];
        $code = $param[1];
        $info = $this->Sms_model->GetInfo($mobile, $code, "register");
        if (empty($info)) {
            return $this->output(false, 1024);
        }
        if ($info['due_time'] < time()) {
            return $this->output(false, 1017);
        }
        $this->Sms_model->UpdateStatusByMobileCode($mobile,$code,5,'register');
        return $this->output(true, 1000);
    }


    public function ForgetPassword($param){
        $param = $this->_check_param($param, array(SERVICE_PARAM_STRING));
        $mobile = $param[0];
        $code = rand(1000,9999);
        if(check_mobile($mobile)==false){
            return $this->output(false, 1005,"","手机号码不合法");
        }

        $sms_id = $this->Sms_model->add($code,time(),time()+60*5,2,$mobile,'forget');
        $url = "http://api.91jianmi.com/sdk/SMS";
        $data = array(
            "uid"=>3728,
            "psw"=>"e007a6ee9829c1664ab8685e7521514a",
            "cmd"=>"send",
            "mobiles"=>$mobile,
            "msgid"=>"",
            "subid"=>"",
            "msg"=> iconv("UTF-8", "GB2312//IGNORE", "【我是谁】您的验证码是".$code)
        );
        $this->curl->get($url,$data);
//        $params = json_encode(array(
//            "mobile"=>$mobile,
//            "code"=>$code,
//            "sms_id"=>$sms_id
//        ));
//        $time = time();
//        $queue_id = $this->Queue_model->add("forget",0,$params,$time);
//        $this->Queue_log_model->add($queue_id,"forget",0,$params,$time,time());
        //
//        $clapi  = new ChuanglanSmsApi();
//        $result = $clapi->sendSMS($mobile, '您好，您的验证码是'.$code,'true');
//        $result = $clapi->execResult($result);
//        if($result[1]==0){
//            $this->Sms_model->update_status($sms_id,2);
//        }else{
//            $this->Sms_model->update_status($sms_id,1);
//        }
        $this->Sms_model->update_status($sms_id,2);
        //
        return $this->output(true, 1000);
    }

    public function ConfirmForget($param){
        $param = $this->_check_param($param, array(SERVICE_PARAM_STRING,SERVICE_PARAM_STRING));
        $mobile = $param[0];
        $code = $param[1];
        $info = $this->Sms_model->GetInfo($mobile, $code, "forget");
        if (empty($info)) {
            return $this->output(false, 1024);
        }
        if ($info['due_time'] < time()){
            return $this->output(false, 1017);
        }
        $this->Sms_model->UpdateStatusByMobileCode($mobile,$code,5,'forget');
        return $this->output(true, 1000);
    }


}