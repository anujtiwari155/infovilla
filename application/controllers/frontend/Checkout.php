<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->data['currentPage'] = 'Home';
 		$this->data['title']  = 'Welcome to alcoholoic';
 		$this->get_menu_list();
 		$this->check_user();
		$this->data['user_area_zip'] = $this->check_user_area();
        $this->session->set_userdata($this->data);
 		// to get current Url to redirect after login  ....
 		/*$this->data['url']  = current_url();
        $this->session->set_userdata($this->data);*/
 	// 	if ($this->ion_auth->logged_in()) {
		// 	$this->data['login_user'] = $this->user;
		// }else {
		// 	$this->data['login_user'] = "Guest";	
		// }
	}
	
	public function view_cart() {
		if($this->cart->total_items() > 0 ) {
			$this->template->load('Frontend/base', 'Frontend/checkout.php', $this->data);
		} else {
			redirect(base_url());
		}
		
	}

	function validate_pin($input_z = null , $pro_id = null) {
		$input_zip =  ($input_z) ? $input_z : $this->input->get('zip');
		$product_id = ($pro_id) ? $pro_id : $this->input->get('product_id');
		try{
			$product = Product::find($product_id);
		} catch (ActiveRecord\ActiveRecordException $ex) {
			$product = null;
		}
		$zips = array();
		if ($product) {
			$pro_vendors = $product->product_vendor();
			foreach ($pro_vendors as $key => $pro_vendor) {
				//print_r($pro_vendor->pro_vendor->vendor_area());
				if (is_array($pro_vendor->pro_vendor->vendor_area())) {
					foreach ($pro_vendor->pro_vendor->vendor_area() as $key => $zip) {
						if ($input_zip == $zip->zip_code) {
							$avilable_vendor[] = $zip->user_id;
						}
					}
				}
			}
			//$selected_vendor = array_rand($avilable_vendor,1);
			/*if (is_array($product->vendor->vendor_area())) {
				foreach ($product->vendor->vendor_area() as $key => $zip) {
					$zips[] = $zip->zip_code;
				}
			}*/
			//var_dump($zips);
			if (isset($avilable_vendor)) {
				shuffle($avilable_vendor);
				$data = array(
					"vendor_id" => $avilable_vendor[0],
				);
				$this->session->set_userdata($data);
				if ($input_z) {
					return array('status' => 'success','vendor' => $avilable_vendor[0],'product_id' => $product_id);
				} else {
					print_r(json_encode(array(
		                'status' => 'success',
		                'description' => 'success',
		                'vendor_id' => $avilable_vendor[0]
		            )));
				}
				
			} else {
				if ($input_z) {
					return array('status' => 'No vendor avilable to delever at this place','vendor' => '','product_id' => $product_id);
				} else {
					print_r(json_encode(array(
		                'status' => 'fail',
		                'description' => 'No vendor avilable to delever at this place'
		            )));
				}
			}
		} else {
			if ($input_z) {
				return array('status' => 'Product not avilable','vendor' => '','product_id' => $product_id);
			} else {
				print_r(json_encode(array(
		                'status' => 'fail',
		                'description' => 'Product not avilable'
		            )));
			}
		}
	}

	public function validate_cart_products() {
		$zip = $this->input->get('zip');
		$report = array();
		foreach ($this->cart->contents() as $items) {
			$report[$items['id']] = $this->validate_pin($zip,$items['id']);
		}
		print_r(json_encode(array(
			'status' => 'success',
			'report' => $report
			)));
	}

	function process_cart() {
		$zip = $this->input->get('zip');
		foreach ($this->cart->contents() as $items) {
			$result = $this->validate_pin($zip,$items['id']);
			if($result['vendor'] != '') {
				print_r($result);
			} else {
				$this->remove_product($items['rowid']);
			}
		}
	}

	function load_final_product() {
		//$cart_products = $this->cart->contents();
		$this->load->view('Frontend/cart_view.php');
	}

	public function add_cart($product_slug,$url1 = '', $url2 = '') {
		$product = Product::first(array('conditions' => array("active = '1' AND slug = ?",$product_slug)));
		$data = array(
	        'id'      => $product->id,
	        'qty'     => 1,
	        'price'   => $product->mrp,
	        'name'    => $product->name,
	        'image_url' => $product->product_images[0]->product_image->image_url,
	        'vendor_id' => $this->session->vendor_id,
	        'options' => array('Description' => $product->description)
		);

		$this->cart->insert($data);
		// $data = array(
		// 	'product' => Product::first(array('conditions' => array("active = '1' AND slug = ?",$product)))
		// 	);
		redirect(base_url($url1.'/'.$url2));
		//$this->template->load('Frontend/base', 'Frontend/checkout.php', array_merge($this->data,$data));
	}

	public function updatecart() {
		try {
    		$product = Product::find($this->input->post('product_id'));
    	} catch (ActiveRecord\ActiveRecordException $ex) {
    		$product = NULL;
    	}
    	$cur_pro = $this->cart->get_item($this->input->post('rowid'));
    	if ($product) {
    		if($product->inventory->quantities > $this->input->post('value')) {
    			$data = array(
			        'rowid' => $this->input->post('rowid'),
			        'qty'   => $this->input->post('value')
				);
				if($this->cart->update($data)) {
					print_r(json_encode(array(
		                'status' => 'success',
	                	'cur_qty'	=> $cur_pro['qty']
		            )));
				}
    		} else {
    			print_r(json_encode(array(
	                'status' => 'fail',
	                'description' => 'Out of Stock',
	                'cur_qty'	=> $cur_pro['qty']
	            )));
    		}
    	} else {
    		print_r(json_encode(array(
                'status' => 'fail',
                'description' => 'wrong product selected'
            )));
    	}
	}
	public function remove_product($rowid) {
		if($this->cart->remove($rowid)) {
			print_r(json_encode(array(
                'status' => 'success'
            )));
		}
	}
	public function add_product($product_id = null) {
		$product = Product::find($product_id);
		$data= array(
			'id'      => $product->id,
	        'qty'     => 1,
	        'price'   => $product->mrp,
	        'name'    => $product->name,
	        'image_url' => $product->product_images[0]->product_image->image_url,
	        'options' => array('Description' => $product->description)
		);
		if($this->cart->insert($data)) {
			print_r(json_encode(array('status' => 'success', 'products' => $this->cart->total_items() )));
		} else {
			print_r(json_encode(array('status' => 'fail')));
		}
	}
	public function empty_cart() {
		if($this->cart->destroy()) {
			print_r(json_encode(array(
                'status' => 'success'
            )));
		}
	}
	public function final_checkout() {
		//print_r($this->cart->contents()); die();
		$url = 'shipping';
		if (!$this->ion_auth->logged_in()) {
				// redirect them to the login page
			redirect('backend/Auth/login/'.$url, 'refresh');
		}
		$this->form_validation->set_rules('first_name', 'First Name', 'required|max_length[30]|trim');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required|max_length[30]');
		$this->form_validation->set_rules('address1', 'Address', 'required|max_length[30]');
		$this->form_validation->set_rules('city', 'City', 'required|max_length[30]');
		$this->form_validation->set_rules('state', 'State', 'required|max_length[30]');
		$this->form_validation->set_rules('zip', 'Zip', 'required|max_length[30]');
		$this->form_validation->set_rules('email', 'Email', 'required|max_length[30]');
		$this->form_validation->set_rules('phone', 'Phone', 'required|max_length[30]');
		if ($this->form_validation->run() === FALSE) {
			//$this->session->set_flashdata('success', 'Successfully Logged In');
			if($this->cart->total_items() > 0 ) {
				$this->template->load('Frontend/base', 'Frontend/shipping.php', $this->data);
			} else {
				redirect(base_url());
			}
			
		} else {
			$data = array(
				'first_name'	=> $this->input->post('first_name'),
				'last_name'		=> $this->input->post('last_name'),
				'address1'		=> $this->input->post('address1'),
				'address2'		=> $this->input->post('address2'),
				'city'			=> $this->input->post('city'),
				'state'			=> $this->input->post('state'),
				'zip'			=> $this->input->post('zip'),
				'email'			=> $this->input->post('email'),
				'phone'			=> $this->input->post('phone'),
				'vendors'		=> $this->input->post('vendors')
			);
			$this->session->set_userdata($data);
			$this->template->load('Frontend/base', 'Frontend/payment.php', array_merge($this->data,$data));
		}
	}
	public function payment() {
		$url = 'payment';
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('backend/Auth/login/'.$url, 'refresh');
		}
		$total_bill = $this->cart->total() + 100;
		//print_r($this->session->first_name); 
		$vendors = explode(",",$this->session->vendors);
		foreach ($vendors as $vendor) {
			$vendor_product = explode("-", $vendor);
			$cart_products[] = array(
				'pro_id' => $vendor_product[1],
				'ven_id'  => $vendor_product[0]
			);
		}
		$order = Order::create(array(
			'order_id'			=> $this->generateRandomString(),
			'quantity'			=> $this->cart->total_items(),
			'user_id'			=> $this->data['login_user']->id,
			//'order_total'		=> $this->cart->total(),
			'shipping_name'		=> $this->session->first_name." ".$this->session->last_name,
			'shipping_address1' => $this->session->address1,
			'shipping_address2' => $this->session->address2,
			'shipping_city'		=> $this->session->city,
			'shipping_state'	=> $this->session->state,
			'shipping_zip'		=> $this->session->zip,
			'shipping_phone'	=> $this->session->phone,
			'shipping_email'	=> $this->session->email,
			'sub_total'			=> $this->cart->total(),
			'order_shipping'	=> 100,
			'order_tax'			=> 0,
			'order_total'		=> $total_bill,
			'payment_method'	=> 'COD',
			'payment_status'	=> 1,
			'created_date'		=> date('Y-m-d'),
			'active'			=> 1
		));
		$product_list_ids = array();
		foreach ($this->cart->contents() as $items) {
			foreach ($cart_products as $key => $value) {
				if ($value['pro_id'] == $items['id']) {
					$pro_vendor = $value['ven_id'];
				}
			}
			//print_r($pro_vendor."->".$items['id']); die();

			$product_update = Inventory::first(array("conditions" => array("product_id = ? AND user_id = ? ",$items['id'],$pro_vendor)));
			//$product_update = Inventory::find_by_product_id($items['id']);
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
				'vendor_id'				=>  $pro_vendor,
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
		$order->save();
		$this->empty_cart();
		
		$this->template->load('Frontend/base', 'Frontend/payment_confirmation.php', $this->data);
	}
	public function online_payment() {
		require_once APPPATH . 'libraries/Stripe/Stripe.php';
            $this->load->config('stripe', TRUE);
            $config = $this->config->item('stripe');
            // Authenticate the request.
            $total_bill = ($this->cart->total() * 1/10) + $this->cart->total() + 100;
            $card_no = trim($this->input->post('card_number'));
            $exp_month = $this->input->post('exp_month');
            $exp_year = $this->input->post('exp_year');
            Stripe::setApiKey($config['api_key']);
            try {
                $myCard = array('number' => $card_no, 'exp_month' => $exp_month, 'exp_year' => $exp_year);
                //$myCard = array('number' => '4242424242424242', 'exp_month' => 8, 'exp_year' => 2018);
				$charge = Stripe_Charge::create(array('card' => $myCard, 'amount' => $total_bill, 'currency' => 'usd'));
				if ($charge->status == 'succeeded') {
					$this->template->load('Frontend/base', 'Frontend/payment_confirmation.php', $this->data);
				} else {
					$this->template->load('Frontend/base', 'Frontend/payment_fail.php', $this->data);
				}
            } catch (Exception $e) {
                $error = $e->getMessage();
                $this->session->set_flashdata('error', $error);
                $this->template->load('Frontend/base', 'Frontend/payment_fail.php', $this->data);
            }
	}
}
