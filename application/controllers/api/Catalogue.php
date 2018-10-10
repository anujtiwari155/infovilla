<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Auth
 *
 * @author abhishek
 */
class Catalogue extends MY_APIController {

    function __construct() {
        parent::__construct();
    }

    public function list_category_get() {
        /*$user = $this->is_customer_logged_in();
        if (!$user) {
            $this->response([
                'status' => FALSE,
                'response' => 'Login Session Expired. Please Login Again',
                'code' => $this->response_codes['SESS_EXPIRE']
                    ], REST_Controller::HTTP_FORBIDDEN);
        }*/
        $response = array();
        $categories = Category::all(array('conditions' => array('active = 1 AND lavel = 0')));
        
        foreach ($categories as $key => $category) {
            $response[] = array(
                'id'   => $category->id,
                'name' => $category->name,
                'parent_id' => $category->parent_id,
                'category_code' => $category->category_code,
                'lavel'     => $category->lavel,
                'slug'     => $category->slug,
                ); 
        }
        $this->response([
            'status' => TRUE,
            'response' => $response,
            'code' => $this->response_codes['SUCCESS']
                ], REST_Controller::HTTP_OK);
    }

    public function sub_category_get() {
        $response = array();
        $categories = Category::all(array("conditions" => array('active = 1 AND parent_id = ?',$this->input->get('c_id'))));
        foreach ($categories as $key => $category) {
            $response[] = array(
                'id'   => $category->id,
                'name' => $category->name,
                'parent_id' => $category->parent_id,
                'category_code' => $category->category_code,
                'lavel'     => $category->lavel,
                'slug'     => $category->slug,
                ); 
        }
        $this->response([
            'status' => TRUE,
            'response' => $response,
            'code' => $this->response_codes['SUCCESS']
                ], REST_Controller::HTTP_OK);
    }

    function list_brand_get() {
        $response = array();
        $brands = Brand::all(array('conditions' => array('active = 1 ')));
        
        foreach ($brands as $key => $brand) {
            $response[] = array(
                'id'   => $brand->id,
                'name' => $brand->name,
                'brand_code' => $brand->code,
                'slug'     => $brand->slug,
                ); 
        }
        $this->response([
            'status' => TRUE,
            'response' => $response,
            'code' => $this->response_codes['SUCCESS']
                ], REST_Controller::HTTP_OK);
    }
}
