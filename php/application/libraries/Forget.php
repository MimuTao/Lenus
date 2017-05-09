<?php
class Forget{
    private $ci;
    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model("Sms_model");
        $this->ci->load->model("Queue_model");
        $this->ci->load->model("Queue_log_model");
        $this->ci->load->library("SendSms");

    }
    public function run(){
        $list = $this->ci->Queue_model->get_list("forget",20);
        foreach($list as $v){
            $params = json_decode($v['params'],true);
            $mobile = $params['mobile'];
            $code = $params['code'];
            $sms_id = $params['sms_id'];
            //
            //发送短信验证码在这里
            $this->ci->sendsms->sendTemplateSMS($mobile,$code,"JSM40716-0003");
            //
            if(true){//发送成功
                $this->ci->Queue_log_model->add($v['id'],$v['type'],1,$v['params'],$v['time'],time());
                $this->ci->Sms_model->update_status($sms_id,2);
                $this->ci->Queue_model->del($v['id']);
            }
            else{//发送失败
                $this->ci->Queue_log_model->add($v['id'],$v['type'],2,$v['params'],$v['time'],time());
                $this->ci->Sms_model->update_status($sms_id,1);
                $this->ci->Queue_model->del($v['id']);
            }
        }
    }
}