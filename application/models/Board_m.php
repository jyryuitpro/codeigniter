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

    function get_list($table = 'ci_board', $type='', $offset='', $limit='', $search_word='')
    {
		$sword = '';

		if ($search_word != '') {
			// 검색어가 있을 경우의 처리
			$sword = ' WHERE subject like "%' . $search_word . '%" || contents like "%' . $search_word . '%" ';
		}

		$limit_query = '';

		if ($limit != '' || $offset != '') {
			//페이징이 있을 경우의 처리
			$limit_query = ' LIMIT ' . $offset . ', ' . $limit;
		}

		$sql = "SELECT * FROM " . $table . $sword . " ORDER BY board_id DESC" . $limit_query;
        $query = $this->db->query($sql);

		if ($type == 'count') {
			// 리스트를 반환하는 것이 아니라 전체 게시물의 개수를 반환
			$result = $query->num_rows();
		} else {
			// 게시물 리스트 반환
			$result = $query->result();
		}

        return $result;
    }

    /**
	 * 게시물 상세보기 가져오기
	 *
	 * @param String $table 게시판 테이블
	 * @param String $id 게시물 번호
	 * @return array
	 */
	function get_view($table, $id)
	{
		// 조회수 증가
		$sql = "UPDATE " . $table . " SET hits=hits+1 WHERE board_id='" . $id . "'";
		$this->db->query($sql);

		$sql = "SELECT * FROM " . $table . " WHERE board_id='" . $id . "'";
		$query = $this->db->query($sql);

		// 게시물 내용 반환
		$result = $query->row();

		return $result;
	}
}

/* End of file Board_m.php */
/* Location: ./application/controllers/Board_m.php */
