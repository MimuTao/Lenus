<?php
/**
 * Created by PhpStorm.
 * User: wa
 * Date: 2017/3/23
 * Time: 15:55
 */
class Record_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    
    //通过user获得信息
    public function GetInfoByUserId($user_id){
        $this->db->select('*')
            ->from('record')
            ->where("user_id",$user_id);
        $query = $this->db->get();
        return $query->row_array();
    }
    //添加绑定信息
    public function Add($user_id,$code,$bind_time,$ins_mobile){
        $data = array(
            'user_id'=>$user_id,
            'code'=>$code,
            'bind_time'=>$bind_time,
            'ins_mobile'=>$ins_mobile
        );
        $this->db->insert('record',$data);
    }

    public function UpdateReport($user_id){
        $this->db->set('report', 1);
        $this->db->set('upload_time', time());
        $this->db->where('user_id', $user_id);
        $this->db->update('record');
    }

}