<?php
/**
 * Created by Microsoft VS Code.
 * User: MimuTao
 * Date: 2017/4/24
 * Time: 17:31
 */
defined('BASEPATH') or exit("No direct script access allowed");
class CommentPraise_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }
    public function is_praise($user_id,$comment_id){
        $query=$this->db->select('*')
                        ->from('commentpraise')
                        ->where('user_id',$user_id)
                        ->where('comment_id',$comment_id)
                        ->get();
        return !empty($query->row_array());
    }  
    public function Praise($user_id,$comment_id){
        $data=array(
            'user_id'=>$user_id,
            'acomment_id'=>$comment_id,
        );
        $this->db->insert('commentpraise',$data);
    }
    public function CancelPraise($user_id,$comment_id){
        $this->db->where('user_id',$user_id)
                 ->where('comment_id',$comment_id)
                 ->delete('commentpraise');
    }
    public function DeletePriseByCommentId($comment_id){
        $this->db->where('comment_id',$comment_id)
                 ->delete('commentpraise');
    }
}