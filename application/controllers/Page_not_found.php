<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_not_found extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->get_menu_list();
		$this->check_user();
		/*$this->data['pages'] = page::all();*/
		// to get current Url to redirect after login  ....
		$this->data['url']  = current_url();
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
  	public function index()
 	{
 		redirect(base_url());
 	}
}
 ?>