<?php
/**
 * Created by PhpStorm.
 * User: wa
 * Date: 2017/3/27
 * Time: 18:27
 */
class Opinion_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function Add($user_id,$opinion,$time){
        $data = array(
            'user_id'=>$user_id,
            'opinion'=>$opinion,
            'time'=>$time
        );
        $this->db->insert('opinion',$data);
    }

}