<?php
/**
 * Created by Microsoft VS Code.
 * User: MimuTao
 * Date: 2017/4/24
 * Time: 16:45
 */
class Comment_service extends MY_Service
{
    //构造函数
    public function __construct()
    {
        parent::__construct();
        $this->load->model("comment_model");
        $this->load->model('subcomment_model');
        $this->load->model('commentpraise_model');
        $this->load->model('user_model');
        $this->load->model('article_model');
    }
    
    //Get CommentList  传入参数-> article_id
    public function GetCommentList($param){
        $param = $this->_check_param($param,array(SERVICE_PARAM_INT,SERVICE_PARAM_INT));
        $user_id_=$param[0];      //这个user_id是用户APP的id
        $article_id=$param[1];
        
        $commentList=$this->comment_model->GetCommentListByArticleId($article_id);
        $tempList=array();
        foreach ($commentList as $key=>$value) {    //添加评论用户名和头像 用户是否赞过
            $user_id=$value['user_id'];
            $user_info=$this->user_model->GetInfoById($user_id);
            $praised=$this->commentpraise_model->is_praise($user_id_,$value['comment_id']);
                if($praised==true)
                    $praised='Yes';
                else
                    $praised='No';
            //echo var_dump($user_info);exit;
            $tempList[$key]=$value;
            $tempList[$key]['user_head']=$user_info['head'];
            $tempList[$key]['user_name']=$user_info['user_name'];
            $tempList[$key]['is_praise']=$praised;
            
            $tempData=array(
                'comment_id'=>$value['comment_id'],
            );
            $subCommentList=$this->GetSubCommentList($tempData);
            $tempList[$key]['subCommentList']=$subCommentList;
        }
        return $this->output(true,1000,$tempList);
    }
    //Get subcomment  传入参数->comment_id
    public function GetSubCommentList($param){
        $param = $this->_check_param($param,array(SERVICE_PARAM_INT));
        $comment_id=$param[0];
        $subCommentList=$this->subcomment_model->GetSubCommentListByCommentId($comment_id);
        $tempList=array();
        foreach ($subCommentList as $key => $value) {
            $user_id=$value['user_id'];
            $user_info=$this->user_model->GetInfoById($user_id);
            $tempList[$key]=$value;
            $tempList[$key]['user_head']=$user_info['head'];
            $tempList[$key]['user_name']=$user_info['user_name'];
        }
        return $tempList;
    }
    //Addcomment: Input parameter-> user_id article_id comment_contents
    public function AddComment($param){
        $param=$param = $this->_check_param($param,array(SERVICE_PARAM_INT,SERVICE_PARAM_INT,SERVICE_PARAM_STRING));
        $user_id=$param[0];
        $article_id=$param[1];
        $comment_contents=$param[2];
        $time=time();
        $this->comment_model->AddComment($user_id,$article_id,$time,$comment_contents); //把评论加入
        $this->article_model->UpdateCommentCount($article_id);    //把article_model中的comment_count+1
        return $this->output(true,1000);
    }
    //AddSubcomment: Input parameter-> user_id comment_id subcomment_contents
    public function AddSubComment($param){
        $param=$param = $this->_check_param($param,array(SERVICE_PARAM_INT,SERVICE_PARAM_INT,SERVICE_PARAM_STRING));
        $user_id=$param[0];
        $comment_id=$param[1];
        $subcomment_contents=$param[2];
        $time=time();
        $this->subcomment_model->AddSubComment($user_id,$comment_id,$time,$subcomment_contents); //把子评论加入
        return $this->output(true,1000);
    }
    //删除评论 传入参数->comment_id  前端验证删除用户和APP用户是不是一致的
    public function DeleteComment($param){
        $param=$param = $this->_check_param($param,array(SERVICE_PARAM_INT));
        $comment_id=$param[0];

         ///当删除评论时，article中的评论数量-1
        $article_id=$this->comment_model->GetArticleId($comment_id);
        //echo $article_id;exit;
        $this->article_model->UpdateCommentCount_($article_id);    //把article_model中的comment_count-1
    
        $this->comment_model->DeleteCommentByCommentId($comment_id);  //删除comment中的info 置位flag
        $this->subcomment_model->DeleteSubComment($comment_id);    //删除子评论  
        $this->commentpraise_model->DeletePriseByCommentId($comment_id);//删除该评论对应的赞
        return $this->output(true,1000);
    }
    //删除子评论  传入参数-> subcomment_id  前端验证删除用户是否跟手机用户一致
    public function DeleteSubComment($param){
        $param=$param = $this->_check_param($param,array(SERVICE_PARAM_INT));
        $subcomment_id=$param[0];
        $this->subcomment_model->DeleteSubCommentBySubCommentId($subcomment_id);
        return $this->output(true,1000);
    }
    //praise the comment. 传入参数-> comment_id user_id flag(flag==1表示赞状态改变，flag==0表示赞状态不变)
    //先判断是否赞过，没有赞过就点赞，已经点赞则取消赞
    public function OnPraise($param){
        $param=$param = $this->_check_param($param,array(SERVICE_PARAM_INT,SERVICE_PARAM_INT,SERVICE_PARAM_INT));
        $user_id=$param[0];
        $comment_id=$param[1];
        $flag=$param[2];
        if($flag==1){
            if($this->commentpraise_model->is_praise($user_id,$comment_id)){   //若已经点赞，删除记录
                $this->commentpraise_model->CancelPraise($user_id,$comment_id);
                $this->comment_model->UpdateCommentCancelPraise($comment_id);  //comment_model中praise_count-1
            }
            else{                  //尚未点赞，添加纪录
                $this->commentpraise_model->Praise($user_id,$comment_id);
                $this->comment_model->UpdateCommentPraise($comment_id);     //comment_model中praise_count+1         
            }
        }
    }

    

}