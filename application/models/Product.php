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
class Product extends ActiveRecord\Model {

    //put your code here

    static $has_many = array(
        array('product_images'),
        array('product_attributes'),
        array('product_categories'),
        array('inventories')
    );
    static $belongs_to = array(
        array('brand_name', 'class_name' => 'Brand', 'foreign_key' => 'brand_id'),
    	array('vendor', 'class_name' => 'User', 'foreign_key' => 'added_by')
    );
    static $has_one = array(
       // array('inventory')        
    );

    function quantity_added($vendor_id) {
        $qty = Inventory::first(array("select" => "sum( total_added ) as total", "conditions" => array("product_id = ? AND user_id = ?",$this->id, $vendor_id)));
        return $qty->total;
    }

    function product_vendor() {
        $vendors = Inventory::all(array("conditions" => array("product_id = ? AND quantities >= '1'",$this->id)));
        return $vendors;
    }

    function product_sold($vendor_id) {
        $sold_pro = OrderDetail::first(array("select" => "sum( quantity ) as quantity , sum( total ) as amount", "conditions" => array("product_id = ? AND vendor_id = ?",$this->id,$vendor_id)));
        return $sold_pro;
    }

    function product_min_price($area_zip = null) {
        try {
            $vendors = VendorArea::all(array("conditions" => array("zip_code = ? ",$area_zip)));
        } catch (ActiveRecord\ActiveRecordException $ex) {
            $vendors = null;
        }
        $inventory =  '';
        if($vendors) {
            foreach ($vendors as $key => $vendor) {
                $vendor_ids[] = $vendor->user_id;
            }
            $vendor_ids = array_unique($vendor_ids);
            $_vendor_ids = implode("','",$vendor_ids);
            $inventory = Inventory::first(array("select" => "min( mrp ) as mrp, user_id as vendor_id", "conditions" => array("product_id = ? AND user_id IN ('".$_vendor_ids."')", $this->id)));
        }
            
        //$inventory = Inventory::first(array("select" => "min( mrp ) as mrp, user_id as vendor_id", "conditions" => array("product_id = ? ", $this->id)));
        return $inventory;
    }
}
