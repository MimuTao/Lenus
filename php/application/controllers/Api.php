<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Api 接口相关
 */
class Api extends Base_Controller
{


    public function __construct() {
        parent::__construct();
        $this->load->helper('common');
    }

    /**
     * app接口入口
     *
     */
   public function index() {
        $temp = trim($this->input->post("data"));
        $temp1 = trim($this->input->get("data"));
        $encrypt_str = empty($temp) ? $temp1 : $temp;

        //$encrypt_str = trim($this->input->post("data"));

        $dir = date("Y_m", time());
        $file = date("Y_m_d", time());
        if (!file_exists(APPPATH . 'logs/' . $dir)) {
            mkdir(APPPATH . 'logs/' . $dir, 0755);
        }
        error_log(date("Y-m-d H:i:s", time()) . "     " . get_page_url() . chr(10), 3, APPPATH . "logs/" . $dir . "/post_info_" . $file . ".php");
        error_log(date("Y-m-d H:i:s", time()) . "     " .json_encode($_POST)  . chr(10), 3, APPPATH . "logs/" . $dir . "/post_info_2_" . $file . ".php");
        error_log(date("Y-m-d H:i:s", time()) . "     " . $encrypt_str . chr(10), 3, APPPATH . "logs/" . $dir . "/input_" . $file . ".php");
        if ($encrypt_str == "") {
            showresult(false, 1005, "");
        }
        $this->load->service("Api_service");
        $result = $this->Api_service->run(array($encrypt_str));
    }



}