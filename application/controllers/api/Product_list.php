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
class Product_list extends MY_APIController {

    //put your code here
    function __construct() {
        parent::__construct();
    }

    function list_top_product_get() {
    	$response = array();
    	$zip_code = $this->input->get('zip_code');
    	$vendors = VendorArea::all(array("conditions" => array("zip_code = ? ",$zip_code)));
    	$products_list = array();
    	foreach ($vendors as $key => $vendor) {
    		$products_list[] = $vendor->vendor_products();
    	}
        $unique_products = array();
        foreach ($products_list as $key => $products) {
	        foreach ($products as $key => $product) {
	        	if ($product->active == 1 && $product->status == 1) {
		        	if (!in_array( $product->id , $unique_products)) {
			        	$unique_products[] = $product->id;
			        	$quantity_check = 0;
						if(isset($product_details->inventories[0])) { 
							foreach ($product_details->inventories as $key => $value) {
								if ($value->quantities > 0 ) {
									$quantity_check = 1;
									break;
								}
							}
						}
			            $response[] = array(
			                'id'       => $product->id,
			                'name'     => $product->name,
			                'mrp'      => $product->mrp,
			                'slug'     => $product->slug,
			                'description' => $product->description,
			                'inventory' => $quantity_check,
			                'img_url'  => base_url('assets/products/').'/'.$product->product_images[0]->product_image->image_url
			            ); 
			       	}
			    }
    		}
    	}
    	if (isset($response[0])) {
    		$this->response([
	            'status' => TRUE,
	            'response' => $response,
	            'code' => $this->response_codes['SUCCESS']
	                ], REST_Controller::HTTP_OK);
    	} else{
    		$this->response([
	            'status' => FALSE,
	            'response' => 'No Products Avilable',
	            'code' => $this->response_codes['SUCCESS']
	                ], REST_Controller::HTTP_OK);
    	}
	        
    }

    function product_details_get() {
    	$response = array();
    	$product_id = $this->input->get('product_id');

    	try {
			$product_details = Product::find($product_id);
		} catch (ActiveRecord\ActiveRecordException $ex) {
			$product_details = NULL;
		}
		if($product_details) {
			$quantity_check = 0;
			if(isset($product_details->inventories[0])) { 
				foreach ($product_details->inventories as $key => $value) {
					if ($value->quantities > 0 ) {
						$quantity_check = 1;
						break;
					}
				}
			}
			$response = array(
	    		'name' => $product_details->name,
	    		'brand' => $product_details->brand_name->name,
	    		'inventory' => $quantity_check,
	    		'description' => $product_details->description,
	    		'mrp'		  => $product_details->mrp,
	    		'slug' 		  => $product_details->slug,
	    		'img' => array(),
	    		'category' => array(),
	    		'attributes' => array()
	    	);
	    	foreach ($product_details->product_attributes as $key => $attribute_one) {
				$response['attributes'][$attribute_one->attributes->parent_attr->name] = $attribute_one->attributes->value;
			} 
			foreach ($product_details->product_categories as $key => $category) {
				$response['category']['cat'.$key] = $category->category->name;
			}
	    	foreach ($product_details->product_images as $key => $image) {
	    		$response['img']['pro_img'.$key] = base_url('assets/products/').'/'.$image->product_image->image_url;
	    	}
	    	$this->response([
	            'status' => TRUE,
	            'response' => $response,
	            'code' => $this->response_codes['SUCCESS']
	                ], REST_Controller::HTTP_OK);
		} else {
			$this->response([
	            'status' => FALSE,
	            'response' => 'Invalid Product',
	            'code' => $this->response_codes['FAILED']
                ], REST_Controller::HTTP_BAD_REQUEST);
		}
    }

