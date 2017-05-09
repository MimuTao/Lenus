<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Api 接口相关
 */
class PcApi extends Base_Controller
{


    public function __construct() {
        parent::__construct();
    }

    /**
     * app接口入口
     *
     */
    public function index() {
        $temp = $_GET;;
        $temp1 = $_POST;
        $data = empty($temp) ? $temp1 : $temp;//接收数组参数
        $dir = date("Y_m", time());
        $file = date("Y_m_d", time());
        if (!file_exists(APPPATH . 'logs/' . $dir)) {
            mkdir(APPPATH . 'logs/' . $dir, 0755);
        }
        header( 'Access-Control-Allow-Origin:http://localhost:8080' );
        header("Access-Control-Allow-Credentials: true");
        //$_SESSION['user_id'] = 100039;
        /*if(isset($_SESSION['user_id']))
        {
            $data['user_id'] = $_SESSION['user_id'];
        }*/
        //$_SESSION['user_id'] = $data['user_id'];
        //error_log(date("Y-m-d H:i:s", time()) . "     " . empty($_SESSION['user_id'])?intval($_SESSION['user_id']):0 . chr(10), 3, APPPATH . "logs/" . $dir . "/pc_session_" . $file . ".php");
        error_log(date("Y-m-d H:i:s", time()) . "     " . json_encode($_SESSION) . chr(10), 3, APPPATH . "logs/" . $dir . "/pc_session_" . $file . ".php");
        error_log(date("Y-m-d H:i:s", time()) . "     " . json_encode($data) . chr(10), 3, APPPATH . "logs/" . $dir . "/pc_input_" . $file . ".php");

        if (empty($data)) {
            showresult(false, 1005, "");
        }
        $this->load->service("PcApi_service");
        $result = $this->PcApi_service->run($data);
    }
}