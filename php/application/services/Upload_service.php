<?php
/**
 * Created by PhpStorm.
 * User: WJW
 * Date: 2016/4/13
 * Time: 21:13
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Upload_service extends MY_Service
{
    private $data = array();
    private $m_error = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library("upload");
        //$this->load->library("upload");
    }

    //上传单张图片
    public function upload_img()
    {
        $dir = date("Y_m", time());
        $file = date("Y_m_d", time());
        if (!file_exists(APPPATH . 'logs/' . $dir)) {
            mkdir(APPPATH . 'logs/' . $dir, 0755);
        }
        error_log(date("Y-m-d H:i:s", time()) . "     " . json_encode($_FILES) . chr(10), 3, APPPATH . "logs/" . $dir . "/upload_app_info_" . $file . ".php");
        error_log(date("Y-m-d H:i:s", time()) . "     " . json_encode($_POST) . chr(10), 3, APPPATH . "logs/" . $dir . "/upload_app_info_" . $file . ".php");


        $dir = date("Y_m_d",time());
        if(!file_exists(FCPATH.'upload/'.$dir))
        {
            mkdir(FCPATH.'upload/'.$dir,0755, true);
            error_log(date("Y-m-d H:i:s", time()) . "     " . 'upload is not exist' . chr(10), 3, APPPATH . "logs/" . $dir . "/upload_app_info_" . $file . ".php");
        }
        $config['upload_path']      = FCPATH.'upload/'.$dir;
        $config['allowed_types']    = 'jpg|png|jpeg';
        $config['max_size']     = 1024*5;//5M
        $config['file_ext_tolower'] = true;
        $config['detect_mime'] = true;
        $config['file_name'] = 'img'.time().img_rand(8);
        $this->upload->initialize($config);
        if ( ! $this->upload->do_upload('img'))
        {
            return $this->output(false, 1018,'',$this->upload->display_errors());
        }

        $name = $this->upload->data('file_name');
        $temp = $name;
        $action_path = "upload/".$dir."/".$name;
        $original = base_url($action_path);
        $compress_name = str_replace(".","_thum.",$temp);
        mkThumbnail(FCPATH."upload/".$dir."/".$name,60,null,FCPATH."upload/".$dir."/".$compress_name);
        $compress  =  base_url("upload/".$dir."/".$compress_name);
        $result = array(
            "original"=>$original,
            "compress"=>$compress
        );
        return $this->output(true, 1000,$result);
    }

    /**
     * 上传多图
     */
    public function upload_multi_img(){
        $dir = date("Y_m", time());
        $file = date("Y_m_d", time());
        if (!file_exists(APPPATH . 'logs/' . $dir)) {
            mkdir(APPPATH . 'logs/' . $dir, 0755);
        }
        error_log(date("Y-m-d H:i:s", time()) . "     " . json_encode($_FILES) . chr(10), 3, APPPATH . "logs/" . $dir . "/pc_upload_info_" . $file . ".php");


        $dir = date("Y_m_d",time());

        if(!file_exists(FCPATH.'upload/'.$dir)){
            mkdir(FCPATH.'upload/'.$dir,0755,true);
        }

        $config['upload_path'] = FCPATH.'upload/'.$dir;
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size']     = 1024*5;//5M
        $config['file_ext_tolower'] = true;
        $config['detect_mime'] = true;
        multifile_array();
        $data = array();
        $i=0;
        foreach ($_FILES as $file => $file_data) {
            $config['file_name'] = 'img'.time().img_rand(8);
            $this->upload->initialize($config);
            if (!$upload = $this->upload->do_upload($file))
            {
                $error = array('error' => $this->upload->display_errors());
                return $this->output(false,1018,'',$error);
            }
            else{
                $name = $this->upload->data('file_name');
                $temp = $name;
                $action_path = "upload/".$dir."/".$name;
                $original = base_url($action_path);
                $data['list'][$i]['original'] = $original;
                $compress_name = str_replace(".","_thum.",$temp);
                mkThumbnail(FCPATH."upload/".$dir."/".$name,60,null,FCPATH."upload/".$dir."/".$compress_name);
                $compress  =  base_url("upload/".$dir."/".$compress_name);
                $data['list'][$i]['compress'] = $compress;
                $i++;
            }
        }
        return $this->output(true,1000,$data,"上传成功");
    }
}