    function list_product_get($case = '') {
    	$response = array();
    	$zip_code = $this->input->get('zip_code');
    	$vendors = VendorArea::all(array("conditions" => array("zip_code = ? ",$zip_code)));
    	$products_list = array();
    	foreach ($vendors as $key => $vendor) {
    		$products_list[] = $vendor->vendor_products();
    	}
    	$product_ids = array();
    	foreach ($products_list as $key => $products) {
    		foreach ($products as $key => $product) {
    			$product_ids[] = $product->id;
    		}
    	}
    	if (isset($product_ids[0])) {
    		$product_ids_ary = array_unique($product_ids);
    		$product_ids = implode("','",$product_ids_ary);
    	} else {
    		$this->response([
	            'status' => FALSE,
	            'response' => "No Product in this Area",
	            'code' => $this->response_codes['SUCCESS']
	                ], REST_Controller::HTTP_OK);
    	}
    	
    	/*print_r($product_ids);
    	die();*/
    	switch ($case) {
    		case 'brand':
    			try {
					$brand_products = Product::all(array("conditions" => array("brand_id = ? AND active = '1' AND status = '1' AND id IN ('".$product_ids."')",$this->input->get('brand_id'))));
    			} catch (ActiveRecord\ActiveRecordException $ex) {
    				$brand_products = NULL;
    			}
    			
    			if ($brand_products) {
    				$quantity_check = 0;
    				foreach ($brand_products as $key => $product) {
    					$quantity_check = 0;
						if(isset($product->inventories[0])) { 
							foreach ($product->inventories as $key => $value) {
								if ($value->quantities > 0 ) {
									$quantity_check = 1;
									break;
								}
							}
						}
			            $response[] = array(
			                'id'       => $product->id,
			                'name'     => $product->name,
			                'mrp'      => $product->mrp,
			                'slug'     => $product->slug,
			                'description' => $product->description,
			                'inventory' => $quantity_check,
			                'img_url'  => base_url('assets/products/').'/'.$product->product_images[0]->product_image->image_url
			                ); 
			        }
			        if (isset($response[0])) {
			        	$this->response([
				            'status' => TRUE,
				            'response' => $response,
				            'code' => $this->response_codes['SUCCESS']
				                ], REST_Controller::HTTP_OK);
			        } else {
			        	$this->response([
				            'status' => FALSE,
				            'response' => 'No Products Avilable',
				            'code' => $this->response_codes['SUCCESS']
				                ], REST_Controller::HTTP_OK);
			        }
				        
    			} else {
    				$this->response([
			            'status' => FALSE,
			            'response' => "No Product in this Brand",
			            'code' => $this->response_codes['SUCCESS']
			                ], REST_Controller::HTTP_OK);
    			}
    			break;
    		case 'category':
    			try {
    				$products = ProductCategory::all(array("conditions" => array("category_id = ?",$this->input->get('category_id'))));
    			} catch (ActiveRecord\ActiveRecordException $ex) {
    				$products = NULL;
    			}
    			if ($products) {
    				$product_ids = array();
			        foreach ($products as $product) {
			        	$product_c_ids[] = $product->product_id;
			        }
			        $product_ids = array_merge($product_ids_ary,$product_c_ids);
			        $product_ids = join("','", array_unique($product_ids));
	  				$final_products = Product::all(array("conditions" => array("products.id IN ('".$product_ids."') AND active = '1' AND status = '1'")));
    				
    				foreach ($final_products as $key => $product) {
    					$quantity_check = 0;
						if(isset($product->inventories[0])) { 
							foreach ($product->inventories as $key => $value) {
								if ($value->quantities > 0 ) {
									$quantity_check = 1;
									break;
								}
							}
						}
			            $response[] = array(
			                'id'       => $product->id,
			                'name'     => $product->name,
			                'mrp'      => $product->mrp,
			                'slug'     => $product->slug,
			                'description' => $product->description,
			                'inventory' => $quantity_check,
			                'img_url'  => base_url('assets/products/').'/'.$product->product_images[0]->product_image->image_url
			                ); 
			        }
			        if (isset($response[0])) {
			        	$this->response([
				            'status' => TRUE,
				            'response' => $response,
				            'code' => $this->response_codes['SUCCESS']
				                ], REST_Controller::HTTP_OK);
			        } else {
			        	$this->response([
				            'status' => FALSE,
				            'response' => 'No Products Avilable',
				            'code' => $this->response_codes['SUCCESS']
				                ], REST_Controller::HTTP_OK);
			        }
    			} else {
    				$this->response([
			            'status' => FALSE,
			            'response' => "No Product in this Category",
			            'code' => $this->response_codes['SUCCESS']
			                ], REST_Controller::HTTP_OK);
    			}   			
    		break;
    		default:
    			# code...
    			break;
    	}
    }

