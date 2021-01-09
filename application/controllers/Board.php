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
//		$this->output->enable_profiler(true);

		// 검색어 초기화
		$search_word = $page_url = '';
		$uri_segment = 5;

		// 주소 중에서 q(검색어) 세그먼트가 있는지 검사하기 위해 주소를 배열로 변환
		$uri_array = $this->segment_explode($this->uri->uri_string());

//		print_r($uri_array);

		if (in_array('q', $uri_array)) {
			// 주소에 검색어가 있을 경우의 처리
			$search_word = urldecode($this->url_explode($uri_array, 'q'));

//			print_r($search_word);

			// 페이지네이션용 주소
			$page_url = '/q/' . $search_word;
			$uri_segment = 7;
		}

    	// 페이지네이션 라이브러리 로딩 추가
		$this->load->library('pagination');

		// 페이지네이션 설정
		$config['base_url'] = '/board/lists/ci_board/' . $page_url . '/page/'; // 페이징 주소
		$config['total_rows'] = $this->board_m->get_list($this->uri->segment(3), 'count', '', '', $search_word); // 게시물의 전체 개수
		$config['per_page'] = 5; // 한 페이지에 표시할 게시물 수
		$config['uri_segment'] = $uri_segment; // 페이지 번호가 위치한 세그먼트

		// 페이지네이션 초기화
		$this->pagination->initialize($config);
		// 페이징 링크를 생성하여 view에서 사용할 변수에 할당
		$data['pagination'] = $this->pagination->create_links();

		// 게시물 목록을 불러오기 위한 offset, limit 값 가져오기
//		print_r($uri_segment);
		$data['page'] = $page = $this->uri->segment($uri_segment, 1);
