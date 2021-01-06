<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 게시판 메인 컨트롤러
 */
class Board extends CI_Controller {

    /**
     * Board constructor.
     */
    public function __construct()
    {
    	// 기본적으로 선언하는 것
        parent::__construct();
        // $this는 Codeigniter에서 객체로서 Codeigniter 자신을 가르킵니다.
        $this->load->database();
        // application/models/Board_m.php 파일을 로딩
        $this->load->model('board_m');
    }

    /**
     * 주소에서 메서드가 생략되었을 때 실행되는 기본 메서드
     */
    public function index()
    {
        $this->lists();
    }

    /**
     * 사이트 헤더, 푸터가 자동으로 추가된다
     */
    public function _remap($method)
    {
        // 헤더 include
        $this->load->view('header_v');

        if (method_exists($this, $method)) {
            $this->{"{$method}"}();
        }

        // 푸터 include
        $this->load->view('footer_v');
    }

    /**
     * 목록 불러오기
     */
    public function lists()
    {
    	// 페이지네이션 라이브러리 로딩 추가
		$this->load->library('pagination');

		// 페이지네이션 설정
		$config['base_url'] = '/board/lists/ci_board/'; // 페이징 주소
		$config['total_rows'] = $this->board_m->get_list($this->uri->segment(3), 'count'); // 게시물의 전체 개수
		$config['per_page'] = 5; // 한 페이지에 표시할 게시물 수
		$config['uri_segment'] = 4; // 페이지 번호가 위치한 세그먼트

		// 페이지네이션 초기화
		$this->pagination->initialize($config);
		// 페이징 링크를 생성하여 view에서 사용할 변수에 할당
		$data['pagination'] = $this->pagination->create_links();

		// 게시물 목록을 불러오기 위한 offset, limit 값 가져오기
		$page = $this->uri->segment(4, 1);

		if ($page > 1) {
			$start = (($page / $config['per_page'])) * $config['per_page'];
		} else {
			$start = ($page - 1) * $config['per_page'];
		}

		$limit = $config['per_page'];

//		echo '$page : ' . $page;
//		echo '<br>';
//		echo '$start : ' . $start;
//		echo '<br>';
//		echo '$limit : ' . $limit;

    	// Board_m.php 모델 내의 get_list() 함수를 실행
		// segment(0) : index.php (현재 url에서 제거함)
		// segment(1) : board, segment(2) : lists, segment(3) : ci_board
//        $data['list'] = $this->board_m->get_list($this->uri->segment(3));
        $data['list'] = $this->board_m->get_list($this->uri->segment(3), '', $start, $limit);
        $this->load->view('board/list_v', $data);
    }
}

/* End of file Board.php */
/* Location: ./application/controllers/Board.php */