    function validate_cart_product_post() {
    	$request = json_decode($this->input->raw_input_stream);
    	$response = array();
    	$zip_code = $request->zip_code;
    	$cart_products = $request->cart_products;
    	foreach ($cart_products as $cart_product) {
			$response[] = $this->validate_pin_post($zip_code,$cart_product);
		}
		$this->response([
            'status' => TRUE,
            'response' => $response,
            'code' => $this->response_codes['SUCCESS']
                ], REST_Controller::HTTP_OK);
    }

    function checkout_post() {
    	/*$user = $this->is_customer_logged_in();
        if (!$user) {
            $this->response([
                'status' => FALSE,
                'response' => 'Login Session Expired. Please Login Again',
                'code' => $this->response_codes['SESS_EXPIRE']
                    ], REST_Controller::HTTP_FORBIDDEN);
        }*/
        $request = json_decode($this->input->raw_input_stream);

        //$total_bill = ($this->cart->total() * 1/10) + $this->cart->total() + 100;
		//print_r($this->session->first_name); die();
		$order = Order::create(array(
			'order_id'			=> $this->generateRandomString(),
			//'quantity'		=> $this->cart->total_items(),
			'user_id'			=> 125,
			'shipping_name'		=> $request->first_name." ".$request->last_name,
			'shipping_address1' => $request->address1,
			'shipping_address2' => $request->address2,
			'shipping_city'		=> $request->city,
			'shipping_state'	=> $request->state,
			'shipping_zip'		=> $request->zip,
			'shipping_phone'	=> $request->phone,
			'shipping_email'	=> $request->email,
			//'sub_total'			=> $this->cart->total(),
			'order_shipping'	=> 100,
			'order_tax'			=> 10,
			//'order_total'		=> $total_bill,
			'payment_method'	=> 'COD',
			'payment_status'	=> 1,
			'created_date'		=> date('Y-m-d'),
			'active'			=> 1
			));
		$product_list_ids = array();
		$order_total = $order_quantity = 0;
		$cart_products = $request->products;
		foreach ($cart_products as $cart_product) {
			try {
				$product_update = Inventory::first(array("conditions" => array("product_id = ? AND user_id = ? ",$cart_product->p_id,$cart_product->vendor_id)));
			} catch (ActiveRecord\ActiveRecordException $ex) {
				$product_update = null;
			}
			if ($product_update) {
				$product_update->quantities = $product_update->quantities - $cart_product->p_qty;
				$product_update->save();
				$sold_product = Product::find($cart_product->p_id);
				$cp = $sold_product->cost_price;
				$sp = $sold_product->mrp;
				$profit = ($sp - $cp) * $cart_product->p_qty;
				$product_list_ids[] = array(
					'id' 	   => $cart_product->p_id,
					'quantity' => $cart_product->p_qty
					);
				OrderDetail::create(array(
					'product_id'			=>  $cart_product->p_id,
					'vendor_id'				=>  $cart_product->vendor_id,
					'order_id'				=>	$order->id,
					'quantity'				=>	$cart_product->p_qty,
					'price'					=> 	$sp,
					'profit'				=>  $profit,
					'total'					=> 	$sp*$cart_product->p_qty,
					'created_date'			=>  date('Y-m-d')
				));
				$order_total = $order_total + $sp;
				$order_quantity = $order_quantity + $cart_product->p_qty;
			}
		}
		$total_cost = 0;
		foreach ($product_list_ids as $product_list_id) {
			$_product = Product::find($product_list_id['id']);
			$product_cp = ($_product->cost_price * $product_list_id['quantity']);
			$total_cost = $total_cost + $product_cp;
		}
		$order->order_total = $order_total;
		$order->sub_total = $order_total;
		$order->quantity = $order_quantity;
		$order->order_profit = $order_total - $total_cost;  // subtract shipping charge and totalcost
		$order->save();
		/*foreach ($this->cart->contents() as $items) {
			$product_update = Inventory::find_by_product_id($items['id']);
			$product_update->quantities = $product_update->quantities - $items['qty'];
			$product_update->save();
			$sold_product = Product::find($items['id']);
			$cp = $sold_product->cost_price;
			$sp = $sold_product->mrp;
			$profit = ($sp - $cp) * $items['qty'];
			$product_list_ids[] = array(
				'id' 	   => $items['id'],
				'quantity' => $items['qty']
				);
			OrderDetail::create(array(
				'product_id'			=>  $items['id'],
				'order_id'				=>	$order->id,
				'quantity'				=>	$items['qty'],
				'price'					=> 	$items['price'],
				'profit'				=>  $profit,
				'total'					=> 	$items['subtotal'],
				'created_date'			=>  date('Y-m-d')
			));
		}
		$total_cost = 0;
		foreach ($product_list_ids as $product_list_id) {
			$_product = Product::find($product_list_id['id']);
			$product_cp = ($_product->cost_price * $product_list_id['quantity']);
			$total_cost = $total_cost + $product_cp;
		}
		$order->order_profit = $total_bill - $total_cost - 100;  // subtract shipping charge and totalcost
		$order->save();*/
		/*$this->empty_cart();*/
		$this->response([
            'status' => TRUE,
            'order_id' => $order->order_id,
            'response' => "Your Order has been Placed",
            'code' => $this->response_codes['SUCCESS']
                ], REST_Controller::HTTP_OK);
    }

