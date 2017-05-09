<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 短信model
 */
class Sms_model extends CI_Model
{
    /**
     * 构造函数
     */
    public function __construct() {
        parent::__construct();
    }

    public function Add($code, $start_time, $due_time, $status, $mobile, $type) {
        $data = array(
            'code' => $code,
            'start_time' => $start_time,
            'due_time' => $due_time,
            'status' => $status,
            'mobile' => $mobile,
            'type' => $type
        );
        $this->db->insert('w_sms', $data);
        return $this->db->insert_id();
    }

    public function update_status($id, $status) {
        $this->db->set('status', $status);
        $this->db->where('id', $id);
        $this->db->update('w_sms');
    }

    public function UpdateStatusByMobileCode($mobile,$code,$status,$type){
        $this->db->set('status', $status);
        $this->db->where('mobile', $mobile);
        $this->db->where('code', $code);
        $this->db->where('type', $type);
        $this->db->update('w_sms');
    }
    /**
     * 上一条未验证的记录
     * @param $mobile
     * @param $type
     * @param $status
     * @return mixed
     */
    public function last_unverify_info($mobile, $type) {
        $this->db->select('*')
            ->from('sms')
            ->where("mobile", $mobile)
            ->where("type", $type)
            ->where("status !=", 5)
            //->where("mobile = '$mobile' and type = '$type' and status !=5")
            ->order_by('id DESC');
        $query = $this->db->get();
        return $query->row_array();
    }


    public function GetInfo($mobile,$code,$type){
        $this->db->select("*")
             ->from("sms")
             ->where("mobile",trim($mobile))
             ->where("code",$code)
             ->where("status",2)
             ->where("type", $type)
             ->order_by("id DESC")
             ->limit(1);
        $query = $this->db->get();
        return $query->row_array();
    }
}