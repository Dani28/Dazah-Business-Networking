<?php 

$config = array(
	'full_tag_open' => '<nav><ul class="pagination pagination-lg">',
	'full_tag_close' => '</ul></nav>',
	'num_tag_open' => '<li>',
	'num_tag_close' => '</li>',
	'first_tag_open' => '<li>',
	'first_tag_close' => '</li>',
	'last_tag_open' => '<li>',
	'last_tag_close' => '</li>',
	'next_tag_open' => '<li>',
	'next_tag_close' => '</li>',
	'prev_tag_open' => '<li>',
	'prev_tag_close' => '</li>',
	'cur_tag_open' => '<li class="active"><a href="#">',
	'cur_tag_close' => '</a></li>',
	'next_link' => '<span aria-hidden="true">&raquo;</span>',
	'prev_link' => '<span aria-hidden="true">&laquo;</span>',
	'first_link' => 'First',
	'last_link' => 'Last',
    'suffix' => '?' . http_build_query($this->input->get())    
);


?>