    function filter_products_post() {
    	$response = array();
    	$request = json_decode($this->input->raw_input_stream);

    	$zip_code = $request->zip_code;
    	$vendors = VendorArea::all(array("conditions" => array("zip_code = ? ",$zip_code)));
    	$products_list = array();
    	foreach ($vendors as $key => $vendor) {
    		$products_list[] = $vendor->vendor_products();
    	}
    	$product_ids = array();
    	foreach ($products_list as $key => $products) {
    		foreach ($products as $key => $product) {
    			$product_ids[] = $product->id;
    		}
    	}
    	if (isset($product_ids[0])) {
    		$product_ids_ary = array_unique($product_ids);
    		$product_ids = implode("','",$product_ids_ary);
    	} else {
    		$this->response([
	            'status' => FALSE,
	            'response' => "No Product in this Category",
	            'code' => $this->response_codes['SUCCESS']
	                ], REST_Controller::HTTP_OK);
    	}

    	$case = $request->filter_type;
    	$conditions = array();
    	if (isset($request->min_price) && $request->min_price != '') {
			array_push($conditions, "AND products.mrp >= ".$request->min_price);
		}
		if (isset($request->attributes) && is_array($request->attributes)) {
			foreach ($request->attributes as $key => $attribute_value) {
				$product_attr[] = $attribute_value;
			}
			if (isset($product_attr) && is_array($product_attr)) {
				$product_attr = implode("','", $product_attr);
			}
			array_push($conditions, "AND pa.attribute_value_id IN ('".$product_attr."')");
		}

		$conditions = implode(" ", $conditions);

    	switch ($case) {
    		case 'brand':
    			try {
					$brand_products = Product::all(array("joins" => "JOIN product_attributes pa ON pa.product_id = products.id","group"=>"products.id", "conditions" => array("products.id IN ('".$product_ids."') AND brand_id = ? AND active = '1' AND status = '1'". $conditions,$request->type_id)));
    			} catch (ActiveRecord\ActiveRecordException $ex) {
    				$brand_products = NULL;
    			}
    			if ($brand_products) {
    				foreach ($brand_products as $key => $product) {
    					$quantity_check = 0;
						if(isset($product->inventories[0])) { 
							foreach ($product->inventories as $key => $value) {
								if ($value->quantities > 0 ) {
									$quantity_check = 1;
									break;
								}
							}
						}
			            $response[] = array(
			                'id'       => $product->id,
			                'name'     => $product->name,
			                'mrp'      => $product->mrp,
			                'slug'     => $product->slug,
			                'description' => $product->description,
			                'inventory' => $quantity_check,
			                'img_url'  => base_url('assets/products/').'/'.$product->product_images[0]->product_image->image_url
			                ); 
			        }
			        if (isset($response[0])) {
			        	$this->response([
				            'status' => TRUE,
				            'response' => $response,
				            'code' => $this->response_codes['SUCCESS']
				                ], REST_Controller::HTTP_OK);
			        } else {
			        	$this->response([
				            'status' => FALSE,
				            'response' => 'No Products Avilable',
				            'code' => $this->response_codes['SUCCESS']
				                ], REST_Controller::HTTP_OK);
			        }
    			} else {
    				$this->response([
			            'status' => FALSE,
			            'message' => "No Product in this Brand",
			            'code' => $this->response_codes['SUCCESS']
			                ], REST_Controller::HTTP_OK);
    			}
    		break;
    		case 'category':
    			try {
    				$products = ProductCategory::all(array("conditions" => array("category_id = ?",$request->type_id)));
    			} catch (ActiveRecord\ActiveRecordException $ex) {
    				$products = NULL;
    			}
    			if ($products) {
    				$product_ids = array();
			        foreach ($products as $product) {
			        	$product_ids[] = $product->product_id;
			        }
			        $product_ids = join("','", array_unique($product_ids));
	  				$final_products = Product::all(array("joins" => "JOIN product_attributes pa ON pa.product_id = products.id", "group"=>"products.id", "conditions" => array("id IN ('".$product_ids."') AND products.id IN ('".$product_ids."') AND active = '1' AND status = '1'".$conditions)));
    				
    				foreach ($final_products as $key => $product) {
    					$quantity_check = 0;
						if(isset($product->inventories[0])) { 
							foreach ($product->inventories as $key => $value) {
								if ($value->quantities > 0 ) {
									$quantity_check = 1;
									break;
								}
							}
						}
			            $response[] = array(
			                'id'       => $product->id,
			                'name'     => $product->name,
			                'mrp'      => $product->mrp,
			                'slug'     => $product->slug,
			                'description' => $product->description,
			                'inventory' => $quantity_check,
			                'img_url'  => base_url('assets/products/').'/'.$product->product_images[0]->product_image->image_url
			                ); 
			        }
			        if (isset($response[0])) {
			        	$this->response([
				            'status' => TRUE,
				            'response' => $response,
				            'code' => $this->response_codes['SUCCESS']
				                ], REST_Controller::HTTP_OK);
			        } else {
			        	$this->response([
				            'status' => FALSE,
				            'response' => 'No Products Avilable',
				            'code' => $this->response_codes['SUCCESS']
				                ], REST_Controller::HTTP_OK);
			        }
    			} else {
    				$this->response([
			            'status' => FALSE,
			            'message' => "No Product in this Category",
			            'code' => $this->response_codes['SUCCESS']
			                ], REST_Controller::HTTP_OK);
    			}   			
    		break;
    		case 'search':
    			$response = array();
    			$key = $request->key;
    			try {
					$products = Product::all(array("select" => "id , name", "group"=>"products.id", "conditions" => array("id IN ('".$product_ids."') AND active = '1' AND  ( name LIKE '%".$key."%' OR slug LIKE '%".$key."%' ) AND status = '1'")));
    			} catch (ActiveRecord\ActiveRecordException $ex) {
    				$products = NULL;
    			}
    			
    			if ($products) {
    				foreach ($products as $key => $product) {
    					$response[] = array(
    						'id' => $product->id,
    						'name' => $product->name
    					);
    				}
    				if (isset($response[0])) {
			        	$this->response([
				            'status' => TRUE,
				            'response' => $response,
				            'code' => $this->response_codes['SUCCESS']
				                ], REST_Controller::HTTP_OK);
			        } else {
			        	$this->response([
				            'status' => FALSE,
				            'response' => 'No Products Avilable',
				            'code' => $this->response_codes['SUCCESS']
				                ], REST_Controller::HTTP_OK);
			        }
    			} else {
    				$this->response([
			            'status' => FALSE,
			            'message' => 'Sorry No product found',
			            'code' => $this->response_codes['SUCCESS']
			                ], REST_Controller::HTTP_OK);
    			}
    		break;
    	}
    }

