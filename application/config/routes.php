<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Main/home';
$route['404_override'] = 'Page_not_found/index';
$route['translate_uri_dashes'] = FALSE;


                     //admin routes
$route['home'] = "Main/home";
$route['login'] = "backend/Auth/login";
$route['admin'] = "backend/Auth/login/admin";
$route['logout/(.+)'] = "Main/user_logout/$1";
$route['shipping'] = "frontend/Checkout/final_checkout";
$route['sign_up'] = "Main/sign_up";
$route['product/(.+)'] = "frontend/Products/product_detail/$1";
$route['basket/(.+)/(.+)'] = "frontend/Checkout/add_cart/$1/$2";
$route['basket'] = "frontend/Checkout/view_cart";
$route['payment'] = "frontend/Checkout/payment";
$route['category/(.+)'] = "frontend/Products/product_list/category/$1";
$route['categories'] = "frontend/Products/more_category";
$route['brand/(.+)'] = "frontend/Products/product_list/brand/$1";
$route['contact'] = "Main/contact";
$route['save_data'] = "Main/save_contact";
$route['more'] = "Main/more";
$route['edit_profile'] = "Main/user_profile";
$route['my_order'] = "Main/my_order";

$route['address'] = "backend/admin/address";
$route['page/(.+)'] = "Main/pages/$1";
$route['report/product'] = "backend/Report/product";
$route['report/order_list'] = "backend/Report/order_list";
//$route['(.+)'] = "frontend/main/home";

				// frontend routes
$route['vendor'] = "vendor/Vendorfunction/home";