<?php
/**
 * Created by MS Visual Studio Code.
 * User: MimuTao
 * Date: 2017/4/19
 * Time: 15:31
 */
defined('BASEPATH') or exit("No direct script access allowed");
class SubComment_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }  
    //得到对应comment_id评论的全部内容
    public function GetSubCommentListByCommentId($comment_id){
        $query=$this->db->select('*')
                        ->from('subcomment')
                        ->where('comment_id',$comment_id)
                        ->order_by('time','ASC')
                        ->get();
        return $query->result_array();
    }
    //对comment_id对应的平稳插入一则子评论，包括评论人，评论时间和内容
    public function AddSubComment($user_id,$comment_id,$time,$subcomment_contents){
        $data=array(
            'user_id'=>$user_id,
            'comment_id'=>$comment_id,
            'time'=>$time,
            'subcomment_contents'=>$subcomment_contents,
        );
        $this->db->insert('subcomment',$data);
    }
    //当删除评论时，把子评论也删除//设置flag=1
    public function DeleteSubComment($comment_id){
        $this->db->where('comment_id',$comment_id)
                 ->delete('subcomment');
    }
    public function DeleteSubCommentBySubCommentId($subcomment_id){
        $this->db->where('subcomment_id',$subcomment_id)
                 ->delete('subcomment');
    }


}