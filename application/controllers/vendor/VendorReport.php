<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VendorReport extends MY_Controller {

	function __construct() {
		parent::__construct();
		if (!$this->ion_auth->in_group('vendor')) {
                // redirect them to the login page
                redirect('vendor', 'refresh');
        } else {
			$this->get_menu_list();
        	$this->check_user();
        }
	}

	function product() {
		//print_r($this->input->get('list')); die();
		$current_date = date('Y-m-d');
		$date1 = date_create($current_date);
		$filter_value = 365;
		$date2 = '2017-01-01';
		if ($this->input->get('list')) {
			$filter_conditions = array();
			switch ($this->input->get('list')) {
				case 'last_7_days':
					$required_date = date_sub($date1,date_interval_create_from_date_string("7 days"));
					$date2 = date_format($date1,'Y-m-d');
					$date2 = date($date2);
        			$filter_value = 7;
					array_push($filter_conditions, " AND created_date >= ".$date2);
					break;
				case 'last_1_month':
					$required_date = date_sub($date1,date_interval_create_from_date_string("30 days"));
					$date2 = date_format($date1,'Y-m-d');
					$date2 = date($date2);
        			$filter_value = 30;
					//array_push($filter_conditions, "AND le.variant_id IN (".$search_variant.")");
					break;
				case 'last_6_months':
					$required_date = date_sub($date1,date_interval_create_from_date_string("180 days"));
					$date2 = date_format($date1,'Y-m-d');
					$date2 = date($date2);
        			$filter_value = 180;
					//array_push($filter_conditions, "AND le.variant_id IN (".$search_variant.")");
					break;
			}
		}
		if(isset($filter_conditions)) {
            $search_str = join(' ',$filter_conditions);
        } else {
            $search_str = " ";
        }
		$products_count = Inventory::first(array("select" => "sum( quantities ) as total", "conditions" => array("updated_date > ?", $date2)));
		//print_r($products_count); die();
		$booked_products = Order::all(array("conditions" => array("active = '1' AND created_date > ?",$date2) , "select" => "distinct (created_date)"));
		$products_booked_count = Order::first(array("select" => "sum( quantity ) as total", "conditions" => array("created_date > ?", $date2)));
		$products_delivered = Order::first(array("select" => "sum( quantity ) as total", 'conditions' => array("is_delivered = '1' AND created_date > ?", $date2)));
		//print_r($products_count->total); die();
		$data = array(
			'product_added' => $products_count->total,
			'product_booked' => $products_booked_count->total,
			'booked_products' => $booked_products,
			'product_delivered' => $products_delivered->total,
			'selected' => $filter_value
		);
		$this->template->load('backend/base', 'backend/reports/report.php', array_merge($this->data,$data));
	}

	function order_list() {
		$current_date = date('Y-m-d');
		$date1 = date_create($current_date);
		$status = $this->input->get('status');
		$category = $this->input->get('category');
		$selected_duration = $this->input->get('date');
		$conditions = $o_conditions = array();
		if ($status != '' && $status == 'booked' ) {
			array_push($conditions, " AND is_delivered = '0'");
		}
		if ($status != '' && $status == 'delevered' ) {
			array_push($conditions, " AND is_delivered = '1'");
		}
		if ($category != '') {
			$category_detail = Category::find($category);
			$products = array();
			try {
				$product_list12 = ProductCategory::all(array("conditions" => array("category_id = ?",$category_detail->id)));
			} catch (ActiveRecord\ActiveRecordException $ex) {
				$product_list12 = null;
			}
			if($product_list12) {
				foreach($product_list12 as $abcd) {
					array_push($products, $abcd->product_id);
				}
				array_push($conditions, " AND product_id IN (".join(',',$products).")");
			} else {
				array_push($conditions, " AND product_id = 'AB56'");			// just to get no record found #jugaad tech
			}
		}
		if ($selected_duration != '') {
			switch ($selected_duration) {
				case '7_days':
					$required_date = date_sub($date1,date_interval_create_from_date_string("7 days"));
					$date2 = date_format($date1,'Y-m-d');
					$date2 = date($date2);
					array_push($conditions, " AND orders.created_date > '".$date2."'");
					array_push($o_conditions, " AND order_details.created_date > '".$date2."'");
					break;
				case '1_month':
					$required_date = date_sub($date1,date_interval_create_from_date_string("30 days"));
					$date2 = date_format($date1,'Y-m-d');
					$date2 = date($date2);
					array_push($conditions, " AND orders.created_date > '".$date2."'");
					array_push($o_conditions, " AND order_details.created_date > '".$date2."'");
					break;
				case '6_months':
					$required_date = date_sub($date1,date_interval_create_from_date_string("180 days"));
					$date2 = date_format($date1,'Y-m-d');
					$date2 = date($date2);
					array_push($conditions, " AND orders.created_date > '".$date2."'");
					array_push($o_conditions, " AND order_details.created_date > '".$date2."'");
					break;
				case 'over_all':
					$date2 = date('2017-01-01');
					array_push($conditions, " AND orders.created_date > '".$date2."'");
					array_push($o_conditions, " AND order_details.created_date > '".$date2."'");
					break;
			}
		}
		if(isset($conditions)) {
			$search_str = join(' ', $conditions);
			$search_order = join(' ', $o_conditions);
		} else {
			$search_str = " ";
			$search_order = " ";
		}
		$sold_products = OrderDetail::first(array("joins" => "JOIN products p ON p.id = order_details.product_id","select" => "sum( order_details.quantity ) as total_quantity , sum( order_details.total ) as order_total , sum( order_details.profit ) as order_profit","conditions" => array("order_details.active = '1' AND order_details.vendor_id = ?".$search_order,$this->data['current_user_details']->id)));
		// new testing
		
		$product_sell = Order::all(array("joins" => "JOIN order_details od ON od.order_id = orders.id JOIN products p ON p.id = od.product_id", "group"=> "orders.id","conditions" => array("od.vendor_id = ?".$search_str,$this->data['current_user_details']->id)));
		//die();
		// end of testing
		//print_r(Order::connection()->last_query); die();
		$data = array(
			'reports' => $product_sell,
			'sold_product' => $sold_products,
			'default_status' => $status,
			'dafault_category' => $category,
			'default_date'		=> $selected_duration
			);
		$this->template->load('vendor/base', 'vendor/reports/order.php', array_merge($this->data,$data));	
	}

	function order_detail($id = null, $vendor_id = null) {
		$order = Order::find($id);
		//print_r($order->vendor_order_product($vendor_id)); die();
		$data = array(
			'order_details' => $order,
			'vendor_products' => $order->vendor_order_product($vendor_id)
			);
		$this->load->view('vendor/reports/report_details.php', $data);
	}
}
