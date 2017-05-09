<?php
/**
 * Created by MS Visual Studio Code.
 * User: MimuTao
 * Date: 2017/4/19
 * Time: 14:31
 */
defined('BASEPATH') or exit("No direct script access allowed");
class Collect_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }  
    public function GetCollectList($user_id){
        $query=$this->db->select('*')
                    ->from('collect')
                    ->where('user_id',$user_id)
                    ->get();
        return $query->result_array();
    }
    //判断用户是否收藏文章
    public  function is_exist($user_id,$article_id){
        $query=$this->db->select('*')
                        ->from('collect')
                        ->where('user_id',$user_id)
                        ->where('article_id',$article_id)
                        ->get();
        return !empty($query->row_array());
    }
    public function AddUserCollect($user_id,$article_id){
        $data=array(
            'user_id'=>$user_id,
            'article_id'=>$article_id,
        );
        $this->db->insert('collect',$data);
    }
    public function DeleteUserCollectByCollectId($collect_id){
        $this->db->where('collect_id',$collect_id)
                 ->delete('collect');
    }
    public function DeleteUserCollect($user_id,$article_id){
        $this->db->where('user_id',$user_id)
                 ->where('article_id',$article_id)
                 ->delete('collect');
    }
    
}