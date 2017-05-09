<?php
/**
 * Created by Microsoft VS Code.
 * User: MimuTao
 * Date: 2017/5/4
 * Time: 16:45
 */
class Expert_service extends MY_Service
{
    //构造函数
    public function __construct()
    {
        parent::__construct();
        $this->load->model("user_model");
        $this->load->model('expert_model');
    }
    
    //Set the user as an expert But have no information.
    public function AddExpert($param){
        $param = $this->_check_param($param,array(SERVICE_PARAM_INT));
        $user_id=$param[0];      //  Set the user as an expert.
        
        $is_expert_exist=$this->expert_model->is_exist($user_id);
        if($is_expert_exist==true){
            return $this->output(false,1055,'','You have set this user as expert.');   //if has been an expert return false.
        }
        else{
            $this->expert_model->AddExpert($user_id);
            return $this->output(true,1000);
        }
    }
    
    //Set the user as an expert With information. Input: user_id basic_info expert_field.
    public function AddExpertWithInfo($param){
        $param = $this->_check_param($param,array(SERVICE_PARAM_INT,SERVICE_PARAM_STRING,SERVICE_PARAM_STRING));
        $user_id=$param[0];      //  Set the user as an expert.
        $basic_info=$param[1];
        $expert_field=$param[2];
        
        $is_expert_exist=$this->expert_model->is_exist($user_id);
        if($is_expert_exist==true){
            return $this->output(false,1055,'','You have set this user as expert.');   //if has been an expert return false.
        }
        else{
            $this->expert_model->AddExpertWithInfo($user_id,$basic_info,$expert_field);
            return $this->output(true,1000);
        }
    }
    
    //Input： user_id->(The expert's id')
    public function DeleteExpert($param){
        $param = $this->_check_param($param,array(SERVICE_PARAM_INT));
        $user_id=$param[0];
        $is_expert_exist=$this->expert_model->is_exist($user_id);
        if($is_expert_exist==true){
            $this->expert_model->DeleteExpert($user_id);
            return $this->output(false,1000);   //if has this expert.
        }
        else{
            return $this->output(false,1055,'','There is no such expert, please check it agein.');   //if no such expert.
        }     
    }
    
    //Set the online statue of expert. Input: user_id online_statue
    public function SetOnlineStatue($param){
        $param = $this->_check_param($param,array(SERVICE_PARAM_INT,SERVICE_PARAM_INT));
        $user_id=$param[0];
        $online_statue=$param[1];
        
        $this->expert_model->UpdateOnlineStatue($user_id,$online_statue);
        return $this->output(true,1000);
    }
    
    //ReSet the expert's information. Input: user_id basic_info expert_field.
    public function SetExpertInfo($param){
        $param = $this->_check_param($param,array(SERVICE_PARAM_INT,SERVICE_PARAM_STRING,SERVICE_PARAM_STRING));
        $user_id=$param[0];      //  Set the user as an expert.
        $basic_info=$param[1];
        $expert_field=$param[2];
        $is_expert_exist=$this->expert_model->is_exist($user_id);
        if($is_expert_exist==true){
            $this->expert_model->UpdateInfo($user_id,$basic_info,$expert_field);
            return $this->output(true,1000);   //if has been and set info successed
        }
        else{
            return $this->output(false,1055,'','There is no such expert, please check it agein.');   //if no such expert.
        }
    }

    public function UpdateConsultTimes($param){
        $param = $this->_check_param($param,array(SERVICE_PARAM_INT));
        $user_id=$param[0];
        $is_expert_exist=$this->expert_model->is_exist($user_id);
        if($is_expert_exist==true){
            $this->expert_model->UpdateConsultTimes($user_id);
            return $this->output(true,1000);   //if has been and set info successed
        }
        else{
            return $this->output(false,1055,'','There is no such expert, please check it agein.');   //if no such expert.
        }
    }

    public function GetExpertList(){
        $temp=$this->expert_model->GetExpertList();
        $ret=array();
        foreach ($temp as $key => $value) {
            $user_id=$value['user_id'];
            $user_info=$this->user_model->GetInfoById($user_id);
            $tags=$this->expert_model->GetTagList($user_id);
            $user_head=$user_info['head'];
            $user_name=$user_info['user_name'];
            $ret[$key]=$value;
            $ret[$key]['user_name']=$user_name;
            $ret[$key]['user_head']=$user_head;
            $ret[$key]['tags']=$tags;
        }
        return $this->output(true,1000,$ret);       
    }

    public function GetExpertInfo($param){
        $param = $this->_check_param($param,array(SERVICE_PARAM_INT));
        $user_id=$param[0];
        $is_expert_exist=$this->expert_model->is_exist($user_id);
        if($is_expert_exist==true){
            $user_info=$this->user_model->GetInfoById($user_id);
            $user_head=$user_info['head'];
            $user_name=$user_info['user_name'];
            $user_info=$this->expert_model->GetInfoByUserId($user_id);
            $tags=$this->$this->expert_model->GetTagList($user_id);
            $user_info['head']=$user_head;
            $user_info['name']=$user_name;
            $user_info['tags']=$tags;
            return $this->output(true,1000,$user_info);   //if has been and set info successed
        }
        else{
            return $this->output(false,1055,'','There is no such expert, please check it agein.');   //if no such expert.
        }
    }
    
    public function AddRate($param){
        $param = $this->_check_param($param,array(SERVICE_PARAM_INT,SERVICE_PARAM_INT,SERVICE_PARAM_INT));
        $user_id=$param[0];
        $expert_id=$param[1];
        $rate=$param[2];
        $date=date('Y-m-d');
        $is_expert_exist=$this->expert_model->is_exist($expert_id);
        if($is_expert_exist==true){
            $rateTimes=$this->expert_model->GetRateTimesInDate($user_id,$expert_id,$date);
            if($rateTimes<3){
                $this->expert_model->AddRate($user_id,$expert_id,$rate,$date);
                $rate_average=$this->expert_model->GetRateAverage($expert_id);
                $this->expert_model->UpdateRate($expert_id,$rate_average);
                return $this->output(true,1000);   //
            }
            else{
                return $this->output(false,1055,'','Rates whthin today are more than 3th.');   //if no such expert.
            }
        }
        else{
            return $this->output(false,1055,'','There is no such expert, please check it agein.');   //if no such expert.
        }
    }

}