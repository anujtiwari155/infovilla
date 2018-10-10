<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Allfunction extends MY_Controller {

	function __construct() {
		parent::__construct();
		if (!$this->ion_auth->is_admin()) {
				// redirect them to the login page
				redirect('backend/Auth/login/home', 'refresh');
		}
		$this->check_user();
	}
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
  	public function dashboard() {
 		$this->data['currentPage'] = 'Home';
 		//$this->load->view('header');
 		$this->template->load('backend/base', 'backend/dashboard/index.php', $this->data);
 	}

	public function add_brand($case = null , $is_product_brand = null) {
		switch ($case) {
			case 'add':
				if (validation_errors()) {
					print_r(json_encode(array('type' => 'error', 'message' => validation_errors())));
				} else {
					$data = array(
						'is_product' => $is_product_brand
					);
					$this->load->view('backend/brands/add_brands.php', $data);
				}
			break;
			case 'update':
				$data = array(
					'is_product' => $is_product_brand,
					'brand_detail' => Brand::find($is_product_brand)
				);
				$this->load->view('backend/brands/add_brands.php', $data);
			break;
			default:
				$data = array(
					'brands' => Brand::all(array('conditions' => array("active = '1'")))
				);
				$this->template->load('backend/base', 'backend/brands/list_brands.php', $data);
			break;
		}
	}

	public function category($case = null , $is_product = null) {
		//print_r($is_product); die();
		switch ($case) {
			case 'add':
				$this->form_validation->set_rules('category_name', 'Category Name Required', 'required|max_length[30]');
				$this->form_validation->set_rules('category_code', 'Category Code', 'required|max_length[30]');
				//$this->form_validation->set_rules('parent_id', 'Category Id', 'required|max_length[30]');
				if ($this->form_validation->run() === FALSE) {
					if (validation_errors()) {
						print_r(json_encode(array('type' => 'error', 'message' => validation_errors())));
					} else {
						$data = array(
							'action' 	 => base_url('backend/Allfunction/category/add/'.$is_product),
							'categories' => Category::all(array('conditions' => array("active = '1'"))),
							'attributes' => Attribute::all(array('conditions' => array("active = '1'"))),
							'is_product' => $is_product 								// to check category add on product page or category page
						);
						$this->load->view('backend/categories/add_categories.php', $data);
					}
				} else {
					$parents = $this->input->post('parent_id');
					foreach ($parents as $key => $parent) {
						$parent_id = $parent; 
					}
					$parent_detail = Category::find($parent_id);
					$parent_lavel = $parent_detail->lavel;
					$attributes = $this->input->post('category_attributes');
					$category = Category::create(array(
						'name' =>  $this->input->post('category_name'),
						'category_code' =>  preg_replace('/\s+/', '',$this->input->post('category_code')),
						//'slug'			=> $this->slug($this->input->post('category_name')),
						'parent_id' =>  $parent_id,
						'lavel'		=> ++$parent_lavel,
						'active' => 1
					));
					$category->slug = $this->slug($category->id.' '.$this->input->post('category_name'));
					$category->save();
					foreach ($attributes as $attribute) {
						AttributeCategory::create(array(
							'category_id' => $category->id,
							'attribute_id' => $attribute,
						));
					}

					/*if ($_FILES['category_img']['tmp_name']) {
			            $config['upload_path']          = './assets/img/category/';
			            $config['allowed_types']        = 'gif|jpg|png|jpeg';
			            @unlink($config['upload_path'] . $category->image);
			            $config['file_name']            = $category->id.'_cat.jpg';
			            $this->load->library('upload', $config);

			            if ( ! $this->upload->do_upload('new_img'))
			            {
			                print_r($this->upload->display_errors()); die();
			                $error = array('error' => $this->upload->display_errors());
			                $this->load->view('backend/Allfunction/category', $error);
			            }
			            else
			            {
			                $upload_data = $this->upload->data();
			                $category->image = $upload_data['file_name'];
			                $category->save();
			                }
			        }*/

					$response = array();
						if ($category) {
								$categories = Category::all(array('conditions' => array('lavel = 0',$parent_detail->lavel)));
								foreach ($categories as $category) {
									array_push($response, array('id' => $category->id, 'name' => ucwords($category->name)));
								}
								print_r(json_encode(array('type' => 'success' , 'response' => $response , 'lavel' => $parent_detail->lavel, 'url' => base_url('backend/Allfunction/category/reload'), 'is_product' => $is_product , 'message' => 'Details Saved Successfully')));
						} else {
							print_r(json_encode(array('status' => 'fail')));
						}
					//print_r(json_encode(array('type' => 'success', 'url' => base_url('backend/Allfunction/category/reload'), 'is_product' => $is_product , 'message' => 'Details Saved Successfully')));
			 }
				break;
			case 'reload':
				$data = array(
						'categories' => Category::all(array('conditions' => 'active = 1'))
					);
					$this->load->view('backend/categories/list_categories.php', $data);
				break;
			case 'update':
				$this->form_validation->set_rules('category_name', 'Category Name', 'required|max_length[30]');
				//$this->form_validation->set_rules('category_code', 'Category Code', 'required|max_length[30]');
				//$this->form_validation->set_rules('parent_id', 'Category Id', 'required|max_length[30]');
				if ($this->form_validation->run() === FALSE) {
					if(validation_errors()) {
						print_r(json_encode(array('type' => 'error', 'message' => validation_errors())));
					} else {
						$data = array(
							'action' 	 => base_url('backend/Allfunction/category/update/'.$is_product),
							'category' => Category::find($is_product),
							'selected_attr' => AttributeCategory::all(array('conditions' => array('category_id = ?',$is_product))),
							'categories' => Category::all(),
							'attributes' => Attribute::all(),
							'is_product' => $is_product
						);
						$this->load->view('backend/categories/add_categories.php', $data);
					}
				} else {
					$attributes = $this->input->post('category_attributes');
					$category = Category::find($is_product);
					$category->name = $this->input->post('category_name');
					$category->slug = $this->slug($category->id.' '.$this->input->post('category_name'));
					$category->save();
					//AttributeCategory::delete_all(array('conditions' => array('category_id = ?', $category->id)));
					$pre_attr = array();
					$cat_attributes = AttributeCategory::all(array("conditions" => array('category_id = ?',$category->id)));
					foreach ($cat_attributes as $key => $cat_attr) {
						$pre_attr[] = $cat_attr->attribute_id;
					}
					$pre_attr = array_unique($pre_attr);
					$attributes = array_unique($attributes);
					$unchanged_attr = array_intersect($pre_attr, $attributes);
					foreach ($attributes as $attribute) {
						if (!in_array($attribute,$unchanged_attr)) {
							AttributeCategory::create(array(
								'category_id' => $category->id,
								'attribute_id' => $attribute,
							));
						}
					}
					foreach ($pre_attr as $key => $attr) {
						if (!in_array($attr, $unchanged_attr)) {
							$attr_del = AttributeCategory::find(array("conditions" => array("category_id = ? AND attribute_id = ?",$category->id,$attr)));
							$attr_del->delete();
						}
					}
					print_r(json_encode(array('type' => 'success', 'url' => base_url('backend/Allfunction/category/reload'), 'message' => 'Details Saved Successfully')));
				}
				break;
			case 'delete':
				try {
					$category = Category::find($is_product);
				} catch (ActiveRecord\ActiveRecordException $ex) {
					$category = NULL;
				}	
				if($category) {
					$category->active = 0;
				}	
				if($category->save()){
					print_r(json_encode(array('status' => 'success')));
				}else {
		      		print_r(json_encode(array('status' => 'fail')));
				}
			break;
		 default:
				$data = array(
					'categories' => Category::all(array('conditions' => array("active = '1'")))
				);
				$this->template->load('backend/base', 'backend/categories/list_categories.php', $data);
			break;
		}
	}

	public function attribute($case = null , $id = null) {
		switch ($case) {
			case 'add':
				$this->form_validation->set_rules('attribute_name','Attribute Name' , 'required|max_length[30]');
				if($this->form_validation->run() === FALSE) {
					if (validation_errors()) {
						print_r(json_encode(array('type' => 'error', 'message' => validation_errors())));
					} else {
						$data = array(
							'action' => base_url('backend/Allfunction/attribute/add'),
							);
						$this->load->view('backend/attributes/add_attributes.php', $data);
					}
				} else {
					$attribute_slug = $this->slug($this->input->post('attribute_name'));
			    	try {
			    		$search_attribute = Attribute::first(array("conditions" => array("active = '1' AND slug = ?",$attribute_slug)));
			    	} catch (ActiveRecord\ActiveRecordException $ex) {
			    		$search_attribute = NULL;
			    	}
			    	if(!$search_attribute) {
						$attribute_name = $this->input->post('attribute_name');
						$attribute_values = $this->input->post('attr_value');
						$attribute = Attribute::create(array(
							'name' => $attribute_name,
							'active' => 1
						));
						foreach ($attribute_values as $attribute_value) {
							AttributeValue::create(array(
								'attribute_id' => $attribute->id,
								'value'				 => $attribute_value
							));
						}
						print_r(json_encode(array('type' => 'success','url' => base_url('backend/Allfunction/attribute/reload'), 'message' => 'Details Saved Successfully')));
					} else {
						print_r(json_encode(array('type' => 'false','url' => base_url('backend/Allfunction/attribute/reload'), 'message' => 'Attribute already exist')));
					}
				}
			break;
			case 'update':
				$this->form_validation->set_rules('attribute_name','Attribute Name' , 'required|max_length[30]');
					if($this->form_validation->run() === FALSE) {
						if (validation_errors()) {
							print_r(json_encode(array('type' => 'error', 'message' => validation_errors())));
						} else {
							$data = array(
								'action' => base_url('backend/Allfunction/attribute/update/'.$id),
								'attribute_detail' => Attribute::find($id),
								'attribute_detail_values' => AttributeValue::all(array('conditions' => array(" attribute_id = ?",$id)))
							);
							$this->load->view('backend/attributes/add_attributes.php', $data);
						}
					} else {
						$attribute_values = $this->input->post('attr_value');
						$attribute_name = $this->input->post('attribute_name');
						$attribute = Attribute::find($id);

						$pre_attr = $attribute_vals = array();
						$attr_values = AttributeValue::all(array("conditions" => array('attribute_id = ?',$attribute->id)));
						// to remove extra spaces 
						foreach ($attr_values as $key => $attr_val) {
							$pre_attr_val[] = preg_replace("/[^a-zA-Z]+/", "", $attr_val->value);
						}
						foreach ($attribute_values as $key => $attribute_val) {
							$attribute_vals[] = preg_replace("/[^a-zA-Z]+/", "", $attribute_val);
						}

						$pre_attr_val = array_unique($pre_attr_val);
						$attribute_values = array_unique($attribute_vals);
						$unchanged_values = array_intersect($pre_attr_val, $attribute_values);
						//$attr_value = AttributeValue::delete_all(array('conditions' => array("attribute_id = ?",$attribute->id)));
						//print_r($attribute->attribute_values);die();
						$attribute->name = $attribute_name;
						$attribute->save();
						foreach ($attribute_values as $attribute_vl) {
							if (!in_array($attribute_vl,$unchanged_values)) {
								AttributeValue::create(array(
									'value' => $attribute_vl,
									'attribute_id' => $attribute->id,
								));
							}
						}
						foreach ($pre_attr_val as $key => $val) {
							if (!in_array($val, $unchanged_values)) {
								$attr_del = AttributeValue::find(array("conditions" => array("value = ? AND attribute_id = ?",$val,$attribute->id)));
								$attr_del->delete();
							}
						}

						/*$attribute->name = $attribute_name;
						$attribute->save();
						foreach ($attribute_values as $attribute_value) {
							AttributeValue::create(array(
								'attribute_id' => $attribute->id,
								'value'		   => $attribute_value
							));
						}*/
						print_r(json_encode(array('type' => 'success','url' => base_url('backend/Allfunction/attribute/reload'), 'message' => 'Details Saved Successfully')));
					}
			break;
			case 'reload':
				$data = array(
					'attributes' => Attribute::all(array('conditions' => array("active = '1'"))),
					'attribute_values' => AttributeValue::all(),
				);
				$this->load->view('backend/attributes/list_attributes.php', $data);
			break;
			default:
				$data = array(
					'attributes' => Attribute::all(array('conditions' => array("active = '1'"))),
					'attribute_values' => AttributeValue::all(),
				);
				$this->template->load('backend/base','backend/attributes/list_attributes.php', $data);
				break;
		}
	}

	public function product($case = null , $id = null) {
		$this->data['brands'] = Brand::all(array('conditions' => array("active = '1'")));
		$this->data['categories'] = Category::all(array('conditions' => array("active = '1'")));
		$this->data['products'] = Product::all(array('conditions' => array("active = '1'")));
		$this->load->library("paginationview");
	    $per_page = 15;
		switch ($case) {
			case 'add':
			    $this->form_validation->set_rules('model_no', 'Model Number Required', 'required|max_length[100]|trim');
			    $this->form_validation->set_rules('name', 'Product Name', 'required|max_length[200]|trim');
			    $this->form_validation->set_rules('code', 'Product Code', 'required|max_length[200]|trim');
			    $this->form_validation->set_rules('sku', 'SKU Number', 'required|max_length[30]|trim');
			    $this->form_validation->set_rules('barcode', 'Barcode', 'required|max_length[30]|trim');
			    $this->form_validation->set_rules('brand_id', 'Brands', 'required|max_length[30]|trim');
			    $this->form_validation->set_rules('mrp', 'MRP', 'required|max_length[30]|trim');
			    //print_r($this->input->post());die();
			    if ($this->form_validation->run() === FALSE) {
			  		$this->data['currentPage'] = 'Add Products';
			  		$data = array(
						'action'  => base_url('backend/Allfunction/product/add')
					);
			  		$this->template->load('backend/base', 'backend/products/add_products.php', array_merge($data,$this->data));
			    } else {
			    	//print_r($this->input->post()); die();
			    	$clean_pro_code = preg_replace('/\s+/', '',$this->input->post('code'));
			    	//$product_slug = $this->slug($this->input->post('code'));
			    	try {
			    		$search_product = Product::first(array("conditions" => array("active = '1' AND code = ?",$clean_pro_code)));
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
				      	$product = Product::create(array(
							'name' 				=> $this->input->post('name'),
							//'slug'				=> $this->slug($this->input->post('name')),
							'brand_id' 			=> $this->input->post('brand_id'),
							'mrp' 				=> $this->input->post('mrp'),
							'added_by'			=> $this->data['current_user_details']->id,
							'code' 				=> $clean_pro_code,
							'sku' 				=> $this->input->post('sku'),
							'barcode' 			=> $this->input->post('barcode'),
							'cost_price'		=> $this->input->post('cost_price'),
							'model_no' 			=> $this->input->post('model_no'),
							'description' 		=> $this->input->post('description'),
							'status'			=> 1,
							'active' 			=> 1
						));
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
						Inventory::create(array(
							'product_id'		=> $product->id,
							'quantities'		=> $this->input->post('quantity'),
							'offer'				=> $this->input->post('offer'),
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
						$this->session->set_flashdata('success', 'Details Saved Successfully.');
			            redirect('backend/allfunction/product/all' , 'refresh');
		            } else {
		            	$this->session->set_flashdata('message', $this->input->post('name').' Product already Exist please update Inventory');
			            redirect('backend/allfunction/product/all' , 'refresh');
		            }
			    }
			break;
			case 'all':
	                $base_url = base_url() . "backend/Allfunction/product/all";

					$page = ($this->input->get("per_page")) ? $this->input->get("per_page") : 0;
					$brand_filter = $this->input->get('brand_filter');
					if (isset($brand_filter) && $brand_filter != '') {
	                	$product_count = Product::count(array('conditions' => array("active = '1' AND brand_id = ?",$brand_filter)));
						$data = array(
							'default_brand' => $brand_filter,
							'product_count' => $product_count,
							'list'	   => 'All Products',
							'products'		=> Product::all(array('conditions' => array("active = '1' AND brand_id = ?",$brand_filter),"limit" => $per_page, "offset" => $page))
							);
					} else {
						$product_count = Product::count(array('conditions' => array("active = '1'")));
						$data = array(
							'products' => Product::all(array('conditions' => "active = '1'","limit" => $per_page, "offset" => $page)),
							'product_count' => $product_count,
							'list'	   => 'All Products'
							);
					}
	                $config = $this->paginationview->pagination($base_url, $product_count, $per_page);
	                $this->pagination->initialize($config);
					$this->data['currentPage'] = 'All Products';
					$this->template->load('backend/base', 'backend/products/list_products.php', array_merge($this->data,$data));
			break;
			case 'pending_products':
	                $base_url = base_url() . "backend/Allfunction/product/pending_products";
	                
	                $product_count = Product::count(array('conditions' => "active = '1' AND status = '0'"));

	                $page = ($this->input->get("per_page")) ? $this->input->get("per_page") : 0;
	                $config = $this->paginationview->pagination($base_url, $product_count, $per_page);
	                $this->pagination->initialize($config);
					$brand_filter = $this->input->get('brand_filter');
					if (isset($brand_filter) && $brand_filter != '') {
						$data = array(
							'default_brand' => $brand_filter,
							'products'		=> Product::all(array('conditions' => array("active = '1' AND brand_id = ? AND status = '0'",$brand_filter),"limit" => $per_page, "offset" => $page)),
							'product_count' => $product_count,
							'list'	   => 'Pending Products'
							);
					} else {
						$data = array(
							'products' => Product::all(array('conditions' => array("active = '1' AND status = '0'"),"limit" => $per_page, "offset" => $page)),
							'product_count' => $product_count,
							'list'	   => 'Pending Products'
							);
					}
					$this->data['currentPage'] = 'All Products';
					$this->template->load('backend/base', 'backend/products/list_products.php', array_merge($this->data,$data));
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
			  		$data = array(
						'product' => Product::find($id),
						'action'  => base_url('backend/Allfunction/product/update/'.$id)
					);
					$this->template->load('backend/base', 'backend/products/add_products.php',array_merge($data,$this->data));
			    } else {
			    	//print_r($this->input->post('parent_id')); die();
			    	$product_id = $this->input->post('product_id');
			    	$product = Product::find($product_id);
			    	$attr_count = 0;
			    	$product->update_attributes($this->input->post(array('name','brand_id','mrp','sku','barcode','model_no','description','cost_price'),TRUE));
					$sub_id = $this->input->post('cat_num');
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
						$this->session->set_flashdata('success', 'Details Saved Successfully.');
		                redirect('backend/allfunction/product/all' , 'refresh');
			    }
			break;
			case 'delete':
					$product = Product::find($id);
					$product->active = 0;
					$product->save();
					redirect(base_url('backend/Allfunction/product/all?per_page='.$this->input->get('per_page')));
			break;
			case 'product_details':
					$data = array(
						'product_details' => Product::find($id),
					);
					$this->template->load('backend/base', 'backend/products/product_details.php', array_merge($data, $this->data));
			break;
			default:
				$this->template->load('backend/base', 'backend/products/list_products.php', $this->data);
			break;
		}
	}

	public function add_product_attr() {
		$data = array(
			'action' => base_url("backend/allfunction/add_brand/add")
		);
		$this->load->view('backend/products/add_attr_modal.php', $data);
	}

	public function list_vendor() {
		$data = array(
			'vendors' => User::all(array("joins"=>"JOIN users_groups ug ON ug.user_id = users.id JOIN groups g ON g.id = ug.group_id","conditions" => array("ug.group_id = '3'")))
		);
		$this->template->load('backend/base', 'backend/sales/vendor.php', array_merge($this->data,$data));
	}

	public function vendor_details($vendor_id) {

		$data = array(
			'vendor' => User::find($vendor_id),
			//'products' => Product::all(array("conditions" => array("added_by = ?",$vendor_id)))
		);
		$this->template->load('backend/base', 'backend/sales/vendor_details.php', array_merge($this->data,$data));
	}

	public function list_customer() {
		$data = array(
			'customers' => User::all(array("joins"=>"JOIN users_groups ug ON ug.user_id = users.id JOIN groups g ON g.id = ug.group_id","conditions" => array("ug.group_id = '2'")))
		);
		$this->template->load('backend/base', 'backend/sales/customer.php', array_merge($this->data,$data));
	}

	public function customer_details($customer_id) {
		$data = array(
			'customer' => User::find($customer_id),
			'orders' => Order::all(array("conditions" => array("user_id = ?",$customer_id))),
			'user_all_products' => Order::first(array("select" => "sum( quantity ) as total, sum( order_total ) as income ", "conditions" => array("user_id = ?",$customer_id))),
			'user_delivered_products' => Order::first(array("select" => "sum( quantity ) as total", "conditions" => array("user_id = ? AND is_delivered = '1'",$customer_id))),
		);
		$this->template->load('backend/base', 'backend/sales/customer_details.php', array_merge($this->data,$data));
	}
}
