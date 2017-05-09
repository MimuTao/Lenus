<?php
/**
 * Created by PhpStorm.
 * User: WJW
 * Date: 2016/4/11
 * Time: 21:51
 */
if(!defined('BASEPATH')) exit('No direct script access allowed');

//api相关
class Api_service extends MY_Service
{
    private $data;
    private $api_info;

    //构造方法
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Des");
    }

    /**
     * 运行
     * @param array $param 参数
     * @return array
     * @throws Exception
     */
    public function run($param) {
        $param_data = $this->_check_param($param, array(SERVICE_PARAM_STRING));
        $encrypt_str = $param_data[0];
        $decrypt_str = $this->des->decrypt($encrypt_str);//解密
        parse_str($decrypt_str, $request);//得到请求参数
                

        $dir = date("Y_m", time());
        $file = date("Y_m_d", time());
        if (!file_exists(APPPATH . 'logs/' . $dir)) {
            mkdir(APPPATH . 'logs/' . $dir, 0755);
        }
        error_log(date("Y-m-d H:i:s", time()) . "     " . json_encode($request) . chr(10), 3, APPPATH . "logs/" . $dir . "/input_deal_" . $file . ".php");

        $name = isset($request['name']) ? $request['name'] : "";
        $this->load->model("Open_api_model");
        $this->api_info = $this->Open_api_model->InfoByName($name);

        

        if (empty($this->api_info)) {
            showresult(false, 1002, '');
        }   
        if ($this->api_info['status'] == "NO") {
            showresult(false, 1003, "");
        }

        $to_parse_arr = array();
        //if ($this->api_info['name'] == "queqiao.sys.login"||$this->api_info['name'] == "scancode.sys.print"  ||$this->api_info['name'] == "queqiao.sys.forget.sms" || $this->api_info['name'] == "queqiao.sys.register"||$this->api_info['name'] == "queqiao.sys.register.sms.send"||$this->api_info['name'] == "queqiao.sys.find.password") {
        if ($this->api_info['need_login'] == 0) {//不需要传入user_id 不传入token
            foreach ($request as $k => $v) {
                if ($k == "name") {
                    continue;
                } else {
                    $to_parse_arr[$k] = $v;
                }
            }
            //参数判断
            if ($this->invalid_param($this->api_info['rule'], $to_parse_arr) == false) {
                showresult(false, 1005, "");
            }
            $service = $this->api_info['service'];
            $method = $this->api_info['method'];
            $this->load->service($service);
            $instance = new $service();
            $call = array($instance, $method);
            $result = call_user_func_array($call, array($this->data));
            error_log(date("Y-m-d H:i:s", time()) . "     " . json_encode($result) . chr(10), 3, APPPATH . "logs/" . $dir . "/result_" . $file . ".php");
            ShowArrayResult($result);
        }
        elseif($this->api_info['need_login'] == 2){
            //如果传入token
            if (isset($request['token'])&&!empty($request['token'])){
                $token = ($request['token']);
                $temp = $this->des->decrypt($token);
                parse_str($temp, $temp);
                if (!isset($temp['user_id']) || !isset($temp['user_id'])) {
                    showresult(false, 1005, "");
                }
                $this->load->model("User_identify_model");
                $this->load->model("User_model");
                $identify_info = $this->User_identify_model->info($temp['user_id'], $temp['identify_code']);
                /**
                 *如果不在该用户类型中-start
                 */
                $user_info = $this->User_model->GetInfoById($temp['user_id']);
                //$token_type = $temp['user_type'];

                //$user_type = $user_info['type'];

                //游客 会员 会员未登录是游客
                $user_type_limit = json_decode($this->api_info['user_type_limit'],true);

                /*if(!in_array($user_type,$user_type_limit)){
                    showresult(false, 1030, "");
                }*/

                /**
                 *如果不在该用户类型中-end
                 */
                if (empty($identify_info)) {
                    showresult(false, 1004, "");
                }
                if (time() - $identify_info['last_time'] > 60 * 60 * 24 * 14) {
                    showresult(false, 1006, "");
                }
                if ($identify_info['last_time'] > time()) {
                    showresult(false, 1007, "");
                }
                $request['user_id'] = $temp['user_id'];
                $request['identify_code'] = $temp['identify_code'];

                foreach ($request as $k => $v) {
                    if ($k == "name") {
                        continue;
                    } elseif ($k == "token") {
                        continue;
                    } else {
                        $to_parse_arr[$k] = $v;
                    }
                }
                //参数判断
                if ($this->invalid_param($this->api_info['rule'], $to_parse_arr) == false) {
                    showresult(false, 1005, "");
                }
                $service = $this->api_info['service'];
                $method = $this->api_info['method'];
                $this->load->service($service);
                $instance = new $service();
                $call = array($instance, $method);

                $result = call_user_func_array($call, array($this->data));
            }
            else{//如果传入了user_id

                foreach ($request as $k => $v) {
                    if ($k == "name") {
                        continue;
                    } else {
                        $to_parse_arr[$k] = $v;
                    }
                }
                //参数判断
                $to_parse_arr['user_id'] = 0;
                if ($this->invalid_param($this->api_info['rule'], $to_parse_arr) == false) {
                    showresult(false, 1005, "");
                }
                $service = $this->api_info['service'];
                $method = $this->api_info['method'];
                $this->load->service($service);
                $instance = new $service();
                $call = array($instance, $method);
                $result = call_user_func_array($call, array($this->data));
            }
            error_log(date("Y-m-d H:i:s", time()) . "     " . json_encode($result) . chr(10), 3, APPPATH . "logs/" . $dir . "/result_" . $file . ".php");
            ShowArrayResult($result);
        }
        else {//传入token
            $token = ($request['token']);
            $temp = $this->des->decrypt($token);
            parse_str($temp, $temp);
            if (!isset($temp['user_id']) || !isset($temp['user_id'])) {
                showresult(false, 1005, "");
            }
            $this->load->model("User_identify_model");
            $this->load->model("User_model");
            $identify_info = $this->User_identify_model->info($temp['user_id'], $temp['identify_code']);
            /**
             *如果不在该用户类型中-start
             */
            $user_info = $this->User_model->GetInfoById($temp['user_id']);
            //$token_type = $temp['user_type'];

            //$user_type = $user_info['type'];

            //游客 会员 会员未登录是游客
            $user_type_limit = json_decode($this->api_info['user_type_limit'],true);

            /*if(!in_array($user_type,$user_type_limit)){
                showresult(false, 1030, "");
            }*/

            /**
             *如果不在该用户类型中-end
             */
            if (empty($identify_info)) {
                showresult(false, 1004, "");
            }
            if (time() - $identify_info['last_time'] > 60 * 60 * 24 * 14) {
                showresult(false, 1006, "");
            }
            if ($identify_info['last_time'] > time()) {
                showresult(false, 1007, "");
            }
            $request['user_id'] = $temp['user_id'];
            $request['identify_code'] = $temp['identify_code'];

            foreach ($request as $k => $v) {
                if ($k == "name") {
                    continue;
                } elseif ($k == "token") {
                    continue;
                } else {
                    $to_parse_arr[$k] = $v;
                }
            }
            //参数判断
            if ($this->invalid_param($this->api_info['rule'], $to_parse_arr) == false) {
                showresult(false, 1005, "");
            }
            $service = $this->api_info['service'];
            $method = $this->api_info['method'];
            $this->load->service($service);
            $instance = new $service();
            $call = array($instance, $method);
            $result = call_user_func_array($call, array($this->data));
            //error_log(date("Y-m-d H:i:s", time()) . "     " . json_encode($result) . chr(10), 3, APPPATH . "logs/" . $dir . "/result_" . $file . ".php");
            ShowArrayResult($result);
        }
    }

    /**
     * 检查参数
     * @param string $rule
     * @param string $app_secret
     * @param string $token
     * @param string $param
     * @return bool
     */
    private function invalid_param($rule, $param) {
        $ret = true;
        //$param = json_decode($param, true);
        $rule_array = json_decode(trim($rule), true);
        $param_check = isset($rule_array['param']) ? $rule_array['param'] : array();
        if (count($param) < count($param_check)) {
            //参数不足
            return false;
        }
        $this->data = array();
        //整理参数
        foreach ($param_check as $k => $v) {
            if ($v['type'] == "string") {
                $this->data[] = trim($param[$k]);
            } else if ($v['type'] == "int") {
                $this->data[] = intval($param[$k]);
            } else if ($v['type'] == "array") {
                $this->data[] = is_array($param[$k]) ? $param[$k] : array();
            } else if ($v['type'] == "float") {
                $this->data[] = floatval($param[$k]);
            } else if ($v['type'] == "double") {
                $this->data[] = doubleval($param[$k]);
            }
        }
        return $ret;
    }
}
/* End of file App_service.php */