<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->get_menu_list();
		$this->check_user();
		/*$this->data['pages'] = page::all();*/
		// to get current Url to redirect after login  ....
		$this->data['url']  = current_url();
		$this->data['user_area_zip'] = $this->check_user_area();
        $this->session->set_userdata($this->data);

		
      /*  $this->data['pages'] = Page::find_by_slug('contact');*/
		/*$menus= Menu::all();*/
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

	public function set_zip_code($zip) {
		$this->cart->destroy();
		$this->data['user_area_zip'] = $this->check_user_area($zip);
		$this->session->set_userdata($this->data);
	}

  	public function home()
 	{
		$this->data['currentPage'] = 'Home';
 		$this->data['title']  = 'Welcome to Alcoholic';
		$this->data['contents'] = Content::first();
 		$this->template->load('Frontend/base', 'Frontend/home.php',$this->data);
 	}
 	
	public function search_main() {
		$search_key = $this->input->get('search');
		$search_value = preg_split ("/\-/", $search_key);
		$case = (isset($search_value[1])) ? trim($search_value[1]) : '';
		$slug = $this->slug(trim($search_value[0]));
		switch ($case) {
			case 'Category':
				redirect(base_url('category').'/'.$slug);
				break;
			case 'Brand':
				redirect(base_url('brand').'/'.$slug);
				break;
			case 'Product':
				redirect(base_url('product').'/'.$slug);
				break;
			default:
				$this->load->library("paginationview");
				$per_page = 16;
				$base_url = base_url() . "Main/search_main";
				$page = ($this->input->get("per_page")) ? $this->input->get("per_page") : 0;
				$product_count = Product::count(array("conditions" => array("name LIKE '%{$slug}%' AND active = '1' AND status = '1'")));
	            $config = $this->paginationview->pagination($base_url, $product_count, $per_page);
	            $this->pagination->initialize($config);
				$searched_product = Product::all(array("conditions" => array("name LIKE '%{$slug}%' AND active = '1' AND status = '1'"),"limit" => $per_page, "offset" => $page));
				$data = array(
		            'products' => $searched_product,
		            'current_url'      => $case.'/'.$slug,
		            'brands'   => Brand::all(array("conditions" => array("active = '1'"))),
		            'attributes'   => Attribute::all(array("conditions" => array("active = '1'"))),
		            'attribute_values'   => AttributeValue::all()
		            );
		        $this->template->load('Frontend/base', 'Frontend/product_list.php', array_merge($this->data,$data));
				//print_r($searched_product);
				break;
		}
	}

	public function sign_up() {
		$this->form_validation->set_rules('mail_id', 'Enquiry Mail_id.', 'required|max_length[30]|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|max_length[30]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|max_length[30]');
		$this->data['current_page'] = "Sign up Page";
		if ($this->form_validation->run() === FALSE) {
			//$this->session->set_flashdata('success', 'Successfully Logged In');
			$this->template->load('Frontend/base', 'Frontend/sign_up.php',$this->data);	
		} else {
            $user = User::create(array(
                'first_name' => $this->input->post('first_name', TRUE),
                'last_name' => $this->input->post('last_name', TRUE),
                'phone' => $this->input->post('phone', TRUE),
                'email' => $this->input->post('mail_id', TRUE),
                'active' => 1
            ));
            UserProfile::create(array(
            	'user_id'	=> $user->id,
            	'address'	=> $this->input->post('address1', TRUE) ."\n". $this->input->post('address2', TRUE),
            	'city' 		=> $this->input->post('city', TRUE),
            	'country' 	=> $this->input->post('country', TRUE),
            	'state'		=> $this->input->post('state', TRUE),
            	'zip'		=> $this->input->post('zip', TRUE)
            ));
            UsersGroup::create(array(
                'user_id' => $user->id,
                'group_id' => 2
            ));
            if ($this->input->post('password', TRUE)) {
                $this->ion_auth->reset_password($user->email, $this->input->post('password', TRUE));
            }
            $data = array(
            	'username' => $user->email,
            	'password' => $this->input->post('password', TRUE),
            	'url' 	   => base_url('home')
            	);
            $this->template->load('Frontend/base','auth/login_script.php', array_merge($this->data,$data));
            //$this->session->set_flashdata('success', 'Successfully Logged In');
			//redirect(base_url('backend/Auth/login/home'));
		}
	}

	public function user_logout($url) {
		$this->ion_auth->logout();
		redirect(base_url($url));
	}

	public function contact(){
		$this->data['current_page'] = Address::first();
		$this->template->load('Frontend/base', 'cms/contact.php',$this->data);
	}

	public function save_contact(){
		$new_contact = array(
            'name' 			=> $this->input->post('name'),
            'email' 		=> $this->input->post('email'),
            'phone' 		=> $this->input->post('phone'),
            'message' 		=> $this->input->post('message'),
            'active'  		=> 1,
            'created_date'	=> date('Y-m-d h:i:sa')
        );
        Contact::create($new_contact);
        $this->session->set_flashdata('success', 'contact successfully ');
       /* redirect(base_url() . 'Main/thanks');*/
       /*$this->load->view('cms/thankyou.php');*/
        $this->template->load('Frontend/base', 'cms/thankyou.php',$this->data);
	}

	public function pages($slug=NULL){
       $this->data['current_page'] = Page::find(array('conditions'=> array("slug = ?",$slug)));
       $this->template->load('Frontend/base', 'cms/useful_info.php',$this->data);  
	}

	public function more(){
		$this->data['brands'] = Brand::all(array("conditions" => array("active = '1'")));
		$this->template->load('Frontend/base', 'Frontend/more_brands.php',$this->data);
	}

	public function user_profile() {
		if (!$this->ion_auth->logged_in()) {
			redirect('backend/Auth/login', 'refresh');
		}
		$this->form_validation->set_rules('first_name', 'First Name', 'required|max_length[30]|trim');
		$this->form_validation->set_rules('address1', 'Address1', 'required|max_length[100]|trim');
		$this->form_validation->set_rules('city', 'City', 'required|max_length[100]|trim');
		$this->form_validation->set_rules('country', 'Country', 'required|max_length[100]|trim');
		$this->form_validation->set_rules('state', 'State', 'required|max_length[100]|trim');
		$this->form_validation->set_rules('zip', 'Zip Code', 'required|max_length[100]|trim');
		$this->form_validation->set_rules('phone', 'Phone', 'required|max_length[100]|trim');

		if ($this->form_validation->run() === FALSE) {
			$this->template->load('Frontend/base', 'Frontend/update_profile.php',$this->data);
		} else if( $this->input->post('password', TRUE) != $this->input->post('confirm_password', TRUE)) {
			$this->session->set_flashdata('message', 'Password Not matched');
			redirect(base_url('edit_profile'));
		} else {
			$current_user = User::find($this->data['current_user_details']->id);
			$current_user->first_name = $this->input->post('first_name');
			$current_user->last_name  = $this->input->post('last_name');
			$current_user->phone  	  = $this->input->post('phone');
			$current_user->save();
			$current_user->user_profile->city = $this->input->post('city');
			$current_user->user_profile->state = $this->input->post('state');
			$current_user->user_profile->address = $this->input->post('address1').' '.$this->input->post('address2');
			$current_user->user_profile->zip = $this->input->post('zip');
			$current_user->user_profile->country = $this->input->post('country');
			$current_user->user_profile->save();
			if ($this->input->post('password', TRUE) == $this->input->post('confirm_password', TRUE)) {
                $this->ion_auth->reset_password($user->email, $this->input->post('password', TRUE));
            }
			$this->session->set_flashdata('message', 'Data Save Successfully');
			redirect(base_url('edit_profile'));
		}
	}

	function my_order() {
		$customer_id = $this->data['current_user_details']->id;
		$data = array(
			'customer' => User::find($customer_id),
			'orders' => Order::all(array("conditions" => array("user_id = ?",$customer_id))),
			'user_all_products' => Order::first(array("select" => "sum( quantity ) as total, sum( order_total ) as income ", "conditions" => array("user_id = ?",$customer_id))),
			'user_delivered_products' => Order::first(array("select" => "sum( quantity ) as total", "conditions" => array("user_id = ? AND is_delivered = '1'",$customer_id))),
		);
		$this->template->load('Frontend/base', 'Frontend/my_order.php',array_merge($this->data,$data));
	}

	function order_detail($id = null) {
		$order = Order::find($id);
		$data = array(
			'order_details' => $order,
			'is_frontend'	=> 1
			);
		$this->load->view('backend/reports/report_details.php', $data);
	}
}
