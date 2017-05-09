<?php
/**
 * Created by PhpStorm.
 * User: MimuTao
 * Date: 2017/4/24
 * Time: 11:07
 */
class Topic_service extends MY_Service
{
    //构造函数
    public function __construct()
    {
        parent::__construct();
        $this->load->model("topic_model");
        $this->load->model('usertopic_model');
    }

    public function GetTopicList(){
        $list=$this->topic_model->GetTopicInfo();
        $data['list']=$list;
        return $this->output(true,1000,$data);
    }

    public function GetUserTopicList($user_id){
       $userTopicList=$this->usertopic_model->GetUserTopicInfo($user_id);
       if(empty($userTopicList)){                                      //Judge whether is empty, is true setuserTopic,else GetuserTopicList.
           $this->usertopic_model->SetUserTopic($user_id);
       }
       else{
           return $this->output(true,1000,$userTopicList);
       }
    }

    //下面会有些不一样，先写方案A，每次更变一次。参数：user_id topic_id 
    public function AddUserTopic($param){
        $param = $this->_check_param($param,array(SERVICE_PARAM_INT,SERVICE_PARAM_INT));
        $user_id = $param[0];
        $topic_id = $param[1];
        if($this->usertopic_model->is_exist($user_id,$topic_id)){
            return $this->output(false,1008,'','You have add this topic, an error might happend.');
        }
        else{
            $this->usertopic_model->AddUserTopic($user_id,$topic_id);
            return $this->output(true,1000,'');
        }
    }
    //下面写usertopic删除，先是A方案，通过usertopic_id删除
    public function DeleteUserTopic($param){
        $param = $this->_check_param($param,array(SERVICE_PARAM_INT));
        $usertopic_id=$param[0];
        if($this->usertopic_model->is_exist_($usertopic_id)){
            $this->usertopic_model->DeleteUserTopic($usertopic_id);
            return $this->output(true,1000,'');
        }
        else{
            return $this->output(true,1008,'',"Delete the data success." );
        }
    }
    public function DeleteUserTopic_($param){     //this is the plane B.
        $param = $this->_check_param($param,array(SERVICE_PARAM_INT,SERVICE_PARAM_INT));
        $user_id = $param[0];
        $topic_id = $param[1];
        if($this->usertopic_model->is_exist($user_id,$topic_id)){   //if has this record, then we can delete the record.  if don't exist,then trere is an error.
             $this->usertopic_model->DeleteUserTopic_($user_id,$topic_id);
             return $this->output(true,1000,'',"Delete the data success." );
        }
        else{
            return $this->output(false,1008,'',"There is no such topic, so you can't delete it." );
        }
    }
   
}