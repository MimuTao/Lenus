<?php

class Discover {
    private $ci;
    public function __construct() {
        $this->ci = &get_instance();
        $this->ci->load->model("Happiness_model");
        $this->ci->load->model("Activity_model");
        $this->ci->load->model("User_video_model");
        $this->ci->load->model("Official_video_model");
        $this->ci->load->model("Discover_model");
    }
    public function run(){//discover数据库需要插入4条for_id初始为0的数据即可
        $list = $this->ci->Discover_model->get_latest_list();//得到最新的4条不同类型的记录

        foreach($list as  $v){
            $for_id = $v['for_id'];
            if($v['type']=="happiness"){
                $newest_list = $this->ci->Happiness_model->get_newest_list($for_id);
                foreach($newest_list as $v){
                    $this->ci->Discover_model->add($v['id'],"happiness",$v['time']);
                }
            }
            elseif($v['type']=="user_video"){
                $newest_list = $this->ci->User_video_model->get_newest_list($for_id);
                foreach($newest_list as $v){
                    $this->ci->Discover_model->add($v['id'],"user_video",$v['time']);
                }
            }
            elseif($v['type']=="official_video"){
                $newest_list = $this->ci->Official_video_model->get_newest_list($for_id);
                foreach($newest_list as $v){
                    $this->ci->Discover_model->add($v['id'],"official_video",$v['time']);
                }
            }
            elseif($v['type']=="activity"){
                $newest_list =$this->ci->Activity_model->get_newest_list($for_id);
                foreach($newest_list as $v){
                    $this->ci->Discover_model->add($v['id'],"activity",$v['time']);
                }
            }
        }
    }
}