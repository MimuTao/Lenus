<?php

/**
 * Created by PhpStorm.
 * User: sbwdlihao
 * Date: 6/19/15
 * Time: 11:44 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

Class Base_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper("common");
        $this->load->helper("url");
        $this->load->helper('language');
        $this->load->helper('form');
        $this->load->database();
        $session_config = array(
            'sess_expiration' => 7200 // 保存 2小时
        );
        header("Access-Control-Allow-Origin:*");
        require_once(APPPATH."third_party/upyunRefresh.class.php");
        $this->load->library('session', $session_config);
        $this->session->set_userdata('last_visit', time());
        $this->config->load('error', TRUE);
        $this->load->library("SqlHelper");
    }
}
Class Front_Controller extends Base_Controller {
    protected $_user_id;
    public function __construct()
    {
        parent::__construct();
        $this->_user_id = intval($this->session->userdata('user_id'));
        if($this->_user_id<=0){
            redirect("http://www.queqiaozl.com/#/login");
        }
    }


    /**
     * Ajax返回接口
     * @param  [array]  $data           [数据]
     * @param  boolean $boolean_success [是否成功]
     * @param  string  $msg             [错误消息]
     * @return                          [json]
     */
    public function ajax_result($data,$boolean_success=true,$msg=""){
        if($boolean_success == false){
            $data = "";
        }
        $res = array(
            "data"    => $data, 
            "success" => $boolean_success,
            "msg"     => $msg
            );
        return json_encode($res);
    }

}
Class Ajax_Controller extends Base_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    }

}
Class Admin_Controller extends Base_Controller {

    public function __construct() {
        parent::__construct();
        $manager_id = intval($this->session->userdata('manager_id'));
        if($manager_id<=0){
            redirect("admin/login");
        }
    }

    public function tpl($view, $data = array(), $config = NULL) {
        $viewData = $data;
        $viewData['controller'] = strtolower($this->router->class);
        $viewData['action'] = strtolower($this->router->method);
        $view_names = array(
            'sheader'=>array('value'=>'admin/template/sheader','turn_on'=>TRUE),
            'header'=>array('value'=>'admin/template/header','turn_on'=>TRUE),
            'view'=>array('value'=>$view,'turn_on'=>TRUE),
            'sfooter'=>array('value'=>'admin/template/sfooter','turn_on'=>TRUE),
            'footer'=>array('value'=>'admin/template/footer','turn_on'=>TRUE),
            'left' =>array('value'=>'admin/template/left','turn_on'=>TRUE)
        );
        if(is_array($config) && !empty($config)) $view_names = $config + $view_names;
        foreach ($view_names as $key=>&$val) {
            if($key!="view" && $val['turn_on']) $viewData[$key] = $this->load->view($val['value'], $viewData, TRUE);
        }
        $this->load->view("admin/".$view_names['view']['value'], $viewData);
    }

}
Class Html_Controller extends Base_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function tpl($view, $data = array(), $config = NULL) {
        $viewData = $data;
        $viewData['controller'] = strtolower($this->router->class);
        $viewData['action'] = strtolower($this->router->method);
        $view_names = array(
            'sheader'=>array('value'=>'html/template/sheader','turn_on'=>TRUE),
            'header'=>array('value'=>'html/template/header','turn_on'=>TRUE),
            'view'=>array('value'=>$view,'turn_on'=>TRUE),
            'sfooter'=>array('value'=>'html/template/sfooter','turn_on'=>TRUE),
            'footer'=>array('value'=>'html/template/footer','turn_on'=>TRUE)
        );
        if(is_array($config) && !empty($config)) $view_names = $config + $view_names;
        foreach ($view_names as $key=>&$val) {
            if($key!="view" && $val['turn_on']) $viewData[$key] = $this->load->view($val['value'], $viewData, TRUE);
        }
        $this->load->view("html/".$view_names['view']['value'], $viewData);
    }
}
Class HtmlAjax_Controller extends Base_Controller {

    public function __construct() {
        parent::__construct();
    }
}