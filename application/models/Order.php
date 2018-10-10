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
class Order extends ActiveRecord\Model {

    //put your code here
	static $has_many = array(
		array('order_details')
	);

	static $belongs_to = array(
		array('product_detail' , 'class_name' => 'Product', 'foreign_key' => 'product_id'),
		array('user_detail' , 'class_name' => 'User', 'foreign_key' => 'user_id'),
	);

	function product_booked_bydate($created_at) {
		$product_booked = Order::first(array("select" => "sum( quantity ) as total" , "conditions" => array("created_date = ?", $created_at)));
		return $product_booked->total;
	}

	function vender_products_quantity($vendor_id) {
		$vendor_order_product_count = OrderDetail::first(array("joins" => "JOIN orders o ON o.id = order_details.order_id JOIN products p ON p.id = order_details.product_id","select" => "sum( order_details.quantity ) as total", "group"=> "o.id", "conditions" => array("order_details.vendor_id = ? AND o.id = ?",$vendor_id, $this->id)));
		//print_r(OrderDetail::connection()->last_query); die();
		return $vendor_order_product_count->total;
	}

	function vender_products_price($vendor_id) {
		$vendor_order_product_price = OrderDetail::first(array("joins" => "JOIN orders o ON o.id = order_details.order_id JOIN products p ON p.id = order_details.product_id","select" => "sum( order_details.total ) as total", "group"=> "o.id", "conditions" => array("order_details.vendor_id = ? AND o.id = ?",$vendor_id, $this->id)));
		//print_r(OrderDetail::connection()->last_query); die();
		return $vendor_order_product_price->total;
	}

	function vendor_order_product($vendor_id) {
		$vendor_order_products = OrderDetail::all(array("joins" => "JOIN orders o ON o.id = order_details.order_id JOIN products p ON p.id = order_details.product_id", "conditions" => array("order_details.vendor_id = ? AND o.id = ?",$vendor_id, $this->id)));
		return $vendor_order_products;
	}

}
