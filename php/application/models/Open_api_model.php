<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * open api
 */

/**
 *
 */
class Open_api_model extends CI_Model
{
    /**
     * 构造函数
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * @param $name
     */
    public function InfoByName($name) {
        $this->db->select('*')
            ->from('open_api')
            ->where('name', $name);
        $query = $this->db->get();
        return $query->row_array();
    }
}