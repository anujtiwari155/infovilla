<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Lead
 *
 * @author Abhishek
 */
class VendorArea extends ActiveRecord\Model {

	function vendor_products($frontend = null) {
        $v_products = Inventory::all(array("conditions" => array("user_id = ?",$this->user_id)));

        if( $v_products != null && is_array($v_products)) {
            foreach ($v_products as $key => $v_product) {
                $products[] = $v_product->product;
                $price[] 	= $v_product->mrp;
            }
            if ($frontend != null && $products != null) {
            	return array("products" => $products , "prices" => $price);
            } else {
            	return $products;
            }
        
        }

}
}
