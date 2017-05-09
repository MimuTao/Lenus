
<?php
/**
 * Created by PhpStorm.
 * User: 601
 * Date: 2017-03-17
 * Time: 16:22
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Result_service extends MY_Service
{
    //构造方法
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Result_model");
        $this->load->model("Describe_model");
        $this->load->model("Record_model");
    }

    /**
     * 得到单次检测结果
     * @param $param
     * @throws Exception
     */
    public function GetUserResult($param)
    {
        $param = $this->_check_param($param,array(SERVICE_PARAM_INT,SERVICE_PARAM_INT));
        $user_id = $param[0];
        $check_id = $param[1];
        if($check_id!=0){
            $user_id = $check_id;
        }
        $data = array();
        $characterList = $this->Result_model->GetCharacterRandom('character',$user_id,6);  //获得性格的前6个信息
        $deseaseList = $this->Result_model->GetCharacterRandom('desease',$user_id,6);    //获得疾病的前6条信息
        $drugList = $this->Result_model->GetDrugRandom('drug',$user_id,3);   //取得用药的前3条信息

        $cList = array();  //表示性格
        $dList = array();  //表示疾病列表
        $rList = array();  //表示用药列表

        ///下面绑定中文名
        foreach ($characterList as $k=>$v){
            $describeInfo = $this->Describe_model->GetInfoByCode($v['code']);
            if(!empty($describeInfo)){
                $cList[$k]['ch_name'] = $describeInfo['ch_name'];
            }else{
                $cList[$k]['ch_name'] = "未知特征";
            }
            $cList[$k]['code'] = ($v['code']);
        }
        foreach ($deseaseList as $k=>$v){
            $describeInfo = $this->Describe_model->GetInfoByCode($v['code']);
            if(!empty($describeInfo)){
                $dList[$k]['ch_name'] = $describeInfo['ch_name'];
            }else{
                $dList[$k]['ch_name'] = "未知特征";
            }
            $dList[$k]['code'] = ($v['code']);
        }
        foreach ($drugList as $k=>$v){
            $describeInfo = $this->Describe_model->GetInfoByCode($v['code']);
            if(!empty($describeInfo)){
                $rList[$k]['ch_name'] = $describeInfo['ch_name'];
            }else{
                $rList[$k]['ch_name'] = "未知特征";
            }
            $rList[$k]['code'] = ($v['code']);
            $rList[$k]['has'] = ($v['has']);
        }
        
        $bInfo = $this->Result_model->GetInfoByCodeUserId("D0001",$user_id);
        if(!empty($bInfo)){
            $data['title'] = $bInfo['des'];
        }else{
            $data['title'] = "";
        }
        $data['character']['list'] = $cList;
        $data['character']['total'] = $this->Describe_model->GetTotalByCode('D');
        $data['desease']['list'] = $dList;
        $data['desease']['total'] = $this->Describe_model->GetTotalByCode('A');

        $data['desease']['needCare'] = intval($this->Result_model->GetNeedCareByType_Has_UserId('desease',$user_id));;
        $data['drug']['needCare'] = intval($this->Result_model->GetNeedCareByType_Has_UserId('drug',$user_id));

        $data['drug']['list'] = $rList;
        $data['drug']['total'] = $this->Describe_model->GetTotalByCode('B');
        $data['health']['totalCheck'] = intval($this->Result_model->GetTotalByTypeUserId('health',$user_id));
        $data['health']['needCare'] = intval($this->Result_model->GetNeedCareTotalByTypeUserId('health',$user_id));
        $data['health']['dangerRate'] =  round($data['health']['needCare']/$data['health']['totalCheck'], 3);
        $data['health']['total'] = intval($this->Result_model->GetTotalByTypeUserId('health',$user_id));//intval($this->Describe_model->GetTotalByCode('C'));
        return $this->output(true,1000,$data);
    }




    public function InsertData()
    {
        $this->load->model("Record_model");
        $json_string = file_get_contents('E://HG00130.json');
        $user_id = 100010;
        $data = json_decode($json_string,true);

        foreach($data as $key1 => $value1){
            $type = $key1;
            foreach($value1 as $key2 => $value2){
                $code = $key2;
                $resInfo = $this->Result_model->GetInfoByTypeCodeUserId($type,$code,$user_id);
                if(!empty($resInfo)){
                    continue;
                }
                if(isset($value2['score']))
                    $score1 = $value2['score'];
                else
                    $score1 = '';
                if(isset($value2['has']))
                    $has = $value2['has'];
                else
                    $has = '';
                if(isset($value2['des']))
                    $des = $value2['des'];
                else
                    $des = '';
                $result_id = $this->Result_model->InsertResult($type,$code,$score1,$has,$user_id,$des);
                if(isset($value2['SNP'])){
                    $snp = $value2['SNP'];
                    foreach($snp as $key3 => $value3){
                        $site = $key3;
                        $a1 = $value3['a1'];
                        $a2 = $value3['a2'];
                        if(isset($value3['score']))
                            $score2 = $value3['score'];
                        else
                            $score2 = '';
                        if(isset($value3['DrugInsID']))
                            $drug_ins_id = $value3['DrugInsID'];
                        else
                            $drug_ins_id = '';
                        $this->Result_model->InsertSnp($result_id,$site,$a1,$a2,$score2,$drug_ins_id);
                    }
                }
            }
        }
        $this->Record_model->UpdateReport($user_id);
    }

}