    function load_filters_get() {
    	$response = array();
    	$attributes = Attribute::all(array("conditions" => array("active = '1'")));
    	foreach ($attributes as $key => $attribute) {
    		foreach ($attribute->attribute_values as $key => $attribute_value) {
    			//$response[$attribute->name][$attribute_value->id] =  $attribute_value->value;
    			/*$response[$attribute->name][] = array(
    				$attribute->name => $attribute_value->id." ".$attribute_value->value
    			);*/
    			$response[] = array(
    				'title' => $attribute->name,
    				'id'    => $attribute_value->id,
    				'value' => $attribute_value->value
    				);
    		}
    	}
    	$abc[] = $response ;
    	$this->response([
            'status' => TRUE,
            'response' => $response,
            'code' => $this->response_codes['SUCCESS']
                ], REST_Controller::HTTP_OK);
    }

    function validate_pin_post($zip = null, $_product_id = null) {
    	if (!$_product_id) {
    		$request = json_decode($this->input->raw_input_stream);
    		$input_zip = $request->zip;
			$product_id = $request->product_id;
    	} else {
    		$input_zip = $zip;
    		$product_id = $_product_id;
    	}
		try{
			$product = Product::find($product_id);
		} catch (ActiveRecord\ActiveRecordException $ex) {
			$product = null;
		}
		$zips = array();
		if ($product) {
			$pro_vendors = $product->product_vendor();
			foreach ($pro_vendors as $key => $pro_vendor) {
				if (is_array($pro_vendor->pro_vendor->vendor_area())) {
					foreach ($pro_vendor->pro_vendor->vendor_area() as $key => $zip) {
						if ($input_zip == $zip->zip_code) {
							$avilable_vendor[] = $zip->user_id;
						}
					}
				}
			}
			if (isset($avilable_vendor)) {
				if($_product_id) {
					shuffle($avilable_vendor);
					return array("vendor_id"=>$avilable_vendor[0], "product_id"=> $_product_id, "is_vendor"=> TRUE);
				}else {
					$this->response([
			            'status' => TRUE,
			            'response' => $avilable_vendor,
			            'code' => $this->response_codes['SUCCESS']
			                ], REST_Controller::HTTP_OK);
				}
			} else {
				if($_product_id) {
					return array("vendor_id"=>null, "product_id"=> $_product_id, "is_vendor"=> FALSE);
				} else {
				$this->response([
		            'status' => FALSE,
		            'response' => 'Sorry No Vendor avilable in this area',
		            'code' => $this->response_codes['SUCCESS']
		                ], REST_Controller::HTTP_OK);
				}
			}
		} else {
			if($_product_id) {
				return array("vendor_id"=>null, "product_id"=> $_product_id, "is_vendor"=> FALSE);
			}else {
				$this->response([
		            'status' => FALSE,
		            'response' => "No product avilable",
		            'code' => $this->response_codes['SUCCESS']
		                ], REST_Controller::HTTP_OK);
			}
		}
    }

