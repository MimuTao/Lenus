<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * bool 类型
 */
const SERVICE_PARAM_BOOL = 0;
/**
 * int 类型
 */
const SERVICE_PARAM_INT = 1;
/**
 * float 类型
 */
const SERVICE_PARAM_FLOAT = 2;
/**
 * double 类型
 */
const SERVICE_PARAM_DOUBLE = 3;
/**
 * string 类型
 */
const SERVICE_PARAM_STRING = 4;
/**
 * array 类型
 */
const SERVICE_PARAM_ARRAY = 5;
/**
 * object 类型
 */
const SERVICE_PARAM_OBJECT = 6;

/**
 * callable
 */
const SERVICE_PARAM_CALLABLE = 7;

/**
 * 正常返回接口
 */
const SERVICE_SUCCESS = 0;

class MY_Service
{
    protected $_empty_head;
    /**
     * Constructor
     *
     * @access public
     */
    public function __construct()
    {
        log_message('info', "Service Class Initialized");
        $this->_empty_head = "http://www.xiezhanwang.com/static/head.png";
        require_once(APPPATH."third_party/gump.class.php");
    }
    /**
     * __get
     *
     * Allows services to access CI's loaded classes using the same
     * syntax as controllers.
     *
     * @param    string
     * @access private
     */
    function __get($key)
    {
        $CI = &get_instance();
        return $CI->$key;
    }

    /**
     * 检查参数
     * @param array $param
     * @param array $rule
     * @return array
     * @throws Exception
     */

     //检查参数——检查参数传进来的个数是否跟我们期望的数量是一样的，同时把传进来的参数设置成合适的类型
     //数据返回时，保存在param数组中，param[i]对应我们需要的第i个数据 
     //当传入的数据跟我们期望的数据量不一致时抛出异常
    // protected function _check_param($param, $rule)
    // {
    //     if (count($param) != count($rule)) {
    //         throw new Exception("param invalid");
    //     }
    //     $param = array_values($param);
    //     foreach ($rule as $k => $v) {
    //         if (SERVICE_PARAM_BOOL == $v) {
    //             $param[$k] = (bool)$param[$k];
    //         } elseif (SERVICE_PARAM_INT == $v) {
    //             $param[$k] = intval($param[$k]);
    //         } elseif (SERVICE_PARAM_FLOAT == $v) {
    //             $param[$k] = floatval($param[$k]);
    //         } elseif (SERVICE_PARAM_DOUBLE == $v) {
    //             $param[$k] = doubleval($param[$k]);
    //         } elseif (SERVICE_PARAM_STRING == $v) {
    //             $param[$k] = (string )($param[$k]);
    //         } elseif (SERVICE_PARAM_ARRAY == $v) {
    //             if (!is_array($param[$k])) {
    //                 throw new Exception("param invalid");
    //             }
    //         } elseif (SERVICE_PARAM_OBJECT == $v) {
    //             if (!is_object($param[$k])) {
    //                 throw new Exception("param invalid");
    //             }
    //         } elseif (SERVICE_PARAM_CALLABLE == $v) {
    //             if (!is_callable($param[$k])) {
    //                 throw new Exception("param invalid");
    //             }
    //         }
    //     }
    //     return $param;
    // }
    //代码修改  MimuTao修改
    protected function _check_param($param, $rule)
    {
        if (count($param) != count($rule)) {
            throw new Exception("param invalid");
        }
        $param = array_values($param);
        foreach ($rule as $k => $v) {
 
             switch($v){
                 case SERVICE_PARAM_BOOL :
                    $param[$k] = (bool)$param[$k];
                    break;   
                 case SERVICE_PARAM_INT:
                    $param[$k] = intval($param[$k]);
                    break;
                 case SERVICE_PARAM_FLOAT:
                    $param[$k] = floatval($param[$k]);
                    break;
                 case SERVICE_PARAM_DOUBLE:
                    $param[$k] = doubleval($param[$k]);
                    break;
                 case SERVICE_PARAM_STRING:
                    $param[$k] = (string )($param[$k]);
                    break;
                 case SERVICE_PARAM_ARRAY:
                    if (!is_array($param[$k])) 
                        throw new Exception("param invalid");
                    break;
                 case SERVICE_PARAM_OBJECT:
                    if (!is_object($param[$k])) 
                        throw new Exception("param invalid");
                    break;
                 case SERVICE_PARAM_CALLABLE:
                    if (!is_callable($param[$k])) 
                        throw new Exception("param invalid");
                    break;
             }
        }
        return $param;
    }

    /**
     * 输出返回内容,所有的返回请调用return $this->output($data,$error);
     * @param $code
     * @param $data
     * @param $status
     * $param $msg
     * @return array
     */
    protected function output($status = false,$code,$data = "",$msg="")
    {
        $CI =& get_instance();
        $code = trim($code);
        if(($status==false&&empty($msg)||($code!=1000&&empty($msg)))){
            $info = $CI->config->item('error');
            $msg = $info['error'][$code];
        }
        $d = array(
            "success" => $status,
            "code" => intval($code),
            "data"=>$data,
            "msg" => $msg,
        );
        return $d;
    }
}
// END Service Class

/* End of file Service.php */
/* Location: ./application/core/MY_Service.php */