<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CommonVfunction extends MY_Controller
{
    
    function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->in_group('vendor')) {
                // redirect them to the login page
                redirect('vendor', 'refresh');
        }
    }
    
    function test($dataid)
    {
        try {
            $sub_categories = Category::all(array(
                'conditions' => array(
                    "parent_id = ? AND active = '1'",
                    $dataid
                )
            ));
        }
        catch (ActiveRecord\ActiveRecordException $ex) {
            $sub_categories = NULL;
        }
        $response = array();
        if ($sub_categories) {
            foreach ($sub_categories as $sub_category) {
                array_push($response, array(
                    'id' => $sub_category->id,
                    'name' => ucwords($sub_category->name),
                    'parent_id' => $sub_category->parent_id
                ));
            }
            print_r(json_encode(array(
                'status' => 'success',
                'response' => $response
            )));
        } else {
            print_r(json_encode(array(
                'status' => 'fail'
            )));
        }
    }
    
    function list_attributes()
    {
        $attributes = Attribute::all();
        $response   = array();
        foreach ($attributes as $attribute) {
            array_push($response, array(
                'id' => $attribute->id,
                'name' => ucwords($attribute->name)
            ));
        }
        print_r(json_encode(array(
            'status' => 'success',
            'response' => $response
        )));
    }
    
    function brand($case = Null, $id = Null)
    {
        switch ($case) {
            case 'add':
                $brand_details = Brand::create(array(
                    'name' => $this->input->get('brand_name'),
                    'code' => $this->input->get('brand_code'),
                    'slug' => $this->slug($this->input->get('brand_name')),
                    'active' => 1
                ));
                $response      = array();
                if ($brand_details) {
                    $brand_list = Brand::all(array(
                        'conditions' => array(
                            "active = '1'"
                        )
                    ));
                    foreach ($brand_list as $brand) {
                        array_push($response, array(
                            'id' => $brand->id,
                            'name' => ucwords($brand->name)
                        ));
                    }
                    print_r(json_encode(array(
                        'status' => 'success',
                        'response' => $response
                    )));
                } else {
                    print_r(json_encode(array(
                        'status' => 'fail'
                    )));
                }
                break;
            case 'update':
                try {
                    $brand_detail = Brand::find($id);
                }
                catch (ActiveRecord\ActiveRecordException $ex) {
                    $brand_detail = NULL;
                }
                if ($brand_detail) {
                    $brand_detail->name = $this->input->get('brand_name');
                    $brand_detail->code = $this->input->get('brand_code');
                    $brand_detail->save();
                }
                if ($brand_detail) {
                    print_r(json_encode(array(
                        'status' => 'success'
                    )));
                } else {
                    print_r(json_encode(array(
                        'status' => 'fail'
                    )));
                }
                break;
            case 'delete':
                try {
                    $brand_detail = Brand::find($id);
                }
                catch (ActiveRecord\ActiveRecordException $ex) {
                    $brand_detail = NULL;
                }
                if ($brand_detail) {
                    $brand_detail->active = 0;
                }
                if ($brand_detail->save()) {
                    print_r(json_encode(array(
                        'status' => 'success'
                    )));
                } else {
                    print_r(json_encode(array(
                        'status' => 'fail'
                    )));
                }
                break;
            default:
                # code...
                break;
        }
        
    }
    
    function upload_image()
    {
        $str = file_get_contents('php://input');
        echo $filename = md5(time() . uniqid()) . ".jpg";
        //print_r($filename);
        file_put_contents(base_url() . "assets/products/" . $filename, $str);
        print_r($filename);
    }
    
    function attribute($case = Null, $id = Null)
    {
        switch ($case) {
            case 'delete':
                try {
                    $attribute = Attribute::find($id);
                }
                catch (ActiveRecord\ActiveRecordException $ex) {
                    $attribute = NULL;
                }
                if ($attribute) {
                    $attribute->active = 0;
                }
                if ($attribute->save()) {
                    print_r(json_encode(array(
                        'status' => 'success'
                    )));
                } else {
                    print_r(json_encode(array(
                        'status' => 'fail'
                    )));
                }
                break;
        }
    }
    
    function category_add()
    {
        $parent_id  = Category::find($this->input->post('parent'));
        $attributes = $this->input->post('attributes');
        $category   = Category::create(array(
            'name' => $this->input->post('n_category'),
            'parent_id' => $this->input->post('parent'),
            'category_code' => $this->input->post('c_category'),
            'lavel' => ++$parent_id->lavel,
            'active' => 1
        ));
        foreach ($attributes as $attribute) {
            AttributeCategory::create(array(
                'category_id' => $category->id,
                'attribute_id' => $attribute
            ));
        }
        $response = array();
        if ($category) {
            $categories = Category::all(array(
                'conditions' => array(
                    'lavel = 0',
                    $parent_id->lavel
                )
            ));
            foreach ($categories as $category) {
                array_push($response, array(
                    'id' => $category->id,
                    'name' => ucwords($category->name)
                ));
            }
            print_r(json_encode(array(
                'status' => 'success',
                'response' => $response,
                'lavel' => $parent_id->lavel
            )));
        } else {
            print_r(json_encode(array(
                'status' => 'fail'
            )));
        }
    }
    
    function attribute_validate($attribute)
    {
        try {
            $search_attribute = Attribute::first(array(
                'conditions' => array(
                    'name = ?',
                    $attribute
                )
            ));
        }
        catch (ActiveRecord\ActiveRecordException $ex) {
            $search_attribute = NULL;
        }
        if ($search_attribute) {
            print_r(1);
        } else {
            print_r(0);
        }
    }
    
    function brand_validate($brand)
    {
        try {
            $search_brand = Brand::first(array(
                'conditions' => array(
                    'name = ?',
                    $brand
                )
            ));
        }
        catch (ActiveRecord\ActiveRecordException $ex) {
            $search_brand = NULL;
        }
        if ($search_brand) {
            print_r(1);
        } else {
            print_r(0);
        }
    }
    
    function product_validate($product)
    {
        $this->check_user();
        $product_code = preg_replace('/\s+/', '',urldecode($product));
        try {
            $search_product = Product::first(array("conditions" => array("active = '1' AND status = '1' AND code = ?",$product_code)));
        } catch (ActiveRecord\ActiveRecordException $ex) {
            $search_product = NULL;
        }
        if($search_product) {
            $flag = 0;
            $vendors = $search_product->product_vendor();
            foreach ($vendors as $key => $vendor) {
                if ($vendor->user_id == $this->data['current_user_details']->id) {
                    $flag = 1;
                    break;
                }
            }

            if ($flag) {
                print_r(json_encode(array("is_vendor" => 1)));
            } else {
                print_r(json_encode(array("is_vendor" => 2,"product_id" => $search_product->id,"cost_price" => $search_product->cost_price, "mrp" => $search_product->mrp)));
            }
            
        } else {
            print_r(json_encode(array("is_vendor" => 0)));
        }
    }

    function get_attr($data = null)
    {
        try {
            $attr_id = AttributeCategory::all(array(
                'conditions' => array(
                    "category_id = ?",
                    $data
                )
            ));
        }
        catch (ActiveRecord\ActiveRecordException $ex) {
            $attr_id = NULL;
        }
        if ($attr_id) {
            foreach ($attr_id as $value) {
                $attribute          = Attribute::find($value->attribute_id);
                $attribute_values[] = $attribute->attribute_values;
                $attribute_name[]   = $attribute->name;
            }
            $response = array();
            foreach ($attribute_values as $key => $value) {
                foreach ($value as $attribute) {
                    array_push($response, array(
                        'attr_id' => $attribute->attribute_id,
                        'attr_value_id' => $attribute->id,
                        'attr_value' => $attribute->value,
                        'attr_name' => $attribute_name[$key]
                    ));
                }
            }
            print_r(json_encode(array(
                'status' => 'success',
                'attribute_details' => $response,
                'attribute' => $attribute_name
            )));
        } else {
            print_r($data);
        }
    }
    
    function delete_img($image_id = null)
    {
        $img_product = ProductImage::find_by_image_id($image_id);
        $img_product->delete();
        $image = Image::find($image_id);
        $url   = $image->image_url;
        unlink("./././assets/products/" . $url);
        $image->delete();
        print_r(json_encode(array(
            'status' => 'success',
            'description' => 'Image Deleted'
        )));
    }

    function update_inventory($product_id)
    {
        $this->form_validation->set_rules('quantity', 'Quantity Required', 'required|max_length[100]|trim');
        $this->check_user();
        $inventory = Inventory::first(array("conditions" => array("user_id = ? AND product_id = ?", $this->data['current_user_details']->id, $product_id)));
        if ($this->form_validation->run() === FALSE) {
            $product = Product::find($product_id);
            $data = array(
                'in_stock' => $inventory->quantities,
                'product_name' => $product->name,
                'action'       => base_url('vendor/CommonVfunction/update_inventory/'.$product_id)
            );
            $this->load->view('vendor/products/update_inventory.php',$data);
        } else {
            $inventory->quantities = $inventory->quantities + $this->input->post('quantity');
            $inventory->total_added = $inventory->total_added + $this->input->post('quantity');
            $inventory->save();
            redirect('vendor/Vendorfunction/product/all' , 'refresh');
        }
    }
}