    function add_to_cart_post() {
    	$request = json_decode($this->input->raw_input_stream);
    	//print_r($request->cart_products);
    	/*foreach ($request->cart_products as $key => $product) {*/
    		try {
    			$check_cart = AppCart::first(array("conditions" => array("device_id = ? AND product_id = ?",$request->device_id,$request->p_id)));
    		} catch (ActiveRecord\ActiveRecordException $ex) {
    			$check_cart = null;
    		}
    		
    		if ($check_cart) {
    			$check_cart->quantity = $request->p_qty;
    			$check_cart->save();

    			$this->response([
	            'status' => TRUE,
	            'response' => "Product Added in cart",
	            'code' => $this->response_codes['SUCCESS']
	                ], REST_Controller::HTTP_OK);
    		} else {
    			$app_cart = AppCart::create(array(
		    		'device_id' => $request->device_id,
		    		'product_id' => $request->p_id,
		    		'quantity'	 => $request->p_qty
		    	));
		    	$this->response([
	            'status' => TRUE,
	            'response' => "Product Added in cart",
	            'code' => $this->response_codes['SUCCESS']
	                ], REST_Controller::HTTP_OK);
    		}
    }

    function edit_cart_post($case = null) {
    	$request = json_decode($this->input->raw_input_stream);
    	switch ($case) {
    		case 'remove_row':
    			try {
	    			$check_cart = AppCart::all(array("conditions" => array("device_id = ? AND product_id = ?",$request->device_id,$request->p_id)));
	    		} catch (ActiveRecord\ActiveRecordException $ex) {
	    			$check_cart = null;
	    		}
	    		if ($check_cart) {
	    			foreach ($check_cart as $key => $l_cart) {
	    				$l_cart->delete();
	    			}
	    			$this->response([
			            'status' => TRUE,
			            'response' => "Product removed from Cart",
			            'code' => $this->response_codes['SUCCESS']
			                ], REST_Controller::HTTP_OK);
	    		} else {
	    			$this->response([
			            'status' => FALSE,
			            'response' => "No product to remove",
			            'code' => $this->response_codes['SUCCESS']
			                ], REST_Controller::HTTP_OK);
	    		}
    		break;
    		case 'clear_cart':
    			try {
	    			$check_cart = AppCart::delete_all(array("conditions" => array("device_id = ?",$request->device_id)));
	    		} catch (ActiveRecord\ActiveRecordException $ex) {
	    			$check_cart = null;
	    		}
	    		if ($check_cart) {
	    			$this->response([
			            'status' => TRUE,
			            'response' => "Cart Cleared",
			            'code' => $this->response_codes['SUCCESS']
			                ], REST_Controller::HTTP_OK);
	    		} else {
	    			$this->response([
			            'status' => TRUE,
			            'response' => "No product to remove",
			            'code' => $this->response_codes['SUCCESS']
			                ], REST_Controller::HTTP_OK);
	    		}
    		break;
    	}
    }

