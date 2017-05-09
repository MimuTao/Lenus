<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Api相关
 */
class PcApi_service extends MY_Service
{
    private $data;
    private $api_info;

    /**
     *构造方法
     */
    public function __construct() {
        parent::__construct();
        $this->load->library("Des");

    }

    /**
     * 运行
     * @param array $param 参数
     * @return array
     * @throws Exception
     */
    public function run($data) {
        $name = isset($data['name']) ? $data['name'] : "";
        $this->load->model("Open_api_model");
        $this->api_info = $this->Open_api_model->InfoByName($name);

        if (empty($this->api_info)) {
            showresult(false, 1002, "");
        }
        if ($this->api_info['status'] == "NO") {
            showresult(false, 1003, "");
        }
        $to_parse_arr = array();
        if ($this->api_info['need_login']==0) {
            foreach ($data as $k => $v) {
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
            ShowArrayResult($result);
        }
        elseif($this->api_info['need_login'] == 2){
            $user_id =  isset($_SESSION['user_id'])?$_SESSION['user_id']:0;
            if ($user_id!=0){//如果传入了user_id
                $user_id = intval($_SESSION['user_id']);
                if(empty($user_id)){
                    showresult(false, 1004, "");
                }
                $data['user_id'] = $user_id;
                foreach ($data as $k => $v) {
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
            else{
                $data['user_id'] = 0;
                foreach ($data as $k => $v) {
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
            }
            ShowArrayResult($result);
        }
        else {
            $user_id = isset($_SESSION['user_id'])?intval($_SESSION['user_id']):0;
            if(empty($user_id)){
                showresult(false, 1004, "");
            }
            $data['user_id'] = $user_id;
            foreach ($data as $k => $v) {
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
            }else if($v['type'] == "double") {
                $this->data[] = doubleval($param[$k]);
            }
        }
        return $ret;
    }

}
/* End of file App_service.php */