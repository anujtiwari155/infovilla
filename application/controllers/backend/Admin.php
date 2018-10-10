<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->is_admin()) {
                // redirect them to the login page
                redirect('backend/Auth/login/home', 'refresh');
        }
    }

    public function Menus($action = null, $id = null) {

        switch ($action) {

            case 'add':

                $this->form_validation->set_rules('menu', 'Menu Name', 'trim|required|xss_clean|is_unique[menus.menu]');
                if ($this->form_validation->run() === false) {
                    $data = array(
                        'title' => "Add Menu",
                        'menus' => $menus = Menu::all(array("conditions" => array("deleted=?", 0)))
                    );

                    $this->template->load('backend/base', 'backend/cms/add_update_menu', $data);
                } else {

                    $data = array(
                        'menu' => $this->input->post('menu'),
                        'parent' => $this->input->post('parent')
                    );
                    Menu::create($data);
                    $this->session->set_flashdata('success', 'Successfully Added');
                    redirect(base_url() . 'backend/admin/menus');
                }
                break;
            case 'update':
                $menu = Menu::find($id);
                $this->form_validation->set_rules('menu', 'Menu Name', 'trim|required|xss_clean');
                if ($this->form_validation->run() === false) {
                    $data = array(
                        'title' => 'P Mart  Backend Update Menu',
                        'action' => 'Update Menu',
                        'menus' => Menu::all(array("conditions" => array("id!=? and deleted=?", $id, 0))),
                        'menu_update' => $menu
                    );

                    $this->template->load('backend/base', 'backend/cms/add_update_menu', $data);
                } else {
                    $menu->menu = $this->input->post('menu');
                    $menu->parent = $this->input->post('parent');
                    if ($menu->save()) {
                        $this->session->set_flashdata('success', 'Successfully Updated');
                    } else {
                        $this->session->set_flashdata('error', 'Something went wrong');
                    }
                    redirect(base_url() . 'backend/admin/menus');
                }
                break;
            case 'delete':
                $menu = Menu::find($id);
                $menu->deleted = 1;
                if ($menu->save())
                    $this->session->set_flashdata('success', 'Successfully deleted');
                else
                    $this->session->set_flashdata('error', 'Somethings went wrong');
                redirect(base_url() . 'backend/admin/menus');
                break;
            default:
                $data = array(
                    'title' => "Menus",
                    'menus' => Menu::all(array("select" => "menus.*,m.menu as parent_name", "joins" => "LEFT JOIN menus m on m.id= menus.parent", "conditions" => array("menus.deleted=?", 0)))
                );
                $this->template->load('backend/base', 'backend/cms/menu', $data);
                break;
        }
    }

    public function Cms($action = null, $id = null) {
        switch ($action) {

            case 'add':
                $this->form_validation->set_rules('menu_id', 'Page Menu', 'trim|required|xss_clean');
                $this->form_validation->set_rules('title', 'Page Title', 'trim|required');
                $this->form_validation->set_rules('description', 'Description', 'trim|required');
                if ($this->form_validation->run() === false) {
                    $data = array(
                        'title' => 'Add Custom Pages',
                        'menus' => Menu::all(array("conditions" => array("deleted=?", 0)))
                    );
                    $this->template->load('backend/base', 'backend/cms/add_update_page', $data);
                } else {
                    $data = array(
                        'menu_id' => $this->input->post('menu_id'),
                        'title' => $this->input->post('title'),
                        'meta_keywords' => $this->input->post('meta_keywords'),
                        'meta_description' => $this->input->post('meta_description'),
                        'description' => $this->input->post('description'),
                        'slug' => $this->slug($this->input->post('title')),
                        'status' => 1
                    );
                    Page::create($data);
                    $this->session->set_flashdata('success', 'Successfully created.');
                    redirect(base_url() . 'backend/admin/cms');
                }
                break;

            case 'update':
                $page = Page::find($id);
                $this->form_validation->set_rules('menu_id', 'Page Menu', 'trim|required');
                $this->form_validation->set_rules('title', 'Page Title', 'trim|required');
                if ($page->slug == $this->input->post('slug'))
                    $this->form_validation->set_rules('slug', 'Url Rewrite', 'trim|required');
                else
                    $this->form_validation->set_rules('slug', 'Url Rewrite', 'trim|required|is_unique[cms.slug]');
                $this->form_validation->set_rules('description', 'Description', 'trim|required');
                if ($this->form_validation->run() === false) {
                    $data = array(
                        'title' => 'P Mega Mart |  Backend Update Custom Pages',
                        'action' => 'Update Pages',
                        'menus' => Menu::all(array("conditions" => array("deleted=?", 0))),
                        'pages' => $page
                    );
                    $this->template->load('backend/base', 'backend/cms/add_update_page', $data);
                } else {
                    $page->menu_id = $this->input->post('menu_id');
                    $page->title = $this->input->post('title');
                    $page->meta_keywords = $this->input->post('meta_keywords');
                    $page->meta_description = $this->input->post('meta_description');
                    $page->description = $this->input->post('description');
                    $page->slug = $this->input->post('slug');
                    if ($page->save())
                        $this->session->set_flashdata('success', 'Successfully updated.');
                    else
                        $this->session->set_flashdata('error', 'Somethings went wrong.');
                    redirect(base_url() . 'backend/admin/cms');
                }
                break;

            case 'delete':
                    $page = Page::find($id);
                    $page->deleted = 1;
                    if ($page->save())
                        $this->session->set_flashdata('success', 'Successfully deleted.');
                    else
                        $this->session->set_flashdata('error', 'Somethings went wrong.');
                    redirect(base_url() . 'backend/admin/cms');
                break;

            default :
                if ($this->input->get('status') and $this->input->get('id')) {
                    $page = Page::find($this->input->get('id'));
                    if ($this->input->get('status') == 'true')
                        $page->status = 1;
                    else
                        $page->status = 0;

                    if ($page->save())
                        $this->session->set_flashdata('success', "Successfully update");
                    else
                        $this->session->set_flashdata('warning', 'Somethings went wrong');
                    redirect(base_url() . 'backend/admin/cms');
                }
                $data = array(
                    'title' => 'Custom Pages',
                    'pages' => Page::all(array(
                        "select" => "pages.*,m.menu as page_menu",
                        "joins" => "join menus m on m.id = pages.menu_id",
                        "conditions" => array("pages.deleted=? and m.deleted=?", 0, 0),
                        "order" => "pages.id desc"
                    ))
                );
                $this->template->load('backend/base', 'backend/cms/page', $data);
        }
    }

    public function slug($string) {

//Lower case everything

        $string = strtolower($string);

//Make alphanumeric (removes all other characters)

        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);

