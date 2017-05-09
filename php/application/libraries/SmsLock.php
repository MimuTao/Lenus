<?php
class SmsLock{
    private $ci;
    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model("Sms_lock_model");
    }
    public function clear(){
        $this->ci->Sms_lock_model->clear();
    }
}