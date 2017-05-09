<?php
/**
 * Created by PhpStorm.
 * User: WA
 * Date: 2016/4/11
 * Time: 21:09
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_service extends MY_Service{

    //构造方法
    public function __construct()
    {
        parent::__construct();
        $this->load->model("User_model");
        $this->load->model("User_identify_model");
        $this->load->model("Record_model");
        $this->load->model("Sms_model");
        $this->load->library("Des");
    }


    /**
     * 注册
     * @param $param
     * @return array
     * @throws Exception
     */


     //注册用户信息
    public function Register($param)
    {
        $param = $this->_check_param($param,array(SERVICE_PARAM_STRING,SERVICE_PARAM_STRING,SERVICE_PARAM_STRING));
        $mobile = $param[0];
        $pwd = $param[1];
        $r_pwd = $param[2];

        //检查手机号是否已注册
        $check = $this->User_model->GetInfoByMobile($mobile);
        //两次输入密码不一致
        if($pwd != $r_pwd){
            return $this->output(false,1029);
        }
        if(count($check)){
            return $this->output(false,1016);
        }
        $reg_time = time();
        $salt = generate_password();
        $pwd = my_salt_password_hash($pwd, $salt);
        $user_id = $this->User_model->AddUser($mobile,$pwd,$reg_time,$salt);
        $user_name = "会员".$user_id."号";
        $this->User_model->UpdateUserName($user_id,$user_name);
        $info = $this->User_model->GetInfoById($user_id);
        //
        $identify_info = $this->User_identify_model->info_by_user_id($user_id);
        if(empty($identify_info)){
            $identify_code = rand(10000, 99999);
            $this->User_identify_model->add($user_id, $identify_code, time(), time(),0);
        }else{
//            $identify_code = rand(10000, 99999);
//            $this->User_identify_model->UpdateOneInfo($user_id, "identify_code", $identify_code);
            $identify_code = $identify_info['identify_code'];
            $this->User_identify_model->UpdateOneInfo($user_id, "time", time());
            $this->User_identify_model->UpdateOneInfo($user_id, "last_time", time());
            $this->User_identify_model->UpdateOneInfo($user_id, "user_type", 0);
        }
        //
        $token = http_build_query(
            array(
                "user_id" => intval($user_id),
                "identify_code" => $identify_code
            )
        );
        $token = urlencode($this->des->encrypt($token));
        $recordInfo = $this->Record_model->GetInfoByUserId($user_id);
        if(empty($recordInfo)){
            $is_bind = 0;
            $report = 0;
        }else{
            $is_bind = 1;
            $report = intval(intval($recordInfo['report']));
        }

        $data = array(
            "token" => $token,
            "user_id"=>intval($user_id),
            "user_name"=>$info['user_name'],
            "head"=>$info['head'],
            "mobile"=>$info['mobile'],
            "sex"=>$info['sex'],
            "is_bind"=>$is_bind,
            "report"=>$report
        );
        return $this->output(true,1000,$data,'注册成功');
    }

    public function ForgetPwd($param){
        $param = $this->_check_param($param,array(SERVICE_PARAM_STRING,SERVICE_PARAM_STRING,SERVICE_PARAM_STRING));
        $mobile = $param[0];
        $pwd = $param[1];
        $r_pwd = $param[2];
        $info = $this->User_model->GetInfoByMobile($mobile);
        //两次输入密码不一致
        if($pwd != $r_pwd){
            return $this->output(false,1029);
        }
        if(empty($info)){
            return $this->output(false,1032);
        }
        $user_id = $info['id'];
        $salt = generate_password();
        $pwd = my_salt_password_hash($pwd, $salt);
        $this->User_model->UpdatePwd($user_id,$pwd,$salt);
        $identify_info = $this->User_identify_model->info_by_user_id($user_id);
        if(empty($identify_info)){
            $identify_code = rand(10000, 99999);
            $this->User_identify_model->add($user_id, $identify_code, time(), time(),0);
        }else{
            $identify_code = $identify_info['identify_code'];
            $this->User_identify_model->UpdateOneInfo($user_id, "time", time());
            $this->User_identify_model->UpdateOneInfo($user_id, "last_time", time());
            $this->User_identify_model->UpdateOneInfo($user_id, "user_type", 0);
        }
        $token = http_build_query(
            array(
                "user_id" => intval($user_id),
                "identify_code" => $identify_code
            )
        );
        $token = urlencode($this->des->encrypt($token));
        $recordInfo = $this->Record_model->GetInfoByUserId($user_id);
        if(empty($recordInfo)){
            $is_bind = 0;
            $report = 0;
        }else{
            $is_bind = 1;
            $report = intval(intval($recordInfo['report']));
        }

        $data = array(
            "token" => $token,
            "user_id"=>intval($user_id),
            "user_name"=>$info['user_name'],
            "head"=>$info['head'],
            "mobile"=>$info['mobile'],
            "sex"=>$info['sex'],
            "is_bind"=>$is_bind,
            "report"=>$report
        );
        return $this->output(true,1000,$data);
    }

    /**
     * 登录
     * @param $param
     */
    public function Login($param){
        $param = $this->_check_param($param,array(SERVICE_PARAM_STRING,SERVICE_PARAM_STRING));
        $mobile = $param[0];
        $pwd = $param[1];
        //检查该手机号是否已注册
        $info = $this->User_model->GetInfoByMobile($mobile);
        if(empty($info)){
            return $this->output(false,'1030');
        }
        //检查密码是否正确
        $salt = $info['salt'];
        $pwd = my_salt_password_hash($pwd, $salt);
        $loginCheck = $this->User_model->LoginCheck($mobile,$salt,$pwd);
        if(!empty($loginCheck)){
            //
            $user_id = $info['id'];
            $identify_info = $this->User_identify_model->info_by_user_id($user_id);
            if(empty($identify_info)){
                $identify_code = rand(10000, 99999);
                $this->User_identify_model->add($user_id, $identify_code, time(), time(),0);
            }else{
//                $identify_code = rand(10000, 99999);
//                $this->User_identify_model->UpdateOneInfo($user_id, "identify_code", $identify_code);
                $identify_code = $identify_info['identify_code'];
                $this->User_identify_model->UpdateOneInfo($user_id, "time", time());
                $this->User_identify_model->UpdateOneInfo($user_id, "last_time", time());
                $this->User_identify_model->UpdateOneInfo($user_id, "user_type", 0);
            }
            //
            $token = http_build_query(
                array(
                    "user_id" => intval($user_id),
                    "identify_code" => $identify_code
                )
            );
            $token = urlencode($this->des->encrypt($token));
            $recordInfo = $this->Record_model->GetInfoByUserId($user_id);
            if(empty($recordInfo)){
                $is_bind = 0;
                $report = 0;
            }else{
                $is_bind = 1;
                $report = intval(intval($recordInfo['report']));
            }
            $data = array(
                "token" => $token,
                "user_id"=>intval($user_id),
                "user_name"=>$info['user_name'],
                "head"=>$info['head'],
                "mobile"=>$info['mobile'],
                "sex"=>$info['sex'],
                "is_bind"=>$is_bind,
                "report"=>$report
            );
            return $this->output(true,1000,$data,'登录成功');
        }else{
            return $this->output(false,'1031');
        }
    }

    /**
     * 登录
     * @param $param
     */
    public function LoginByToken($param){
        $param = $this->_check_param($param,array(SERVICE_PARAM_INT));
        $user_id = $param[0];
        //检查该手机号是否已注册
        $info = $this->User_model->GetInfoById($user_id);
        if(empty($info)){
            return $this->output(false,'1030');
        }
        //检查密码是否正确
        $user_id = $info['id'];
        $identify_info = $this->User_identify_model->info_by_user_id($user_id);
        if(empty($identify_info)){
            $identify_code = rand(10000, 99999);
            $this->User_identify_model->add($user_id, $identify_code, time(), time(),0);
        }else{
//            $identify_code = rand(10000, 99999);
//            $this->User_identify_model->UpdateOneInfo($user_id, "identify_code", $identify_code);
            $identify_code = $identify_info['identify_code'];
            $this->User_identify_model->UpdateOneInfo($user_id, "time", time());
            $this->User_identify_model->UpdateOneInfo($user_id, "last_time", time());
            $this->User_identify_model->UpdateOneInfo($user_id, "user_type", 0);
        }
        //
        $token = http_build_query(
            array(
                "user_id" => intval($user_id),
                "identify_code" => $identify_code
            )
        );
        $token = urlencode($this->des->encrypt($token));
        $recordInfo = $this->Record_model->GetInfoByUserId($user_id);
        if(empty($recordInfo)){
            $is_bind = 0;
            $report = 0;
        }else{
            $is_bind = 1;
            $report = intval(intval($recordInfo['report']));
        }
        $data = array(
            "token" => $token,
            "user_id"=>intval($user_id),
            "user_name"=>$info['user_name'],
            "head"=>$info['head'],
            "mobile"=>$info['mobile'],
            "sex"=>$info['sex'],
            "is_bind"=>$is_bind,
            "report"=>$report
        );
        return $this->output(true,1000,$data,'登录成功');
    }

    public function IsRegister($param){
        $param = $this->_check_param($param,array(SERVICE_PARAM_STRING));
        $mobile = $param[0];
        $info = $this->User_model->GetInfoByMobile($mobile);
        if(!empty($info)){
            return $this->output(true,1000);
        }else{
            return $this->output(false,1032);
        }
    }

    public function UpdateHead($param){
        $param = $this->_check_param($param,array(SERVICE_PARAM_INT,SERVICE_PARAM_STRING));
        $user_id = $param[0];
        $head = $param[1];
        $this->User_model->UpdateHead($user_id,$head);
        return $this->output(true,1000);
    }

    public function UpdateUserName($param){
        $param = $this->_check_param($param,array(SERVICE_PARAM_INT,SERVICE_PARAM_STRING));
        $user_id = $param[0];
        $user_name = $param[1];
        $this->User_model->UpdateUserName($user_id,$user_name);
        return $this->output(true,1000);
    }
    

    /**
    * 修改密码   Designed By Tao.
    * @param $user_id  $oldPwd  $newPwd
    * @return array
    */
    public function ResetPwd($param){
        $param = $this->_check_param($param,array(SERVICE_PARAM_INT,SERVICE_PARAM_STRING,SERVICE_PARAM_STRING));
        $user_id=$param[0];
        $oldPwd=$param[1];
        $newPwd=$param[2];
        $info=$this->User_model->GetInfoById($user_id);
        $salt=$info['salt'];
        $db_pwd=$info['pwd'];
        $temp_oldPwd = md5($oldPwd.$salt);
        $temp_newPwd = md5($newPwd.$salt);
        if($temp_oldPwd==$db_pwd){            //如果输入的老密码跟用户在数据库中密码一致，那么重设密码，否则返回错误
            $this->User_model->UpdatePwd($user_id,$temp_newPwd,$salt);
            return $this->output(true,1000,'','重置密码成功');
        }
        else 
            return $this->output(true,1015,'','输入密码与原密码不一致');
    }

}