    function view_cart_post() {
    	$request = json_decode($this->input->raw_input_stream);

    	try {
    		$cart_products = AppCart::all(array("conditions" => array("device_id = ?",$request->device_id)));
    	} catch (ActiveRecord\ActiveRecordException $e) {
    		$cart_products = null;
    	}
    	$response = array();
    	if ($cart_products) {
    		$total = 0;
    		foreach ($cart_products as $key => $cart_product) {
    			try {
					$product_details = Product::find($cart_product->product_id);
				} catch (ActiveRecord\ActiveRecordException $ex) {
					$product_details = NULL;
				}
				if ($product_details) {
					$quantity_check = 0;
					if(isset($product_details->inventories[0])) { 
						foreach ($product_details->inventories as $key => $value) {
							if ($value->quantities > 0 ) {
								$quantity_check = 1;
								break;
							}
						}
					}
					$sub_total = $product_details->mrp * $cart_product->quantity;
					$total = $total + $sub_total;
					$response[] = array(
		                'id'       => $product_details->id,
		                'name'     => $product_details->name,
		                'mrp'      => $product_details->mrp,
		                'sub_total' => $sub_total,
		                'slug'     => $product_details->slug,
		                'description' => $product_details->description,
		                'inventory' => $quantity_check,
		                'quantity'  => $cart_product->quantity,
		                'img_url'  => base_url('assets/products/').'/'.$product_details->product_images[0]->product_image->image_url
		            );
				}
    		}
    	}
    	if (isset($response[0])) {
        	$this->response([
	            'status' => TRUE,
	            'response' => array("total" => $total, "cart_products" => $response),
	            'code' => $this->response_codes['SUCCESS']
	                ], REST_Controller::HTTP_OK);
        } else {
        	$this->response([
	            'status' => FALSE,
	            'response' => 'No Products Avilable',
	            'code' => $this->response_codes['SUCCESS']
	                ], REST_Controller::HTTP_OK);
        }
    }

