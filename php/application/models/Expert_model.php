<?php
/**
 * Created by MS Visual Studio Code.
 * User: MimuTao
 * Date: 2017/5/3
 * Time: 9:31
 */
defined('BASEPATH') or exit("No direct script access allowed");
class Expert_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    } 

    /**
    * Function: bind user_id and exper_id
    * Beforeuse this function you need to verify wheather the user has been an expert.
    */
    public function AddExpert($user_id){
        $data=array(
            'user_id'=>$user_id,
        );  
        $this->db->insert('expert',$data);
    } 

    public function AddExpertWithInfo($user_id,$basic_info='',$expert_field=''){
        $data=array(
            'user_id'=>$user_id,
            'basic_info'=>$basic_info,
            'expert_field'=>$expert_field,
        );
        $this->db->insert('expert',$data);
    }
    //delete expert info by user_id or expert_id.
    public function DeleteExpert($user_id){
        $this->db->where('user_id',$user_id)
                 ->delete('expert');
    }

    // if expert exist return true,else return flase.
    public function is_exist($user_id){
        $ret=$this->db->select('*')
                      ->from('expert')
                      ->where('user_id',$user_id)
                      ->get()
                      ->row_array();
        return !empty($ret);
    }

    public function UpdateInfo($user_id,$basic_info='',$expert_field=''){
        $this->db->set('basic_info',$basic_info)
                 ->set('expert_field',$expert_field)
                 ->where('user_id',$user_id)
                 ->update('expert');
    }
    
    public function UpdateOnlineStatue($user_id,$online_statue){
        $this->db->set('online_statue',$online_statue)
                 ->where('user_id',$user_id)
                 ->update('expert');
    }

    public function UpdateRate($user_id,$rate_average){
        $this->db->set('rate_average',$rate_average)
                 ->where('user_id',$user_id)
                 ->update('expert');
    }

    public function UpdateConsultTimes($user_id){
        $temp=$this->db->select('consult_times')
                       ->from('expert')
                       ->where('user_id',$user_id)
                       ->get()
                       ->row_array();
        $consult_times=$temp['consult_times'];
        $this->db->set('consult_times',$consult_times)
                 ->where('user_id',$user_id)
                 ->update('expert');
    }

    public function GetExpertList(){
        $query=$this->db->select('*')
                        ->from('expert')
                        ->order_by('online_statue','DESC')
                        ->get();
        return $query->result_array();
    }

    public function GetInfoByUserId($user_id){
        $query=$this->db->select('*')
                        ->from('expert')
                        ->where('user_id',$user_id)
                        ->get();
        return $query->row_array();
    }

    

    //下面处理tags表  注意：这个表中的user_id也表示专家
    public function AddTag($user_id,$tag){
        $data=array(
            'user_id'=>$user_id,
            'tag'=>$tag,
        );
        $this->db->insert('tags',$data);
    }
    
    public function UpdateTag($tag_id,$tag){
        $this->db->set('tag',$tag)
                 ->where('tag_id',$tag_id)
                 ->update('tags');
    }

    public function DeleteTagByTagId($tag_id){
        $this->db->where('tag_id',$tag_id)
                 ->delete('tags');
    }
    //取得某个专家的全部标签
    public function GetTagList($user_id){
        $query=$this->db->select('*')
                    ->from('tags')
                    ->get();
        return $query->result_array();        
    }

    //下面处理rate表  其中user_id表示评分人，expert_id表示被评分人。
    public function AddRate($user_id,$expert_id,$rate,$date){
        $data=array(
            'user_id'=>$user_id,
            'expert_id'=>$expert_id,
            'rate'=>$rate,
            'date'=>$date,
        );
        $this->db->insert('rate',$data);
    }
    
    public function GetRateAverage($expert_id){
        $query=$this->db->select_avg('rate')
                        ->from('rate')
                        ->get()
                        ->row_array();
        return $query['rate'];
    }
    public function GetRateTimesInDate($user_id,$expert_id,$date){
        $query=$this->db->select('*')
                        ->from('rate')
                        ->where('user_id',$user_id)
                        ->where('expert_id',$expert_id)
                        ->where('date',$date)
                        ->get();
        return count($query->result_array());
    }

}