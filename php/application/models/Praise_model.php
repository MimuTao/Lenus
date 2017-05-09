<?php
/**
 * Created by Microsoft VS Code.
 * User: MimuTao
 * Date: 2017/4/21
 * Time: 17:31
 */
defined('BASEPATH') or exit("No direct script access allowed");
class Praise_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }  
    public function GetPraiseList($article_id){
        $query=$this->db->select('*')
                        ->from('praise')
                        ->get();
        return $query->result_array();
    }
    //Use This function to judge whether the user has praise this article.
    public function is_exist($user_id,$article_id){
        $query=$this->db->select('*')
                        ->from('praise')
                        ->where('user_id',$user_id)
                        ->where('article_id',$article_id)
                        ->get()
                        ->row_array();
        return !empty($query);
    }
    //Use this function to let user cancel praise the article, you should use "GetPraiseId" function to judge whether has praised before use it.
    public function CancelPraise($user_id,$article_id){
        $this->db->where('user_id',$user_id)
                 ->where('article_id',$article_id)
                 ->delete('praise');                
    }
    //You can use this function to let user praise the article.Before use if, you should judge weather the user has praise that article.
    public function Praise($user_id,$article_id){
        $data=array(
            'user_id'=>$user_id,
            'article_id'=>$article_id,
        );
        $this->db->insert('praise',$data);
    }
}