    function my_order_get() {
    	$user = $this->is_customer_logged_in();
        if (!$user) {
            $this->response([
                'status' => FALSE,
                'response' => 'Login Session Expired. Please Login Again',
                'code' => $this->response_codes['SESS_EXPIRE']
                    ], REST_Controller::HTTP_FORBIDDEN);
        }
        $customer_id = $user->id;
		
		$orders = Order::all(array("conditions" => array("user_id = ?",$customer_id)));
		$response = array();

		foreach ($orders as $key => $order) {
			$response[] = array(
				'id'	   => $order->id,
				'order_id' => $order->order_id,
				'quantity' => $order->quantity,
				'booked_on' => date('d-m-Y', strtotime($order->created_date)),
				'status' => 'pending',
				'sub_total' => $order->order_total,
			);
		}
		if (isset($response[0])) {
        	$this->response([
	            'status' => TRUE,
	            'response' => $response,
	            'code' => $this->response_codes['SUCCESS']
	                ], REST_Controller::HTTP_OK);
        } else {
        	$this->response([
	            'status' => FALSE,
	            'response' => 'No Orders yet..',
	            'code' => $this->response_codes['SUCCESS']
	                ], REST_Controller::HTTP_OK);
        }
    }

    function order_details_get() {
    	$order_id = $this->input->get('order_id');
    	try {
    		$order = Order::find($order_id);
    	} catch(ActiveRecord\ActiveRecordException $ex) {
    		$order = null;
    	}
    	if ($order) {
    		$response = array();
	    	foreach ($order->order_details as $key => $order_detail) {
	    		$response[] = array(
	    			'order_id' => $order->order_id,
	    			'name' => $order_detail->product_order_detail->name,
	    			'brand' => $order_detail->product_order_detail->brand_name->name,
	    			'mrp' 	=> $order_detail->product_order_detail->mrp,
	    			'image' => base_url()."assets/products/".$order_detail->product_order_detail->product_images[0]->product_image->image_url, 
	    			'quantity' => $order_detail->quantity
	    			);
	    	}
	    	$this->response([
	            'status' => TRUE,
	            'response' => $response,
	            'code' => $this->response_codes['SUCCESS']
	                ], REST_Controller::HTTP_OK);
    	} else {
    		$this->response([
	            'status' => FALSE,
	            'response' => "Order Not found",
	            'code' => $this->response_codes['SUCCESS']
	                ], REST_Controller::HTTP_OK);	
    	}
    }
}