<?php
/**
 * Created by PhpStorm.
 * User: wa
 * Date: 2017/3/18
 * Time: 17:31
 */
defined('BASEPATH') or exit("No direct script access allowed");

class Describe_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function GetInfoByCode($code){
        $this->db->select('*')
            ->from('describe')
            ->where("code",$code);
        $query = $this->db->get();
        return $query->row_array();
    }
    // 根据是那种类型搜索结果
    public function GetListByType($code,$user_id){
        $this->db->select('w1.*,w2.id as r_id,w2.has,w2.score,w2.des')
            ->from('describe w1')
            ->join('result w2','w1.code = w2.code and w2.user_id = '.$user_id,'left')
            ->like("w1.code",$code);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    //获得某个用户搜索的相关信息列表（只显示出已经绑定检测的信息）
    public function GetSearchListByType($user_id,$key){
        $this->db->select('w1.*,w2.id as r_id,w2.has,w2.score')
            ->from('describe w1')
            ->join('result w2','w1.code = w2.code and w2.user_id = '.$user_id,'left')
            ->like("w1.ch_name",$key);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function GetCharacterListByTypeChoice($code,$choice,$user_id){
        $this->db->select('w1.*,w2.id as r_id,w2.has,w2.score')
            ->from('describe w1')
            ->join("result w2","w1.code = w2.code and w2.user_id = ".$user_id,"left")
            //->where("w2.user_id",$user_id)
            ->like("w1.code",$code);
        $this->db->group_start();
        if(in_array(0,$choice)){//严重偏左
            $this->db->or_where("w2.score <",0.5);
            $this->db->or_where("w2.score");
        }
        if(in_array(1,$choice)){//高于参考值且不优
            $this->db->or_where("w2.score between 1 and 1.5");
        }
        if(in_array(2,$choice)){//低于参考值且不优
            $this->db->or_where("w2.score between 0.5 and 1");
        }
        if(in_array(3,$choice)){//高于参考值且优
            $this->db->or_where("w2.score >",1.5);
        }
        $this->db->group_end();
        $query = $this->db->get();
        return $query->result_array();
    }

    public function GetHealthListByTypeChoice($code,$choice,$user_id){
        $this->db->select('w1.*,w2.id as r_id,w2.has,w2.score')
            ->from('describe w1')
            ->join("result w2","w1.code = w2.code and w2.user_id = ".$user_id,"left")
            //->where("w2.user_id",$user_id)
            ->like("w1.code",$code);
        $this->db->group_start();
        if(in_array(0,$choice)){//高于平均4倍
            $this->db->or_where("w2.score >",4);
        }
        if(in_array(1,$choice)){//高于平均水平
            $this->db->or_where("w2.score between 1 and 4");
        }
        if(in_array(2,$choice)){//低于平均水平
            $this->db->or_where("w2.score <",1);
            $this->db->or_where("w2.score");
        }
        $this->db->group_end();
        $query = $this->db->get();
        return $query->result_array();
    }

    public function GetDrugListByTypeChoice($code,$choice,$user_id){
        $this->db->select('w1.*,w2.id as r_id,w2.has,w2.score')
            ->from('describe w1')
            ->join("result w2","w1.code = w2.code and w2.user_id = ".$user_id,"left")
            //->where("w2.user_id",$user_id)
            ->like("w1.code",$code);
        $this->db->group_start();
        if(in_array(0,$choice)){//谨慎使用
            $this->db->or_where("w2.has","Yes");
        }
        if(in_array(1,$choice)){//正常使用
            $this->db->or_where("w2.has","No");
            $this->db->or_where("w2.has");
        }
        $this->db->group_end();
        $query = $this->db->get();
        return $query->result_array();
    }

    public function GetDeseaseListByTypeChoice($code,$choice,$user_id){
        $this->db->select('w1.*,w2.id as r_id,w2.has,w2.score')
            ->from('describe w1')
            ->join("result w2","w1.code = w2.code and w2.user_id = ".$user_id,"left");
        $this->db->like("w1.code",$code);
        $this->db->group_start();
        if(in_array(0,$choice)){//谨慎使用
            $this->db->or_where("w2.has","Yes");
        }
        if(in_array(1,$choice)){//正常使用
            $this->db->or_where("w2.has","No");
            $this->db->or_where("w2.has");
        }
        $this->db->group_end();
        $query = $this->db->get();
        return $query->result_array();
    }

    public function GetTotalByCode($code){
        $this->db->select('count(1) as total')
            ->from('describe')
            ->like("code", $code);
        $query = $this->db->get();
        $row = $query->row_array();
        return $row['total'];
    }
    public function GetRelationKey($key){
        $this->db->select('ch_name')
            ->from('describe')
            ->like("ch_name",$key)
            ->limit(10,0);
        $query = $this->db->get();
        return $query->result_array();
    }
}