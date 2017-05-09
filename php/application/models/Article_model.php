<?php
/**
 * Created by MS Visual Studio Code.
 * User: MimuTao
 * Date: 2017/4/19
 * Time: 14:31
 */
defined('BASEPATH') or exit("No direct script access allowed");
class Article_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }  
    
    //根据topic_id取得全部的arctile
    public function GetArticleInfoByTopicId($topic_id){
        $query=$this->db->select('*')
                    ->where('topic_id',$topic_id)
                    ->from('article')
                    ->get();
        return $query->result_array();
    }
    public function GetArticleIdByTopicId($topic_id){
        $query=$this->db->select('article_id')
                        ->from('article')
                        ->where('topic_id',$topic_id)
                        ->get();
        return $query->result_array();
    }
    //根据article_id获得全部的信息
    public function GetInfoByArticleId($article_id){
        $query=$this->db->select('*')
                        ->from('article')
                        ->where('article_id',$article_id)
                        ->get();
        return $query->row_array();
    }
    //获取文章作者
    public function GetArticleAuthorByArticleId($article_id){
        $query=$this->db->select('article_author')
                        ->from('article')
                        ->where('article_id',$article_id)
                        ->get()
                        ->row_array();
        return $query['article_author'];    
    }

    //下面是用户赞文章和取消赞
    public function UpdateUserPraise($article_id){
        $temp=$this->db->select('praise_count')
                        ->from('article')
                        ->where('article_id',$article_id)
                        ->get()
                        ->row_array();
        $this->db->set('praise_count',++$temp['praise_count'])
                 ->where('article_id',$article_id)
                 ->update('article');
    }
    public function UpdateUserCancelPraise($article_id){
        $temp=$this->db->select('praise_count')
                        ->from('article')
                        ->where('article_id',$article_id)
                        ->get()
                        ->row_array();
        $this->db->set('praise_count',--$temp['praise_count'])
                 ->where('article_id',$article_id)
                 ->update('article');
    }
    //添加评论时候praise_count+1
    public function UpdateCommentCount($article_id){
        $temp=$this->db->select('comment_count')
                        ->from('article')
                        ->where('article_id',$article_id)
                        ->get()
                        ->row_array();
        $this->db->set('comment_count',++$temp['comment_count'])
                 ->where('article_id',$article_id)
                 ->update('article');
    }
    public function UpdateCommentCount_($article_id){
        $temp=$this->db->select('comment_count')
                        ->from('article')
                        ->where('article_id',$article_id)
                        ->get()
                        ->row_array();
        $this->db->set('comment_count',--$temp['comment_count'])
                 ->where('article_id',$article_id)
                 ->update('article');
    }
    //下面是当观看文章时候更新观看数量
    public function UpdateView($article_id){
        $temp=$this->db->select('view_count')
                             ->from('article')
                             ->where('article_id',$article_id)
                             ->get()
                             ->row_array();
        $this->db->set('view_count',++$temp['view_count'])
                 ->where('article_id',$article_id)
                 ->update('article');
    }
}