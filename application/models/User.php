<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Lead
 *
 * @author raakesh
 */
class User extends ActiveRecord\Model {

    //put your code here

    static $has_many = array(
        array('users_groups'),
        array('groups', 'through' => 'users_groups'),
        
    );
    
    static $has_one = array(
        'user_profile'
    );
    
    function get_full_name() {
        return $this->first_name . ' ' . $this->last_name;
    }

    function vendor_area() {
        $zips = VendorArea::all(array("conditions" => array("user_id = ?", $this->id)));
        return $zips;
    }

    function vendor_products() {
        $v_products = Inventory::all(array("conditions" => array("user_id = ?",$this->id)));
        foreach ($v_products as $key => $v_product) {
            $products[] = $v_product->product;
        }
        return $products;
    }

    function product_added() {
        $qty = Inventory::first(array("select" => "sum( total_added ) as total", "conditions" => array("user_id = ?",$this->id)));
        return $qty->total;
    }

    function product_remaining() {
        $qty = Inventory::first(array("select" => "sum( quantities ) as total", "conditions" => array("user_id = ?",$this->id)));
        return $qty->total;
    }

    function product_sold() {
         $sold_pro = OrderDetail::first(array("select" => "sum( quantity ) as quantity , sum( total ) as amount", "conditions" => array("vendor_id = ?",$this->id)));
        return $sold_pro;
    }
}
