<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 공통 게시판 모델
 */
class Board_m extends CI_Model {


    /**
     * Board_m constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    function get_list($table = 'ci_board')
    {
        $sql = "SELECT * FROM " . $table . " ORDER BY board_id DESC";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

}

/* End of file Board_m.php */
/* Location: ./application/controllers/Board_m.php */
