<?php

class PaginationView {
    public function Pagination($base_url, $total_record, $per_page) {
        $config['base_url'] = $base_url;
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config['full_tag_open'] = '<ul class="pagination layout center">';
        $config['full_tag_close'] = '</ul>';
        $config['next_link'] = '&rarr; Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="disabled"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['page_query_string'] =TRUE;
        return $config;
    }
}
