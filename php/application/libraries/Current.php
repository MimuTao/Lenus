<?php
class Current{
    private $ci;
    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model("Using_cal_model");
        $this->ci->load->model("Current_model");
    }
    public function run(){
        $effective_time = time()-60*60*48;//有效时间，要大于这个时间点.48小时内收听算有效
        $cal_list = $this->ci->Using_cal_model->get_effective_list($effective_time);
        foreach($cal_list as $v){
            $info = $this->ci->Current_model->info($v['for_id'],$v['user_id'],$v['type']);
            if(empty($info)){
                $this->ci->Current_model->add($v['for_id'],$v['user_id'],time(),$v['type']);
            }
            else{
                $this->ci->Current_model->update($v['for_id'],$v['user_id'],time(),$v['type']);
            }
        }
        $update_time = time()-60*60*1;
        $this->ci->Current_model->del($update_time);
    }
}
