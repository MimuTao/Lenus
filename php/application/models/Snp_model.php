<?php
/**
 * Created by PhpStorm.
 * User: wa
 * Date: 2017/3/18
 * Time: 17:28
 */
defined('BASEPATH') or exit("No direct script access allowed");

class Snp_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function GetListByResId($result_id){
        $this->db->select('*')
            ->from('snp')
            ->where("result_id", $result_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
}