<?php
/**
 * Created by PhpStorm.
 * User: WA
 * Date: 2016/4/15
 * Time: 10:35
 */
defined('BASEPATH') or exit("No direct script access allowed");

class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function GetInfoByMobile($mobile)
    {
        $this->db->db_select('gene');
        $res = $this->db->select('*')->from('user')
            ->where('mobile',$mobile)
            ->get();
        return $res->row_array();
    }

    public function GetInfoById($user_id)
    {
        $res = $this->db->select('*')->from('user')
            ->where('id',$user_id)
            ->get();
        return $res->row_array();
    }

    public function LoginCheck($mobile,$salt,$pwd){
        $res = $this->db->select('*')
            ->from('user')
            ->where('mobile',$mobile)
            ->where('salt',$salt)
            ->where('pwd',$pwd)
            ->get();
        return $res->row_array();
    }

    public function AddUser($mobile,$pwd,$reg_time,$salt)
    {
        $this->db->db_select('gene');
        $data = array(
            'mobile'=>$mobile,
            'pwd'=>$pwd,
            'reg_time'=>$reg_time,
            'salt'=>$salt
        );
        $this->db->insert('user',$data);
        return $this->db->insert_id();
    }
    
    //更新头像
    public function UpdateHead($user_id,$head){
        $this->db->set("head", $head);
        $this->db->where('id', $user_id);
        $this->db->update('user');
    }
    
    //更新昵称
    public function UpdateUserName($user_id,$user_name){
        $this->db->set("user_name", $user_name);
        $this->db->where('id', $user_id);
        $this->db->update('user');
    }
    //更换密码
    public function UpdatePwd($user_id,$pwd,$salt){
        $this->db->set("pwd", $pwd);
        $this->db->set("salt", $salt);
        $this->db->where('id', $user_id);
        $this->db->update('user');
    }
}