//Clean up multiple dashes or whitespaces

        $string = preg_replace("/[\s-]+/", " ", $string);

//Convert whitespaces and underscore to dash

        $string = preg_replace("/[\s_]/", "-", $string);

        return $string;
    }

    public function list_contact(){
        $this->load->library("paginationview");
        $base_url = base_url('backend/Admin/list_contact');
        $per_page = 10;
        $page = ($this->input->get("per_page")) ? $this->input->get("per_page") : 0;
        $contact_count = Contact::count(array('conditions' => array("active = '1'")));
        $data = array(
            'list_contacts' => Contact::all(array('conditions' => "active = '1'","limit" => $per_page, "offset" => $page)),
            'product_count' => $contact_count,
            'list'     => 'All Products'
            );
        $config = $this->paginationview->pagination($base_url, $contact_count, $per_page);
        $this->pagination->initialize($config);
        $this->data['currentPage'] = 'All Products';
        $this->template->load('backend/base', 'backend/cms/contact.php', array_merge($this->data,$data));
        }

    public function delete_contact($id=NULL){
        
        $contacts = Contact::find($id);
        $contacts->active = 0;
        $contacts->save();
       redirect(base_url() . 'backend/admin/list_contact');
        
    }



    public function address(){
        
         $this->data['current_page'] = Address::first();
         
        $this->template->load('backend/base', 'backend/cms/address',$this->data);
        
    }

    public function add_address(){
        $data = array(
            'rows' => Address::all(),
            'action' => base_url('backend/admin/save_address')
            );
        
        $this->template->load('backend/base', 'backend/cms/add_update_address',$data);
    }

    public function save_address(){
    Address::create(array(
            'phone' => $this->input->post('phone'),
            'email' => $this->input->post('email'),
            'location' =>$this->input->post('location'),
            'web' => $this->input->post('web')
            ));
        redirect(base_url('address'));
    }
    public function update_address($id=Null){

        $data = array(
            'data' =>  Address::find($id),
            'rows' => Address::all(),
            'action' => base_url('backend/admin/address_update/'.$id)
            );
         $this->template->load('backend/base', 'backend/cms/add_update_address',$data);
        /*$this->load->view('student_view',$data);*/
    }
    public function address_update($id){
     $data = Address::find($id);

        $data->phone = $this->input->post('phone');
        $data->location = $this->input->post('location');
        $data->email = $this->input->post('email');
        $data->web= $this->input->post('web');
        $data->updated_date   = date('Y-m-d h:i:sa');

        $data->save();
       redirect(base_url() . 'address');

    }

    public function content(){
        
         $this->data['current_page'] = Content::first();
        /* print_r($this->data['current_page']); die();*/
        $this->template->load('backend/base', 'backend/cms/content.php',$this->data);
        
    }

    public function add_content(){
        $datas = array(

            'data' => Content::all(),
            'action' => base_url('backend/admin/save_content')
            );
        
        $this->template->load('backend/base', 'backend/cms/add_update_content',$datas);
    }

    public function save_content(){

         $config['upload_path'] = './assets/img/adevetiesment/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('new_img')) {
               $this->session->set_flashdata('error', $this->upload->display_errors() . 'regarding');  
                redirect(base_url() . 'backend/admin/content/' . $action . '/');
            } else {
                $upload_data = $this->upload->data();
                $data['new_img'] = $upload_data['file_name'];
            }
            if (!$this->upload->do_upload('upcomming_img')) {
                redirect(base_url() . 'backend/admin/content/' . $action . '/');
            } else {
                $upload_data = $this->upload->data();
                $data['upcomming_img'] = $upload_data['file_name'];
            }
            if (!$this->upload->do_upload('most_img')) {
                redirect(base_url() . 'backend/admin/content/' . $action . '/');
            } else {
                $upload_data = $this->upload->data();
                $data['most_img'] = $upload_data['file_name'];
            }
    
        
    Content::create(array(
            
            'new' => $this->input->post('new'),
            'upcomming' => $this->input->post('upcomming'),
            'most' =>$this->input->post('most'),
            'created_date'      => date('Y-m-d h:i:sa'),
           
            'new_img' =>  $data['new_img'],
            'upcomming_img' => $data['upcomming_img'],
            'most_img' => $data['most_img']
            
        ));

       redirect(base_url() . 'backend/admin/content');
    }

      public function update_content($id=Null){

        $data = array(
            'data' =>  Content::find($id),
            'rows' => Content::all(),
            'action' => base_url('backend/admin/content_update/'.$id)
            );
         $this->template->load('backend/base', 'backend/cms/add_update_content',$data);
       
    }

    public function content_update($id=Null){


     $contents = Content::find($id);
        $contents->new = $this->input->post('new');
        $contents->upcomming = $this->input->post('upcomming');
        $contents->most = $this->input->post('most');
        $contents->updated_date   = date('Y-m-d h:i:sa');
        $contents->save();


        if ($_FILES['new_img']['tmp_name']) {
            $config['upload_path']          = './assets/img/adevetiesment/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            @unlink($config['upload_path'] . $contents->new_img);
            $config['file_name']            = $contents->id.'_new.jpg';
            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('new_img'))
            {
                print_r($this->upload->display_errors()); die();
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('backend/admin/content', $error);
            }
            else
            {
                $upload_data = $this->upload->data();
                $contents->new_img = $upload_data['file_name'];
                $contents->save();
                }
            }

            if ($_FILES['upcomming_img']['tmp_name']) {
            $config['upload_path']          = './assets/img/adevetiesment/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            @unlink($config['upload_path'] . $contents->upcomming_img);
            $config['file_name']            = $contents->id.'_upcomming.jpg';
            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('upcomming_img'))
            {
                print_r($this->upload->display_errors()); die();
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('backend/admin/content', $error);
            }
            else
            {
                $upload_data = $this->upload->data();
                $contents->upcomming_img = $upload_data['file_name'];
                $contents->save();
                }
            }

            if ($_FILES['most_img']['tmp_name']) {
            $config['upload_path']          = './assets/img/adevetiesment/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            @unlink($config['upload_path'] . $contents->most_img);
            $config['file_name']            = $contents->id.'_most.jpg';
            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('most_img'))
            {
                print_r($this->upload->display_errors()); die();
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('backend/admin/content', $error);
            }
            else
            {
                $upload_data = $this->upload->data();
                $contents->most_img = $upload_data['file_name'];
                $contents->save();
                $this->session->set_flashdata('success', 'content successfully updated');
            }
         }
             redirect(base_url() . 'backend/admin/content');
    }
}
