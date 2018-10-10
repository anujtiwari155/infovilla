<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->data['currentPage'] = 'Home';
 		$this->data['title']  = 'Welcome to DaruWala';
 		$this->get_menu_list();
 		$this->check_user();
    $this->data['user_area_zip'] = $this->check_user_area();
    $this->session->set_userdata($this->data);
    // to get current Url to redirect after login  ....
    /*$this->data['url']  = current_url();
    $this->session->set_userdata($this->data);*/
	}
  public function product_detail($slug = null)
 	{
 		$this->data['currentPage'] = 'Product Detail';
 		try {
 			$product = Product::first(array('conditions' => array('active = 1 AND slug = ?',$slug)));
 		} catch (ActiveRecord\ActiveRecordException $ex) {
 			$product = NULL;
 		}
 		if($product) {
	 		$this->data['title']  = $product->name;
	 		$data = array(
	 			'product'	   => $product
	 			);
	 		$this->template->load('Frontend/base', 'Frontend/product_detail.php', array_merge($this->data,$data));
 		}
 	}

  public function product_list($case= null, $filter = null) {
  	//$this->data['currentPage'] = 'Product list';
    //print_r($this->input->get());
    $area_zip_code = $this->session->user_area_zip;
    $vendors = VendorArea::all(array("conditions" => array("zip_code = ? ",$area_zip_code)));
      $products_list = array();
      foreach ($vendors as $key => $vendor) {
        $products_list[] = $vendor->vendor_products();
      }
      $a_product_ids = array();
      foreach ($products_list as $key => $products) {
        foreach ($products as $key => $product) {
          $a_product_ids[] = $product->id;
        }
      }
      if (isset($a_product_ids[0])) {
        $product_ids_area = array_unique($a_product_ids);
        $area_product_ids = implode("','",$product_ids_area);
      }
     // print_r($product_ids_area); die();
    $filter_condition = array();
  	switch ($case) {
  		case 'category':
          $category = Category::find_by_slug($filter);
          $category_id = $category->id;
          $products = ProductCategory::all(array("conditions" => array("category_id = ?",$category_id)));
          $product_ids = array();
          $product_attribute = array();
          foreach ($products as $product) {
            $product_ids[] = $product->product_id;
          }
          $product_ids=array_intersect($product_ids,$product_ids_area);
          //print_r($product_ids); die();
          $brand_filters = $this->input->get('filter_brand');             // to get brand filter input
          $attribute_filters = $this->input->get('attribute_value');       // to get attribute filter input
          if(isset($brand_filters) && $brand_filters != '') {
            $brand_get = array();
            foreach ($brand_filters as $brand_filter) {
              $brand_get[] = $brand_filter;
            }
            $product_brand_filter = join("','", array_unique($brand_get));
            array_push($filter_condition, " AND brand_id IN ('".$product_brand_filter."')");       // Creating conditions according to filter
          }
          if(isset($attribute_filters) && $attribute_filters != '') {
            $attribute_get = array();
            foreach ($attribute_filters as $attribute_filter) {
              $attribute_get[] = $attribute_filter;
            }
            $product_attr_filter = join("','", array_unique($attribute_get));
            $product_attr_list = ProductAttribute::all(array("conditions" => array("attribute_value_id IN ('".$product_attr_filter."')")));
            foreach ($product_attr_list as $key => $product_attr) {
              $product_attribute[] = $product_attr->product_id;
            }
            $product_ids=array_intersect($product_ids,$product_attribute,$product_ids_area);
            //print_r($product_ids); die();
            //print_r($product_attribute);
          }
          if(isset($filter_condition)) {
              $search_str = join(' ',$filter_condition); 
          } else {
              $search_str = " ";
          } 
          //print_r($search_str);
  				$product_ids = join("','", array_unique($product_ids));
  				$final_products = Product::all(array("conditions" => array("products.id IN ('".$product_ids."') AND active = '1' AND status = '1'".$search_str)));
          // to get brand list of given products
          $brand_ids = array();
          foreach ($final_products as $key => $final_product) {
            $brand_ids[] = $final_product->brand_id;
          }
          if(isset($brand_ids)) {
            $brands_id = join("','" , $brand_ids);
          } else {
            $brands_id = " ";
          }
          //print_r($brand_ids); 
  				$data = array(
  					'products' => $final_products,
            'current_url'      => $case.'/'.$filter,
            'default_brands' => (isset($brand_get)) ? $brand_get : array(),
            'default_attributes' => (isset($attribute_get)) ? $attribute_get : array(),
            'brands'   => Brand::all(array("conditions" => array("id IN ('".$brands_id."') AND active = '1'"))),
            'attributes'   => Attribute::all(array("joins" => "JOIN attribute_categories ac ON ac.attribute_id = attributes.id", "conditions" => array("attributes.active = '1' AND ac.category_id = ?",$category_id))),
            'attribute_values'   => AttributeValue::all()
  					);
  				$this->template->load('Frontend/base', 'Frontend/product_list.php', array_merge($this->data,$data));
  			break;
      case 'brand':
          $brand = Brand::find_by_slug($filter);
          $product_brand_filter = $brand->id;
          $product_attribute = array();
          $search_str = '';
          $brand_filters = $this->input->get('filter_brand');             // to get brand filter input
          $attribute_filters = $this->input->get('attribute_value');       // to get attribute filter input
          if(isset($brand_filters) && $brand_filters != '') {
            $brand_get = array();
            foreach ($brand_filters as $brand_filter) {
              $brand_get[] = $brand_filter;
            }
            $product_brand_filter = join("','", array_unique($brand_get));
          }
          if(isset($attribute_filters) && $attribute_filters != '') {
            $attribute_get = array();
            foreach ($attribute_filters as $attribute_filter) {
              $attribute_get[] = $attribute_filter;
            }
            $product_attr_filter = join("','", array_unique($attribute_get));
            $product_attr_list = ProductAttribute::all(array("conditions" => array("attribute_value_id IN ('".$product_attr_filter."')")));
            foreach ($product_attr_list as $key => $product_attr) {
              $product_attribute[] = $product_attr->product_id;
            }
            $product_attribute = join("','", $product_attribute);
            $search_str = " AND products.id IN ('".$product_attribute."')";
          }
          $final_products = Product::all(array("conditions" => array("id IN ('".$area_product_ids."') AND brand_id IN ('".$product_brand_filter."') AND active = '1' AND status = '1'".$search_str)));
          $data = array(
            'products' => $final_products,
            'current_url'      => $case.'/'.$filter,
            'default_brands' => (isset($brand_get)) ? $brand_get : array('id'=>$brand->id),
            'default_attributes' => (isset($attribute_get)) ? $attribute_get : array(),
            'brands'   => Brand::all(array("conditions" => array("active = '1'"))),
            'attributes'   => Attribute::all(array("conditions" => array("active = '1'"))),
            'attribute_values'   => AttributeValue::all()
            );
          $this->template->load('Frontend/base', 'Frontend/product_list.php', array_merge($this->data,$data));
        break;
  		default:
  			# code...
  			break;
  	}
  }

  public function more_category(){
    $this->data['categories'] = Category::all(array("conditions" => array("active = '1' AND lavel='1'")));
    $this->template->load('Frontend/base', 'Frontend/more_categories.php',$this->data);
  }

}
