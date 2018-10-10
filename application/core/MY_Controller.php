<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_Controller
 *
 * @author Abhishek
 */
class MY_Controller extends CI_Controller {

    //put your code here
    public $payment_modes = array();
    public $user;
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->user = ($this->ion_auth->logged_in()) ? $this->ion_auth->user()->row() : NULL;
        $this->load->library('cart');
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
    public function check_user() {
        if ($this->ion_auth->logged_in() && $this->ion_auth->user()->row()) {
            $this->data['login_user'] = $this->user;
            $current_user_details = User::find($this->data['login_user']->id);
            $this->data['current_user_details'] = $current_user_details;
        }else {
            $this->data['login_user'] = "Guest";    
        }
    }
    
    public function check_user_area($area_zip = null) {
        if ($area_zip) {
            $this->data["user_area_zip"] = $area_zip;
            return $this->data["user_area_zip"];
        } elseif(isset($this->session->user_area_zip)) {
            return $this->session->user_area_zip;
        } else {
            return 0;
        }
         die();
    }

    public function get_search_list() {
        $all_brands  = Brand::all(array('conditions' => array("active = '1'")));
        $all_categories = $this->get_categories('active = 1');
        $all_products = Product::all(array('conditions' => array("active = '1'")));

        //$search_key_words = array_merge($all_brands,$all_categories,$all_products);
        foreach ($all_brands as $brand) {
            $key[] = str_replace("'",' ',$brand->name.' - Brand');
        }
        foreach ($all_categories as $category) {
            $key[] = str_replace("'",' ',$category->name.' - Category');
        }
        foreach ($all_products as $product) {
            $key[] = str_replace("'",' ',$product->name.' - Product');
        }
        return implode("','",$key);
    }

    public function get_menu_list() {
        $this->data = array(
            'categories_0' => $this->get_categories('lavel = 0'),
            'categories_1' => $this->get_categories('lavel = 1'),
            'categories_2' => $this->get_categories('lavel = 2'),
            'products'     => $this->get_products('status = 1'),
            'brand_list'   => $this->get_brands('active = 1'),
            
            'key_words'    => $this->get_search_list(),
            'pages'        => Page::all()
            /*'products'     => $this->get_products(' = 1'),
            'brand_list'   => $this->get_brands('active = 1')*/

            );
    }

    public function get_categories($conditions = '') {
        return Category::all(array('conditions' => array($conditions . ' AND active = 1')));
    }

    public function get_products($conditions = '') {
        if (isset($this->session->user_area_zip) && $this->session->user_area_zip != 0) {
            $area_zip_code = $this->session->user_area_zip;
            try {
                $vendors = VendorArea::all(array("conditions" => array("zip_code = ? ",$area_zip_code)));
            } catch (ActiveRecord\ActiveRecordException $ex) {
                $vendors = null;
            }
            if ($vendors) {
                  $products_list = array();
                  foreach ($vendors as $key => $vendor) {
                    $products_list[] = $vendor->vendor_products(1);
                  }
                  $a_product_ids = array();
                  foreach ($products_list as $key => $products) {
                    foreach ($products['products'] as $key => $product) {
                        $a_product_ids[] = $product->id;
                    }
                  }
                  if (isset($a_product_ids[0])) {
                    $product_ids_area = array_unique($a_product_ids);
                    $area_product_ids = implode("','",$product_ids_area);
                  }
                  return Product::all(array('conditions' => array($conditions ." AND active = 1 AND id IN ('".$area_product_ids."')"), 'limit' => '8', 'order'=> 'created_at desc'));
            } else {
                return "PIN / ZIP is Wrong or No products in this Area ";
            }
              
        }
        return Product::all(array('conditions' => array($conditions .' AND active = 1'), 'limit' => '8', 'order'=> 'created_at desc'));
    }

    public function get_brands($conditions = '') {
        return Brand::all(array('conditions' => array($conditions .' AND active = 1'), 'limit' => '7', 'order'=> 'created_at desc'));
    }

    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

   
}


 require APPPATH . '/libraries/REST_Controller.php';

class MY_APIController extends REST_Controller {

    //put your code here
    function __construct() {
        parent::__construct();
        $this->response_codes = array(
            'SUCCESS' => 100, // Response is successful
            'AUTH_FAIL' => 101, // Authentication failure
            'INVAL_PARAM' => 102, // Invalid parameters
            'FAILED' => 104, // Request Failed
            'SESS_EXPIRE' => 103
        );
        $this->load->library('cart');
        $this->load->library(array('ion_auth'));
        $this->load->driver('cache');
    }

    function generate_token($email) {
        return md5(uniqid($email));
    }

    function set_token($user) {
        $auth_token = $this->generate_token($user->email);
        $this->cache->redis->save($auth_token, $user, 30 * 24 * 60 * 60);
        return $auth_token;
    }

    function is_logged_in() {
        $auth_token = $this->input->get_request_header('Authentication-Token', TRUE);
        $user = $this->cache->redis->get($auth_token);
        if ($user) {
            return $user;
        }
        return FALSE;
    }

    function is_customer_logged_in() {
        $auth_token = $this->input->get_request_header('Authentication-Token', TRUE);
        $user = $this->cache->redis->get($auth_token);

        if ($user and $user->groups[0]->name == 'customer') {
            return $user;
        }
        return FALSE;
    }

    function destroy_token() {
        $auth_token = $this->input->get_request_header('Authentication-Token', TRUE);

        if ($this->cache->redis->delete($auth_token)) {
            return TRUE;
        }
        return FALSE;
    }

    function set_custom_token($key, $data) {
        $this->cache->redis->save($key, $data, 24 * 60 * 60);
    }

    function get_custom_token($key) {
        return $this->cache->redis->get($key);
    }

    function update_custom_token($key, $data) {
        $stored_data = $this->cache->redis->get($key);
        array_merge($stored_data, $data);
        $this->cache->redis->save($key, $stored_data, 24 * 60 * 60);
    }

    function send_notification($recipient, $message) {
        $content = array(
            "en" => $message
        );

        $fields = array(
            'app_id' => "83843c45-c43b-43ef-9d17-add9d9eebe63",
            //'included_segments' => array('All'),            
            'contents' => $content,
            'include_player_ids' => $recipient
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
            'Authorization: Basic YTNmNWU5MDAtYjYyNS00MjA2LWE3YjEtMGM2ODE1YzZhMmQ4'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