//		print_r($page);


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
        $data['list'] = $this->board_m->get_list($this->uri->segment(3), '', $start, $limit, $search_word);
        $this->load->view('board/list_v', $data);
    }

    /**
	 * url 중 키값을 구분하여 값을 가져오도록
	 *
	 * @param Array $url : segment_explode 한 url 값
	 * @param String $key : 가져오려는 값의 key
	 * @return String $url[$k] : 리턴값
	 */
	function url_explode($url, $key)
	{
		$cnt = count($url);

		for ($i = 0; $i < $cnt; $i++) {
			if ($url[$i] == $key) {
				$k = $i + 1;
				return $url[$k];
			}
		}
	}

	/**
	 * HTTP의 URL을 "/"를 Delimiter로 사용하여 배열로 바꿔 리턴한다.
	 *
	 * @param String 대상이 되는 문자열
	 * @return String[]
	 */
	function segment_explode($seg)
	{
		// 세그먼트 앞뒤 '/' 제거 후 uri를 배열로 반환
		$len = strlen($seg);
		if (substr($seg, 0, 1) == '/') {
			$seg = substr($seg, 1, $len);
		}
		$len = strlen($seg);
		if (substr($seg, -1) == '/') {
			$seg = substr($seg, 0, $len - 1);
		}
		$seg_exp = explode("/", $seg);

		return $seg_exp;
	}

	/**
	 * 게시물 보기
	 */
	function view()
	{
		// 게시판 이름과 게시물 번호에 해당하는 게시물 가져오기
		$data['views'] = $this->board_m->get_view($this->uri->segment(3), $this->uri->segment(5));

		// view 호출
		$this->load->view('board/view_v', $data);
	}

	/**
	 * 게시물 쓰기
	 */
	function write()
	{
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		if ($_POST) {
			// 글쓰기 POST 전송 시

			// 경고창 헬퍼 로딩
			$this->load->helper('alert');

			// 주소 중에서 page 세그먼트가 있는지 검사하기 위해 주소를 배열로 변환
			$uri_array = $this->segment_explode($this->uri->uri_string());

			if (in_array('page', $uri_array)) {
				$pages = urldecode($this->url_explode($uri_array, 'page'));
			} else {
				$pages = 1;
			}

			if (!$this->input->post('subject', TRUE) && !$this->input->post('subject', TRUE)) {
				// 글 내용이 없을 경우, 프로그램단에서 한 번 더 체크
				alert('비정상적인 접근입니다.', '/board/lists/' . $this->uri->segment(3) . '/page/' . $pages);
				exit;
			}

//			var_dump($POST);
			$write_data = array(
				'table' => $this->uri->segment(3), //게시판 테이블명
				'subject' => $this->input->post('subject', TRUE),
				'contents' => $this->input->post('contents', TRUE)
			);

			$result = $this->board_m->insert_board($write_data);

			if ($result) {
				// 글 작성 성공 시 게시물 목록으로
				alert('입력되었습니다.', '/board/lists/' . $this->uri->segment(3) . '/page/' . $pages);
				exit;
			} else {
				// 글 실패 시 게시물 목록으로
				alert('다시 입력해 주세요..', '/board/lists/' . $this->uri->segment(3) . '/page/' . $pages);
				exit;
			}

		} else {
			// 쓰기 폼 view 호출
			$this->load->view('board/write_v');
		}
	}

	/**
	 * 게시물 수정
	 */
	function modify()
	{
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

		if ($_POST) {
			// 글 수정 POST 전송 시

			// 경고창 헬퍼 로딩
			$this->load->helper('alert');

			// 주소 중에서 page 세그먼트가 있는지 검사하기 위해 주소를 배열로 반환
			$uri_array = $this->segment_explode($this->uri->uri_string());

			if (in_array('page', $uri_array)) {
				$pages = urldecode($this->url_explode($uri_array, 'page'));
			} else {
				$pages = 1;
			}

			if (!$this->input->post('subject', TRUE) && !$this->input->post('contents', TRUE)) {
				// 글 내용이 없을 경우, 프로그램단에서 한 번 더 체크
				alert('비정상적인 접근입니다.', '/board/lists/' . $this->uri->segment(3) . '/page/' . $pages);
				exit;
			}

			// var_dump($_POST);
			$modify_data = array(
				'table' => $this->uri->segment(3), //게시판 테이블명
				'board_id' => $this->uri->segment(5), //게시물 번호
				'subject' => $this->input->post('subject', TRUE),
				'contents' => $this->input->post('contents', TRUE)
			);

			$result = $this->board_m->modify_board($modify_data);

			if ($result) {
				// 글 작성 성공 시 게시물 목록으로
				alert('입력되었습니다.', '/board/lists/' . $this->uri->segment(3) . '/page/' . $pages);
				exit;
			} else {
				// 글 수정 실패 시 글 내용으로
				alert('다시 수정해 주세요.', '/board/view/' . $this->uri->segment(3) . '/board_id/' . $this->uri->segment(5) . '/page/' . $pages);
				exit;
			}
		} else {
			// 게시물 내용 가져오기
			$data['views'] = $this->board_m->get_view($this->uri->segment(3), $this->uri->segment(5));

			// 쓰기 폼 view 호출
			$this->load->view('board/modify_v', $data);
		}
	}

	/**
	 * 게시물 삭제
	 */
	function delete()
	{
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

		// 경고창 헬퍼 로딩
		$this->load->helper('alert');

		// 게시물 번호에 해당하는 게시물 삭제
		$return = $this->board_m->delete_content($this->uri->segment(3), $this->uri->segment(5));

		// 게시물 목록으로 돌아가기
		if ($return) {
			// 삭제가 성공한 경우
			alert('삭제되었습니다.','/board/lists/' . $this->uri->segment(3) . '/page/' . $this->uri->segment(7));
		} else {
			// 삭제가 실패한 경우
			alert('삭제 실패하였습니다.','/board/view/' . $this->uri->segment(3) . '/board_id' . $this->uri->segment(5) .'/page/' . $this->uri->segment(7));
		}
	}
}

/* End of file Board.php */
/* Location: ./application/controllers/Board.php */
