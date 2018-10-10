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
class OrderDetail extends ActiveRecord\Model {

    //put your code here
	static $has_many = array(
		//array('products')
	);

	static $belongs_to = array(
		'order',
		array('product_order_detail' , 'class_name' => 'Product', 'foreign_key' => 'product_id'),
		//array('user_detail' , 'class_name' => 'User', 'foreign_key' => 'user_id'),
	);

	function order_vendor() {
		try {
			$vendor = User::find($this->vendor_id);
		} catch (ActiveRecord\ActiveRecordException $ex) {
			$vendor = NULL;
		}
		if ($vendor) {
			return $vendor->email;
		} else {
			return "";
		}
	}
}
