<?php
/**
 * Created by MS Visual Studio Code.
 * User: MimuTao
 * Date: 2017/4/19
 * Time: 15:31
 */
defined('BASEPATH') or exit("No direct script access allowed");
class Comment_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }  
    //得到对应article_id文章的全部内容
    public function GetCommentListByArticleId($article_id){
        $query=$this->db->select('*')
                        ->from('comment')
                        ->where('article_id',$article_id)
                        ->order_by('time','ASC')
                        ->get();
        return $query->result_array();
    }
    public function GetArticleId($comment_id){
        $query=$this->db->select('article_id')
                        ->from('comment')
                        ->where('comment_id',$comment_id)
                        ->get()
                        ->row_array();
                        
        return $query['article_id'];
    }
    //对article_id对应的文章插入一则评论，包括评论人，评论时间和内容
    public function AddComment($user_id,$article_id,$time,$comment_contents){
        $data=array(
            'user_id'=>$user_id,
            'article_id'=>$article_id,
            'time'=>$time,
            'comment_contents'=>$comment_contents,
        );
        $this->db->insert('comment',$data);
    }

    public function UpdateCommentPraise($comment_id){
        $temp=$this->db->select('comment_praise_count')
                        ->from('comment')
                        ->where('comment_id',$comment_id)
                        ->get()
                        ->row_array();
        $this->db->set('comment_praise_count',++$temp['comment_praise_count'])
                 ->where('comment_id',$comment_id)
                 ->update('comment');
    }
    public function UpdateCommentCancelPraise($comment_id){
        $temp=$this->db->select('comment_praise_count')
                        ->from('comment')
                        ->where('comment_id',$comment_id)
                        ->get()
                        ->row_array();
        $this->db->set('comment_praise_count',--$temp['comment_praise_count'])
                 ->where('comment_id',$comment_id)
                 ->update('comment');
    }
    public function DeleteCommentByCommentId($comment_id){
        $this->db->where('comment_id',$comment_id)
                 ->delete('comment');
    }


}