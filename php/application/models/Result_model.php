<?php
/**
 * Created by PhpStorm.
 * User: 601
 * Date: 2017-03-17
 * Time: 16:39
 */
defined('BASEPATH') or exit("No direct script access allowed");

class Result_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function InsertSnp($result_id,$site,$a1,$a2,$score,$drug_ins_id)
    {
        $this->db->db_select('gene');
        $data = array(
            'result_id'=>$result_id,
            'site'=>$site,
            'a1'=>$a1,
            'a2'=>$a2,
            'score'=>$score,
            'drug_ins_id'=>$drug_ins_id
        );
        $this->db->insert('snp',$data);
        return $this->db->insert_id();
    }

    //插入数据
    public function InsertResult($type,$code,$score,$has,$user_id,$des)
    {
        $this->db->db_select('gene');
        $data = array(
            'type'=>$type,
            'code'=>$code,
            'score'=>$score,
            'has'=>$has,
            'user_id'=>$user_id,
            'des'=>$des
        );
        $this->db->insert('result',$data);
        return $this->db->insert_id();
    }
    //取得character 的前$limit条数据
    public function GetCharacterRandom($type,$user_id,$limit){
        $this->db->select('*')
            ->from('result')
            ->where("type", $type)
            ->where("user_id",$user_id)
            ->order_by("RAND()",false)
            ->limit($limit,0);
        $query = $this->db->get();
        return $query->result_array();
    }
    //取得Drug的前$limit 条数据
    public function GetDrugRandom($type,$user_id,$limit){
        $this->db->select('*')
            ->from('result')
            ->where("type", $type)
            ->where("user_id",$user_id)
            ->where("has","Yes")
            ->order_by("RAND()",false)
            ->limit($limit,0);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function GetInfoByTypeCodeUserId($type,$code,$user_id){
        $this->db->select('*')
            ->from('result')
            ->where("type", $type)
            ->where("code", $code)
            ->where("user_id",$user_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function GetInfoByCodeUserId($code,$user_id){
        $this->db->select('*')
            ->from('result')
            ->where("code", $code)
            ->where("user_id",$user_id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    //return amount of the type of the user_id 
    public function GetTotalByTypeUserId($type,$user_id){
        $this->db->select('count(1) as total')
            ->from('result')
            ->where("type", $type)
            ->where("user_id",$user_id);
        $query = $this->db->get();
        $row = $query->row_array();
        return $row['total'];
    }
    
    // 得到需要关注的信息
    public function GetNeedCareTotalByTypeUserId($type,$user_id){
        $this->db->select('count(1) as total')
            ->from('result')
            ->where("type", $type)
            ->where("score >",1)
            ->where("user_id",$user_id);
        $query = $this->db->get();
        $row = $query->row_array();
        return $row['total'];
    }
    // 得到需要关注的有疾病的信息
    public function GetNeedCareByType_Has_UserId($type,$user_id){
        $this->db->select('count(1) as total')
            ->from('result')
            ->where("type", $type)
            ->where("has ","Yes")
            ->where("user_id",$user_id);
        $query = $this->db->get();
        $row = $query->row_array();
        return $row['total'];
    }

}