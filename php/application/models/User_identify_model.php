<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 用户
 */
class User_identify_model extends CI_Model
{
    /**
     * 构造函数
     */
    public function __construct() {
        parent::__construct();
    }

    public function info($user_id, $identify_code) {
        $this->db->select("*")
            ->from("user_identify")
            ->where("user_id", $user_id)
            ->where("identify_code", $identify_code);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function info_by_user_id($user_id) {
        $this->db->select("*")
            ->from("user_identify")
            ->where("user_id", $user_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function UpdateOneInfo($user_id, $type, $value) {
        if (!in_array($type, array("identify_code", "time", "last_time","user_type"))) {
            return false;
        } else {
            $this->db->set($type, $value);
            $this->db->where('user_id', $user_id);
            $this->db->update('user_identify');
        }
    }

    public function add($user_id,$identify_code,$time,$last_time,$user_type){
        $data = array(
            'user_id' => $user_id,
            'identify_code' => $identify_code,
            'time' =>$time,
            'last_time' =>$last_time,
            'user_type'=>$user_type
        );
        $this->db->insert('user_identify', $data);
    }
    public function get_info_by_UserId_code($user_id,$identify_code){
        $this->db->select("*")
            ->from("user_identify")
            ->where("user_id", $user_id)
            ->where("identify_code", $identify_code);
        $query = $this->db->get();
        return $query->row_array();
    }

    //将identify_code置为0
    public function ResetCode($user_id)
    {
        $this->db->set('identify_code',0)
            ->where('user_id',$user_id)
            ->update('user_identify');
    }
}