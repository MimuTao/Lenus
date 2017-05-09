<?php
/**
 * Created by MS Visual Studio Code.
 * User: MimuTao
 * Date: 2017/4/19
 * Time: 15:31
 */
defined('BASEPATH') or exit("No direct script access allowed");
class Topic_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }  
    //得到全部的topic主题
    public function  GetTopicInfo(){
        $query=$this->db->select('*')
                    ->from('topic')
                    ->get();
        return $query->result_array();
       
    }   
    public function  GetTopicName($topic_id){
        $query=$this->db->select('topic_name')
                    ->from('topic')
                    ->get()
                    ->row_array();
        return $query['topic_name'];
       
    }  
    //插入topic主题   
    public function AddTopic($topic_name){
        $data=array('topic_name'=>$topic_name,);
        $this->db->insert('topic',$data);
    }
    //删除话题
    public function DeleteTopicByTopicId($topic_id){
        $this->db->where('topic_id',$topic_id)
                 ->delete('topic');
    }
    

}