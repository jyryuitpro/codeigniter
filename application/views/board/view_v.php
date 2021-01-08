<!--<script type="text/javascript" src="/bbs/include/js/httpRequest.js"></script>-->
<article id="board_area">
	<header>
		<h1></h1>
	</header>
	<table cellspacing="0" cellpadding="0" class="table table-striped">
		<thead>
		<tr>
			<th scope="col"><?php echo $views->subject; ?></th>
			<th scope="col">이름 : <?php echo $views->user_name; ?></th>
			<th scope="col">조회수 : <?php echo $views->hits; ?></th>
			<th scope="col">등록일 : <?php echo $views->reg_date; ?></th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<th colspan="4">
				<?php echo $views->contents; ?>
			</th>
		</tr>
		</tbody>
		<tfoot>
		<tr>
			<th colspan="4">
				<a href="/board/lists/<?php echo $this->uri->segment(3); ?>/page/<?php echo $this->uri->segment(7); ?>" class="btn btn-primary">목록</a>
				<a href="/board/modify/<?php echo $this->uri->segment(3); ?>/board_id/<?php echo $this->uri->segment(4); ?>/page/<?php echo $this->uri->segment(7); ?>" class="btn btn-warning">수정</a>
				<a href="/board/delete/<?php echo $this->uri->segment(3); ?>/board_id/<?php echo $this->uri->segment(4); ?>/page/<?php echo $this->uri->segment(7); ?>" class="btn btn-danger">삭제</a>
				<a href="/board/write/<?php echo $this->uri->segment(3); ?>/page/<?php echo $this->uri->segment(7); ?>" class="btn btn-success">쓰기</a>
			</th>
		</tr>
		</tfoot>
	</table>
</article>
