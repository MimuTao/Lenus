<?php
/**
 * Created by MS Visual Studio Code.
 * User: MimuTao
 * Date: 2017/4/19
 * Time: 15:31
 */
defined('BASEPATH') or exit("No direct script access allowed");
class UserTopic_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }  
    //取得usertopic表中的全部内容
    public function GetUserTopicInfo($user_id){
        $query=$this->db->select('*')
                        ->from('usertopic')
                        ->where('user_id',$user_id)
                        ->get();
        return $query->result_array();
    }
    //return对应user_id的全部topic_id
    public function GetTopicIdListByUserId($user_id){
        $query=$this->db->select('topic_id')
                        ->from('usertopic')
                        ->where('user_id',$user_id)
                        ->get();
        return $query->result_array();
    }


    //注意，在进行插入之前，请判断这个user_id是否是已经有了这个topic_id，在没有的情况下再进行插入
    public function AddUserTopic($user_id,$topic_id){
        $data=array(
            'user_id'=>$user_id,
            'topic_id'=>$topic_id,
        );
        $this->db->insert('usertopic',$data);
    }

    //当一个用户刚刚创建，没有UserTioic时候，我们会默认给设置几个UserTopic
    public function SetUserTopic($user_id){
        $topic1=array(
                'user_id'=>$user_id,
                'topic_id'=>10000,
        );
        $topic2= array(
                'user_id'=>$user_id,
                'topic_id'=>10001,
        );
        $topic3= array(
                'user_id'=>$user_id,
                'topic_id'=>10002,
        );
        $this->db->insert('usertopic',$topic1);
        $this->db->insert('usertopic',$topic2);
        $this->db->insert('usertopic',$topic3);
    }

    //判断user_id对应的topic_id是否存在，若存在那么久返回true，不然返回flase.
    public function is_exist($user_id,$topic_id){
        $query=$this->db->select('id')
                        ->from('usertopic')
                        ->where('user_id',$user_id)
                        ->where('topic_id',$topic_id)
                        ->get()
                        ->result_array();
        return !empty($query);    
    }
    public function is_exist_($usertopic_id){
        $query=$this->db->select('*')
                        ->from('usertopic')
                        ->get()
                        ->row_array();
        return !empty($query);
    }

    //根据usertopic表中的id来删除某个用户中某项
    public function DeleteUserTopic($usertopic_id){
        $this->db->where('id',$usertopic_id)
                 ->delete('usertopic');
    }
    public function DeleteUserTopic_($user_id,$topic_id){
        $this->db->where('user_id',$user_id)
                 ->where('topic_id',$topic_id)
                 ->delete('usertopic');
    }

}