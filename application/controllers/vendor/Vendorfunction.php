<?php 

/**
* 
*/
class Vendorfunction extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
 		$this->check_user();
	}

	function home() {
		$this->data['currentPage'] = 'Vendor Home';
 		$this->data['title']  = 'Welcome to Vendor Panel';
 		if( $this->ion_auth->in_group('vendor')) {
			if($this->data['current_user_details']->user_profile) {

		 		$data = array(
		 			//'vender_products' => Product::all(array("conditions" => array("added_by = ?",$this->data['current_user_details']->id ))),
		 			'vender_products' => $this->data['current_user_details']->vendor_products(),
		 			'pending_products' => Product::count(array("conditions" => array("added_by = ? AND status = '0' AND active = '1'",$this->data['current_user_details']->id))),
		 			'rejected_products' => Product::count(array("conditions" => array("added_by = ? AND active = '0'",$this->data['current_user_details']->id))),
		 			);
				$this->template->load('vendor/base', 'vendor/welcome_vendor.php', array_merge($data,$this->data));
			} else {
				$this->template->load('vendor/base', 'vendor/get_started.php', $this->data);
			}
		} else {
        	//$this->session->set_flashdata('message', 'Please Login as Vendor to Continue');
			$this->template->load('vendor/login_base', 'vendor/home.php', $this->data);
		}
 		//$this->template->load('vendor/base', 'vendor/home.php', $this->data);
	}

	function vendor($case = NULL) {
		switch ($case) {
			case 'register':
				$this->form_validation->set_rules('email', 'Mail_id.', 'required|max_length[60]|trim|valid_email|is_unique[users.email]');
				$this->form_validation->set_rules('password', 'Password', 'required|max_length[30]');
				$this->form_validation->set_rules('cnf_password', 'Confirm Password', 'required|max_length[30]');
				$this->data['current_page'] = "Sign up Page";
				if ($this->form_validation->run() === FALSE) {
					//$this->session->set_flashdata('success', 'Successfully Logged In');
					$this->template->load('vendor/base', 'vendor/home.php', $this->data);	
				} else {
		            $user = User::create(array(
		                'email' => $this->input->post('email', TRUE),
		                'active' => 1
		            ));
		            UsersGroup::create(array(
		                'user_id' => $user->id,
		                'group_id' => 3
		            ));
		            if ($this->input->post('password', TRUE)) {
		                $this->ion_auth->reset_password($user->email, $this->input->post('password', TRUE));
		            }
		            $data = array(
		            	'username' => $user->email,
		            	'password' => $this->input->post('password', TRUE),
		            	'url' 	   => base_url('vendor')
		            	);
		            $this->template->load('vendor/login_base','auth/login_script.php', $data);
		            //$this->session->set_flashdata('message', 'Successfully Registered Login to continue');
		            //redirect(base_url("backend/Auth/dynamic_login/".$this->input->post('email').'/'.$this->input->post('password')."/vendor"));
		            //$this->template->load('vendor/base', 'vendor/home.php',array_merge($this->data,$data));
				}
			break;
			case 'get_started':
				if( $this->ion_auth->in_group('vendor')) {
					if($this->data['current_user_details']->user_profile) {
						$data = array(
				 			'vender_products' => Product::all(array("conditions" => array("added_by = ?",$this->data['current_user_details']->id ))),
				 			'pending_products' => Product::count(array("conditions" => array("added_by = ? AND status = '0' AND active = '1'",$this->data['current_user_details']->id))),
				 			'approved_products' => Product::count(array("conditions" => array("added_by = ? AND status = '1' AND active = '1'",$this->data['current_user_details']->id))),
				 			'rejected_products' => Product::count(array("conditions" => array("added_by = ? AND active = '0'",$this->data['current_user_details']->id))),
				 			);
						$this->template->load('vendor/base', 'vendor/welcome_vendor.php', array_merge($data,$this->data));
					} else {
						$this->template->load('vendor/base', 'vendor/get_started.php', $this->data);
					}
				} else {
	            	$this->session->set_flashdata('message', 'Please Login as Vendor to Continue');
					$this->template->load('vendor/login_base', 'vendor/home.php', $this->data);
				}
			break;
			case 'complete_registration':
				$this->form_validation->set_rules('first_name', 'First Name','required|max_length[60]|trim');
				$this->form_validation->set_rules('last_name', 'Last Name','required|max_length[60]|trim');
				$this->form_validation->set_rules('address', 'Address','required|max_length[200]|trim');
				$this->form_validation->set_rules('city', 'Address','required|max_length[200]|trim');
				$this->form_validation->set_rules('zip', 'Address','required|max_length[200]|trim');
				$this->form_validation->set_rules('country', 'Address','required|max_length[200]|trim');
				$this->form_validation->set_rules('state', 'Address','required|max_length[200]|trim');
				$this->form_validation->set_rules('phone', 'Address','required|max_length[200]|trim');
				$this->form_validation->set_rules('area_pin', 'Area Zip' , 'required');
				//print_r($user_id); die();
				if ($this->form_validation->run() === FALSE) {
		            $this->template->load('vendor/base', 'vendor/get_started.php',$this->data);
				} else {
					$user = $this->data['current_user_details'];
		            $user->first_name = $this->input->post('first_name', TRUE);
		            $user->last_name  = $this->input->post('last_name', TRUE);
		            $user->phone 	  = $this->input->post('phone', TRUE);
		            $user->save();
		            if($user->user_profile){
		            	$user->user_profile->update_attributes($this->input->post(array('address','city','country','state','zip'), TRUE));
		            	$old_zips = VendorArea::delete_all(array("conditions" => array("user_id = ?", $user->id)));
		            	$vendor_zips = explode(",",$this->input->post('area_pin', TRUE));
		            	foreach ($vendor_zips as $key => $vendor_zip) {
		            		VendorArea::create(array(
				            	'user_id' => $user->id,
				            	'zip_code'	  => trim($vendor_zip)
				            ));
		            	}
			            	
		            } else {
			            UserProfile::create(array(
			            	'user_id'	=> $user->id,
			            	'address'	=> $this->input->post('address', TRUE),
			            	'city' 		=> $this->input->post('city', TRUE),
			            	'country' 	=> $this->input->post('country', TRUE),
			            	'state'		=> $this->input->post('state', TRUE),
			            	'zip'		=> $this->input->post('zip', TRUE)
			            ));
			            $vendor_zips = explode(",",$this->input->post('area_pin', TRUE));
		            	foreach ($vendor_zips as $key => $vendor_zip) {
		            		VendorArea::create(array(
				            	'user_id' => $user->id,
				            	'zip_code'	  => trim($vendor_zip)
				            ));
		            	}
		            }
		            
		            //$this->session->set_flashdata('success', 'Successfully Logged In');
					//$this->template->load('vendor/base', 'vendor/welcome_vendor.php',$this->data);
					redirect(base_url('vendor'));
				}
			break;
			case 'edit_profile': 
				if ($this->ion_auth->in_group('vendor')) {
					$this->data['vendor_edit'] = TRUE;
					$v_zips = array();
					$zips = VendorArea::all(array("conditions" => array("user_id = ?",$this->data['current_user_details']->id)));
					foreach ($zips as $zip) {
						array_push($v_zips, $zip->zip_code);
					}
					$this->data['vendor_zips'] = $v_zips;
					$this->template->load('vendor/base', 'vendor/get_started.php', $this->data);
				}
			break;
			default:
				print_r("expression");
				break;
		}
	}

	function validate_address() {
		$email = $this->input->get('email');
		$flag = 0;
		if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
		  $flag = 1;
		} else {
		  $flag = 0;
		  print_r(json_encode(array(
                'status' => 'fail',
                'response' => "Please Input Valid Email Address"
            )));
		}
		if($flag) {
			try {
				$user = User::find_by_email($email);
			} catch (ActiveRecord\ActiveRecordException $ex) {
				$user = NULL;
			}
			if($user) {
				print_r(json_encode(array(
	                'status' => 'fail',
	                'response' => "Email Address already registered"
	            )));
			} else {
				print_r(json_encode(array(
	                'status' => 'success',
	                'response' => "Available"
	            )));
			}
		}
	}

	function product($case = NULL , $id = null) {
		if (!$this->ion_auth->in_group('vendor')) {
                // redirect them to the login page
                redirect('vendor', 'refresh');
        }
		$this->data['brands'] = Brand::all(array('conditions' => array("active = '1'")));
		$this->data['categories'] = Category::all(array('conditions' => array("active = '1'")));
		$this->data['products'] = Product::all(array('conditions' => array("active = '1'")));
		switch ($case) {
			case 'add':
			    $this->form_validation->set_rules('model_no', 'Model Number Required', 'required|max_length[100]|trim');
			    $this->form_validation->set_rules('name', 'Product Name', 'required|max_length[200]|trim');
			    $this->form_validation->set_rules('sku', 'SKU Number', 'required|max_length[30]|trim');
			    $this->form_validation->set_rules('barcode', 'Barcode', 'required|max_length[30]|trim');
			    $this->form_validation->set_rules('brand_id', 'Brands', 'required|max_length[30]|trim');
			    $this->form_validation->set_rules('mrp', 'MRP', 'required|max_length[30]|trim');
			    //print_r($this->input->post());die();
			    
			    if ($this->form_validation->run() === FALSE) {
			    	if (!$id) {
				    	redirect(base_url("vendor/Vendorfunction/product/validate_product"));
				    }
			  		$this->data['currentPage'] = 'Add Products';
			  		$data = array(
						'action'  => base_url('vendor/Vendorfunction/product/add'),
						'pro_code' => $id
					);
			  		$this->template->load('vendor/base', 'vendor/products/add_products.php', array_merge($data,$this->data));
			    } else {
			    	//print_r($this->input->post('parent_id')); die();
			    	$product_slug = $this->slug($this->input->post('name'));
			    	try {
			    		$search_product = Product::first(array("conditions" => array(" active = '1' AND slug = ?",$product_slug)));
			    	} catch (ActiveRecord\ActiveRecordException $ex) {
			    		$search_product = NULL;
			    	}
			    	if(!$search_product) {
				    	foreach ($this->input->post() as $key => $input) {
				    		if (strpos($key,"_attribute")) {
				    			$pro_attributes[] = $input;
				    		}
				    	}
				    	$attr_count = 0;
				    	//print_r("expression");
				      	$product = Product::create(array(
							'name' 				=> $this->input->post('name'),
							//'slug'				=> $this->slug($this->input->post('name')),
							'brand_id' 			=> $this->input->post('brand_id'),
							'mrp' 				=> $this->input->post('mrp'),
							'code' 				=> $this->input->post('code'),
							'sku' 				=> $this->input->post('sku'),
							'barcode' 			=> $this->input->post('barcode'),
							'added_by'			=> $this->data['current_user_details']->id,
							'cost_price'		=> $this->input->post('cost_price'),
							'model_no' 			=> $this->input->post('model_no'),
							'description' 		=> $this->input->post('description'),
							'status'			=> 0,		// status pending for prouct uploaded by vendor...
							'active' 			=> 1
						));
						//print_r($product);
						$product->slug = $this->slug($product->id.' '.$this->input->post('name'));
						$product->save();
						foreach ($this->input->post('parent_id') as $value) {
							ProductCategory::create(array(
								'product_id'  => $product->id,
								'category_id' => $value
							));
						}
						foreach ($pro_attributes as $key => $attr) {
							ProductAttribute::create(array(
			    				'product_id' 			=> $product->id,
			    				'attribute_value_id' 	=> $attr
							));
						}
						ProductsVendor::create(array(
				    		'user_id' => $this->data['current_user_details']->id,
				    		'product_id' => $product->id,
				    		'update_at'  => date('Y-m-d')
				    	));
						Inventory::create(array(
							'product_id'		=> $product->id,
							'quantities'		=> $this->input->post('quantity'),
			    			'total_added' 		=> $this->input->post('quantity'),
			    			'mrp'				=> $this->input->post('mrp'),
			    			'cost_price'		=> $this->input->post('cost_price'),
							'user_id'    		=> $this->data['current_user_details']->id,
							'offer'				=> $this->input->post('offer'),
							'active'			=> 1,
							'created_date'		=> date('Y-m-d'),
							'updated_date'		=> date('Y-m-d')
						));
				    	extract($_POST);
					    $error=array();
					    $extension=array("jpeg","jpg","png","gif");
					    foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name)
			            {
			                $file_name=$_FILES["files"]["name"][$key];
			                $file_tmp=$_FILES["files"]["tmp_name"][$key];
			                $ext=pathinfo($file_name,PATHINFO_EXTENSION);
			                if(in_array($ext,$extension))
			                {
			                    if(!file_exists(base_url()."assets/img/products/".$file_name))
			                    {
			                        move_uploaded_file($file_tmp=$_FILES["files"]["tmp_name"][$key],"./././assets/products/".$file_name);
			                        $image = Image::create(array(
			                        	'category' => 'products',
			                        	'image_url' => $file_name
			                        ));
			                        ProductImage::create(array(
			                        	'product_id' => $product->id,
			                        	'image_id'  => $image->id
			                        ));
			                    }
			                    else
			                    {
			                        $filename=basename($file_name,$ext);
			                        $newFileName=$filename.time().".".$ext;
			                        move_uploaded_file($file_tmp=$_FILES["files"]["tmp_name"][$key],"./././assets/products/".$newFileName);
			                        $image = Image::create(array(
			                        	'category' => 'products',
			                        	'image_url' => $newFileName
			                        ));
			                        ProductImage::create(array(
			                        	'product_id' => $product->id,
			                        	'image_id'  => $image->id
			                        ));
			                    }
			                }
			                else
			                {
			                    array_push($error,"$file_name, ");
			                }
			            }

						// mail function to send notification
						$subject = "New Product Added in Ecommerce InfoVilla";
				        $message = "<h3>New Product Added By: ".$this->data['current_user_details']->get_full_name()."</h3></br><h3><a href='".base_url('backend/allfunction/product/pending_products')."'>Review/Approve pending products here</a></h3>";
				        $this->load->library('Custom_email');
				        //$sent = $this->custom_email->send("developer.goswami@gmail.com" , "InfoVilla" , $subject, $message);
				        // end of Mail
						$this->session->set_flashdata('success', 'Details Saved Successfully.');
			            redirect('vendor/Vendorfunction/product/all' , 'refresh');
		            } else {
		            	$this->session->set_flashdata('message', 'Product already Exist please update Inventory');
			            redirect('vendor/Vendorfunction/product/all' , 'refresh');
		            }
			    }
			break;
			case 'validate_product':
				$this->data['currentPage'] = 'Add Products';
				$this->data['title']  = 'Validate Product';

			    $this->form_validation->set_rules('quantity', 'Quantity', 'required|max_length[30]|trim');
			    $this->form_validation->set_rules('product_id', 'Product', 'required|max_length[30]|trim');

			    if ($this->form_validation->run() === FALSE) {
			    	$data = array(
						'action'  => base_url('vendor/Vendorfunction/product/validate_product')
					);
					$this->template->load('vendor/base', 'vendor/products/validate_products.php', array_merge($this->data,$data));
			    } else {
			    	$quantity = $this->input->post('quantity');
			    	$product_id = $this->input->post('product_id');

			    	$product = Product::find($product_id);
			    	
			    	ProductsVendor::create(array(
			    		'user_id' => $this->data['current_user_details']->id,
			    		'product_id' => $product_id
			    	));

			    	Inventory::create(array(
			    		'product_id' => $product_id,
			    		'quantities' => $quantity,
			    		'total_added' => $quantity,
			    		'mrp'		  => $this->input->post('mrp'),
			    		'cost_price'  => $this->input->post('cost_price'),
			    		'active' 	 => 1,
			    		'user_id'    => $this->data['current_user_details']->id,
			    		'offer'				=> $this->input->post('offer'),
						'created_date'		=> date('Y-m-d'),
						'updated_date'		=> date('Y-m-d')
			    	));
			    	redirect('vendor/Vendorfunction/product/all' , 'refresh');
			    }
			break;
			case 'all':
					//$this->load->library('pagination');
					//$config['base_url'] = 'http://example.com/index.php/test/page/';
					//$config['total_rows'] = 200;
					//$config['per_page'] = 20;

					//$this->pagination->initialize($config);

					//echo $this->pagination->create_links();
					$brand_filter = $this->input->get('brand_filter');
					if (isset($brand_filter) && $brand_filter != '') {
						$data = array(
							'default_brand' => $brand_filter,
							'products'		=> Product::all(array('conditions' => array("active = '1' AND added_by = ? AND brand_id = ?",$this->data['current_user_details']->id, $brand_filter))),
							'list'			=> 'Products'
							);
					} else {
						$vendor_inventory = Inventory::all(array("conditions" => array("user_id = ? AND active = '1'",$this->data['current_user_details']->id)));
						//$v_product_list = array();
						foreach ($vendor_inventory as $key => $v_pro) {
							$v_product_list[] = $v_pro->product_id;
 						}
 						if (isset($v_product_list)) {
 							$v_product_list = implode("','",$v_product_list);
 						} else {
 							$v_product_list = '';
 						}
						$data = array(

							'products' => Product::all(array('conditions' => array("active = '1' AND id IN ('".$v_product_list."')"))),
							'list'	   => 'All Products'
							);
					}
					$this->data['currentPage'] = 'All Products';
					$this->template->load('vendor/base', 'vendor/products/list_products.php', array_merge($this->data,$data));
			break;
			case 'pending_products':
					$this->load->library('pagination');
					$config['base_url'] = 'http://example.com/index.php/test/page/';
					$config['total_rows'] = 200;
					$config['per_page'] = 20;

					$this->pagination->initialize($config);

					echo $this->pagination->create_links();
					$brand_filter = $this->input->get('brand_filter');
					if (isset($brand_filter) && $brand_filter != '') {
						$data = array(
							'default_brand' => $brand_filter,
							'products'		=> Product::all(array('conditions' => array("active = '1' AND brand_id = ? AND status = '0' AND added_by = ?",$brand_filter, $this->data['current_user_details']->id))),
							'list'	   => 'Pending Products'
							);
					} else {
						$data = array(
							'products' => Product::all(array('conditions' => array("active = '1' AND status = '0' AND added_by = ?", $this->data['current_user_details']->id))),
							'list'	   => 'Pending Products'
							);
					}
					$this->data['currentPage'] = 'All Products';
					$this->template->load('vendor/base', 'vendor/products/list_products.php', array_merge($this->data,$data));
			break;
			case 'update':
				$this->form_validation->set_rules('model_no', 'Model Number Required', 'required|max_length[100]|trim');
			    $this->form_validation->set_rules('name', 'Product Name', 'required|max_length[200]|trim');
			    $this->form_validation->set_rules('sku', 'SKU Number', 'required|max_length[30]|trim');
			    $this->form_validation->set_rules('barcode', 'Barcode', 'required|max_length[30]|trim');
			    $this->form_validation->set_rules('brand_id', 'Brands', 'required|max_length[30]|trim');
			    $this->form_validation->set_rules('mrp', 'MRP', 'required|max_length[30]|trim');
			    //print_r($this->input->post());die();
			    $product = Product::find($id);
			    if ($this->form_validation->run() === FALSE) {
			  		$this->data['currentPage'] = 'Add Products';
			  		$product_vendors = $product->product_vendor();
			  		foreach ($product_vendors as $key => $product_vendor) {
			  			if ($product_vendor->user_id == $this->data['current_user_details']->id) {
			  				$current_inventory = $product_vendor;
			  				break;
			  			}
			  		}
			  		$data = array(
						'product' => $product,
						'current_inventory' => $current_inventory,
						'action'  => base_url('vendor/Vendorfunction/product/update/'.$id)
					);
					$this->template->load('vendor/base', 'vendor/products/add_products.php',array_merge($data,$this->data));
			    } else {
			    	//print_r($this->input->post('parent_id')); die();
			    	$product_id = $this->input->post('product_id');
			    	$product = Product::find($product_id);
			    	$attr_count = 0;
			    	$product_vendors = $product->product_vendor();
			    	foreach ($product_vendors as $key => $product_vendor) {
			    		if ($product_vendor->user_id == $this->data['current_user_details']->id) {
			    			$product_vendor->mrp = $this->input->post('mrp');
			    			$product_vendor->cost_price = $this->input->post('cost_price');
			    			$product_vendor->save();
			    			break;
			    		}
			    	}
			    	$product->update_attributes($this->input->post(array('name','brand_id','sku','barcode','model_no','description'),TRUE));
					$sub_id = $this->input->post('cat_num');
					$product->status = 0;
					$product->save();
					//$inventory_details = Inventory::find_by_product_id($product_id);
					/*$inventory_details = Inventory::first(array("conditions" => array("user_id = ? AND product_id = ?", $this->data['current_user_details']->id, $product_id)));
					$inventory_details->quantities	= $this->input->post('quantity');
					$inventory_details->save();*/
			    	extract($_POST);
				    $error=array();
				    $extension=array("jpeg","jpg","png","gif");
				    foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name)
		            {
		                $file_name=$_FILES["files"]["name"][$key];
		                $file_tmp=$_FILES["files"]["tmp_name"][$key];
		                $ext=pathinfo($file_name,PATHINFO_EXTENSION);
		                if(in_array($ext,$extension))
		                {
		                    if(!file_exists(base_url()."assets/img/products/".$file_name))
		                    {
		                        move_uploaded_file($file_tmp=$_FILES["files"]["tmp_name"][$key],"./././assets/products/".$file_name);
		                        $image = Image::create(array(
		                        	'category' => 'products',
		                        	'image_url' => $file_name
		                        ));
		                        ProductImage::create(array(
		                        	'product_id' => $product->id,
		                        	'image_id'  => $image->id
		                        ));
		                    }
		                    else
		                    {
		                        $filename=basename($file_name,$ext);
		                        $newFileName=$filename.time().".".$ext;
		                        move_uploaded_file($file_tmp=$_FILES["files"]["tmp_name"][$key],"./././assets/products/".$newFileName);
		                        $image = Image::create(array(
		                        	'category' => 'products',
		                        	'image_url' => $newFileName
		                        ));
		                        ProductImage::create(array(
		                        	'product_id' => $product->id,
		                        	'image_id'  => $image->id
		                        ));
		                    }
		                }
		                else
		                {
		                    array_push($error,"$file_name, ");
		                }
		            }

		            $subject = "Product Updated in Ecommerce InfoVilla";
				    $message = "<h3>Product Updated By: ".$this->data['current_user_details']->get_full_name()."</h3></br><h3><a href='".base_url('backend/allfunction/product/pending_products')."'>Review/Approve pending products here</a></h3>";
				    $this->load->library('Custom_email');
				    $sent = $this->custom_email->send("developer.goswami@gmail.com" , "InfoVilla" , $subject, $message);

					$this->session->set_flashdata('success', 'Details Saved Successfully.');
		            redirect('vendor/Vendorfunction/product/all' , 'refresh');
			    }
			break;
			case 'delete':
					//$product = Product::find($id);
					$product = Inventory::first(array("conditions" => array("user_id = ? AND product_id = ?",$this->data['current_user_details']->id,$id)));
					$product->active = 0;
					$product->save();
					redirect(base_url('vendor/Vendorfunction/product/all'));
			break;
			default:
				$data = array(
					'products' => Product::all(array('conditions' => array("active = '1' AND added_by = ?", $this->data['current_user_details']->id))),
					'list'	   => 'All Products'
					);
				$this->template->load('vendor/base', 'vendor/products/list_products.php', array_merge($this->data,$data));
				break;
		}
	}
}