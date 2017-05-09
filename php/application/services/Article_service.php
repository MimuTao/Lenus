<?php
/**
 * Created by Microsoft VS Code.
 * User: MimuTao
 * Date: 2017/4/24
 * Time: 14:25
 */
class Article_service extends MY_Service
{
    //构造函数
    public function __construct()
    {
        parent::__construct();
        $this->load->model("article_model");
        $this->load->model('praise_model');
        $this->load->model('collect_model');
    }
    
    //return articleidlist  传入参数->topic_id
    public function GetArticleList($param){
        $param = $this->_check_param($param,array(SERVICE_PARAM_INT));
        $topic_id=$param[0];
        //$articlIdList=$this->article_model->GetArticleIdByTopicId($topic_id);
        $articlIdList=$this->article_model->GetArticleInfoByTopicId($topic_id); 
        return $this->output(true,1000,$articlIdList);
    }

    public function GetArticleInfo($param){
        $param = $this->_check_param($param,array(SERVICE_PARAM_INT,SERVICE_PARAM_INT));
        $user_id=$param[0];
        $article_id=$param[1];
        $this->article_model->UpdateView($article_id);   //详细信息的时候（也就是看文章详情时，把article_model 中的view_count+1
        $articleInfo=$this->article_model->GetInfoByArticleId($article_id);
        $is_collect=$this->collect_model->is_exist($user_id,$article_id);
        if($is_collect==true)
            $is_collect='Yes';
        else 
            $is_collect='No';
        $articleInfo['is_collect']=$is_collect;

        $is_praise=$this->praise_model->is_exist($user_id,$article_id);
        if($is_praise==true)
            $is_praise='Yes';
        else 
            $is_praise='No';
        $articleInfo['is_praise']=$is_praise;
        return $this->output(true,1000,$articleInfo);
    }
    //当点赞时，传入参数 user_id article_id  flag(flag==1表示改变赞状态，flag==0表示赞状态不改变)
    //先判断是不是赞过，没有赞过再点赞，若已经点赞，则取消赞
    public function OnPraise($param){
        $param=$this->_check_param($param,array(SERVICE_PARAM_INT,SERVICE_PARAM_INT,SERVICE_PARAM_INT));
        $user_id=$param[0];
        $article_id=$param[1];
        $flag=$param[2];
        if($flag==1){
            if(empty($this->praise_model->GetPraiseId($user_id,$article_id))){
                $this->praise_model->Praise($user_id,$article_id);   //praise_model中添加praise记录
                $this->article_model->UpdateUserPraise($article_id);   //article_model中praise_count+1  
                return $this->output(true,1000,'','praise'); 
            }
            else{
                $this->praise_model->CancelPraise($user_id,$article_id);  //praise_model中删除praise记录
                $this->article_model->UpdateUserCancelPraise($article_id);   //article_model中praise_count-1 
                return $this->output(true,1000,'','cancel praise'); 
            }
        }
    }

    //collect Article 输入参数->$user_id,article_id,flag(flag==1表示收藏状态改变，flag==0表示收藏状态不变)
    public function OnCollect($param){
        $param=$this->_check_param($param,array(SERVICE_PARAM_INT,SERVICE_PARAM_INT,SERVICE_PARAM_INT));
        $user_id=$param[0];
        $article_id=$param[1];
        $flag=$param[2];
        if($flag==1){
            if($this->collect_model->is_exist($user_id,$article_id)){
                $this->collect_model->DeleteUserCollect($user_id,$article_id);
                return $this->output(true,1000,'','取消收藏成功');
            }
            else{
                $this->collect_model->AddUserCollect($user_id,$article_id);
                return $this->output(true,1000,'','收藏成功');
            }
        }
    }
    //获得收藏文章列表 传入参数-> user_id
    public function GetUserCollectList($param){
        $param=$this->_check_param($param,array(SERVICE_PARAM_INT));
        $user_id=$param[0];
        $collectList=$this->collect_model->GetCollectList($user_id);
        $tempList=array();
        foreach ($collectList as $key=>$value) {
           $article_id=$value['article_id'];
           $articleInfo=$this->article_model->GetInfoByArticleId($article_id);
           $tempList[$key]=$value;
           $tempList[$key]['article_info']=$articleInfo;
        }
        return $this->output(true,1000,$tempList); 
    }
}