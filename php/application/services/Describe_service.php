<?php
/**
 * Created by PhpStorm.
 * User: wa
 * Date: 2017/3/21
 * Time: 22:58
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Describe_service extends MY_Service
{
    //构造方法
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Describe_model");  
        $this->load->model("Snp_model");
        $this->load->model("Result_model");
    }
    // 获得特征详情 特征详情页面
    public function GetInfo($param){
        $param = $this->_check_param($param,array(SERVICE_PARAM_INT,SERVICE_PARAM_STRING,SERVICE_PARAM_INT));
        $user_id = $param[0];
        $code = $param[1];        //疾病或者特征或者用药的code
        $check_id = $param[2];

        if($check_id!=0){
            $user_id = $check_id;
        }

        $resInfo = $this->Result_model->GetInfoByCodeUserId($code,$user_id);  //在result表中查询信息，检测用户检测结果是否存在
        if(empty($resInfo)){
            $data['info']['des'] = "未检测";
            $resId = 0;
        }else if(!empty($resInfo['score'])){
            $data['info']['des'] = $resInfo['score'];
            $resId = $resInfo['id'];
        }else if(!empty($resInfo['has'])){     
            if($resInfo['type']=="drug"){          //判断是否是用药
                if($resInfo['has']=="Yes"){
                    $data['info']['des'] = "谨慎使用";
                }
                else if($resInfo['has']=="No"){
                    $data['info']['des'] = "正常使用";
                }
                else{
                    $data['info']['des'] = "未检测";     //NA表示没有检测
                }
            }else{
                if($resInfo['has']=="Yes"){         // 倘若不是用药，那么表示是疾病
                    $data['info']['des'] = "携带";
                }
                else if($resInfo['has']=="No"){
                    $data['info']['des'] = "未携带";
                }
                else{
                    $data['info']['des'] = "未检测";   // NA表示没有检测
                }
            }
            $resId = $resInfo['id'];
        }else if(!empty($resInfo['des'])){
            $data['info']['des'] = $resInfo['des'];
            $resId = $resInfo['id'];
        }else{
            $data['info']['des'] = "未检测";
            $resId = $resInfo['id'];
        }

        $info = $this->Describe_model->GetInfoByCode($code);  //在descrbe表中查询相应的信息//包括中文名/图片等信息/b_intro d_intro
        $snpList = $this->Snp_model->GetListByResId($resId);  //在snp表中查询基因位点等信息。

        $data['info']['image'] = $info['image'];
        $data['info']['b_intro'] = $info['b_intro'];   //b_intro 是文字描述
        $data['info']['d_intro'] = $info['d_intro'];    //d_intro是百科的链接
        $data['info']['en_title'] = "lf title";   //什么意思？完全不能理解这是要干啥。
        $list = array();
        foreach ($snpList as $k=>$v){
            $list[$k]['site'] = $v['site'];
            $list[$k]['a1'] = $v['a1'];
            $list[$k]['a2'] = $v['a2'];
            $list[$k]['score'] = doubleval($v['score']);
            $list[$k]['drug_ins_id'] = trim($v['drug_ins_id']);
        }
        $data['info']['list'] = $list;
        return $this->output(true,1000,$data);
    }
    
    
    
    
    //当用户搜索时，根据搜索的关键字将搜索结果显示出来。在搜索时，需要注意搜索的是那个用户，123表示示例样本。不在检测的疾病不会给显示。
    public function SearchDesTypeList($param){
        $param = $this->_check_param($param,array(SERVICE_PARAM_INT,SERVICE_PARAM_STRING,SERVICE_PARAM_INT));
        $user_id = $param[0];
        $key = $param[1];
        $check_id = $param[2];//Note:如果传进来的是0，那么意思是这个人的查看这个人的信息，123分别查看样本示例的信息。
        if($check_id!=0){
            $user_id = $check_id;
        }
        //先从检测结果里面取6条已经有的
        $tempList = $this->Describe_model->GetSearchListByType($user_id,$key);

        $list = array();
        foreach ($tempList as $k=>$v){
            $list[$k]['selected'] = 0;
            $list[$k]['code'] = $v['code'];
            $list[$k]['ch_name'] = $v['ch_name'];
            $list[$k]['id'] =  intval($v['id']);
            
            // 是否携带
            if(empty($v['r_id'])){
                $list[$k]['has'] = 0;
            }else if($v['has']=='No'){
                $list[$k]['has'] = 0;
            } else{
                $list[$k]['has'] = 1;
            }
            $list[$k]['score'] = doubleval($v['score']);
        }
        $data['list'] = $list;
        return $this->output(true,1000,$data);
    }

    // 根据用户搜索的内容，获得跟搜索词汇想关联的词汇
    public function RelationKey($param){
        $param = $this->_check_param($param,array(SERVICE_PARAM_STRING));
        $key = $param[0];
        $list = $this->Describe_model->GetRelationKey($key);
        $data['list'] = $list;
        return $this->output(true,1000,$data);
    }
    
    
    //获取特征列表   这个接口没有用到
    public function GetDesTypeList($param){
        $param = $this->_check_param($param,array(SERVICE_PARAM_INT,SERVICE_PARAM_STRING,SERVICE_PARAM_STRING,SERVICE_PARAM_STRING,SERVICE_PARAM_INT));
        $user_id = $param[0]; // 传入的用户id 类型表示
        $type = $param[1];   //表示想要搜索的类型，比如：health character disease drug 
        $code = $param[2];     // 特征的名字
        $choice = $param[3];    //暂时没有看懂
        $check_id = $param[4];   //是看自己的还是看样本的

        $choice = explode(",", $choice);  //explode 函数：将字符串转化为数组 ？？？意义在哪里？

        if($choice[0]==''){
            $choice = array();
        }
        if($check_id!=0){
            $user_id = $check_id;
        }
        //先从检测结果里面取6条已经有的
        if(!empty($choice)){
            if($type=="desease"){
                $likeCode = "A";
                $tempList = $this->Describe_model->GetDeseaseListByTypeChoice($likeCode,$choice,$user_id);
            }else if($type== "drug"){
                $likeCode = "B";
                $tempList = $this->Describe_model->GetDrugListByTypeChoice($likeCode,$choice,$user_id);
            }else if($type== "health"){
                $likeCode = "C";
                $tempList = $this->Describe_model->GetHealthListByTypeChoice($likeCode,$choice,$user_id);
            }else if($type== "character"){
                $likeCode = "D";
                $tempList = $this->Describe_model->GetCharacterListByTypeChoice($likeCode,$choice,$user_id);
            }
        }else{
            if($type=="desease"){
                $likeCode = "A";
            }else if($type== "drug"){
                $likeCode = "B";
            }else if($type== "health"){
                $likeCode = "C";
            }else if($type== "character"){
                $likeCode = "D";
            }
            $tempList = $this->Describe_model->GetListByType($likeCode,$user_id);
        }

        $list = array();
        foreach ($tempList as $k=>$v){
            //$resInfo = $this->Result_model->GetInfoByTypeCodeUserId($type,$v['code'],$user_id);
            if($code==$v['code']){
                $list[$k]['selected'] = 1;
            }else{
                $list[$k]['selected'] = 0;
            }
            $list[$k]['code'] = $v['code'];
            $list[$k]['ch_name'] = $v['ch_name'];
            $list[$k]['id'] =  intval($v['id']);

            if(empty($v['r_id'])){
                $list[$k]['has'] = 0;
            }else if($v['has']=='No'){
                $list[$k]['has'] = 0;
            } else{
                $list[$k]['has'] = 1;
            }
            $list[$k]['score'] = doubleval($v['score']);
            //
            //
            if(empty($v['r_id'])){
                $list[$k]['des'] = "未检测";
            }else if(!empty($v['score'])){
                $list[$k]['des'] = $v['score'];
            }else if(!empty($v['has'])){
                if($type=="drug"){
                    if($v['has']=="Yes"){
                        $list[$k]['des'] = "谨慎使用";
                    }
                    else if($v['has']=="No"){
                        $list[$k]['des'] = "正常使用";
                    }
                    else{
                        $list[$k]['des'] = "未检测";
                    }
                }else{
                    if($v['has']=="Yes"){
                        $list[$k]['des'] = "携带";
                    }
                    else if($v['has']=="No"){
                        $list[$k]['des'] = "未携带";
                    }
                    else{
                        $list[$k]['des'] = "未检测";
                    }
                }
            }else if(!empty($v['des'])){
                $list[$k]['des'] = $v['des'];
            }else{
                $list[$k]['des'] = "未检测";
            }
            
        }

        $data['list'] = $list;
        return $this->output(true,1000,$data);
    }

    // 这个接口没有用到
    public function GetDesList($param){
        $param = $this->_check_param($param,array(SERVICE_PARAM_INT,SERVICE_PARAM_STRING,SERVICE_PARAM_STRING));
        $user_id = $param[0];
        $type = $param[1];
        $code = $param[2];
        //先从检测结果里面取6条已经有的
        if($type=="desease"){
            $likeCode = "A";
        }else if($type== "drug"){
            $likeCode = "B";
        }else if($type== "health"){
            $likeCode = "C";
        }else if($type== "character"){
            $likeCode = "D";
        }
        $tempList = $this->Describe_model->GetListByType($likeCode);
        $list = array();
        foreach ($tempList as $k=>$v){
            $resInfo = $this->Result_model->GetInfoByTypeCodeUserId($type,$v['code'],$user_id);
            if($code==$v['code']){
                $list[$k]['selected'] = 1;
            }else{
                $list[$k]['selected'] = 0;
            }
            $list[$k]['code'] = $v['code'];
            $list[$k]['ch_name'] = $v['ch_name'];
            $list[$k]['id'] =  intval($v['id']);
            if(empty($resInfo)){
                $list[$k]['has'] = 0;
            }else{
                $list[$k]['has'] = 1;
            }
            $list[$k]['score'] = doubleval($resInfo['score']);
        }

        $data['list'] = $list;
        return $this->output(true,1000,$data);
    }

}