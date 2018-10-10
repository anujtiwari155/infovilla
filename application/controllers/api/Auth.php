<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Auth
 *
 * @author Abhishek
 */
class Auth extends MY_APIController {

    //put your code here
    function __construct() {
        parent::__construct();
    }

    public function login_post() {
        $request = json_decode($this->input->raw_input_stream);
        try {
            $user = User::find(array('conditions' => array("email = '".$request->email."'")));
        } catch (ActiveRecord\ActiveRecordException $e) {
            $user = NULL;
        }
        if(!$user) {
            $this->response([
                'status' => TRUE,
                'response' => 'User Does Not Exist',
                'code' => $this->response_codes['SUCCESS']
                    ], REST_Controller::HTTP_OK);
        }
        
        if ($this->ion_auth->login($user->email, $request->password)) {
            
            $token = $this->set_token($user);
            $this->response([
                'status' => TRUE,
                'response' => array('id' => $user->id, 'name' => $user->get_full_name(), 'phone' => $user->phone, 'ip_address' => $user->ip_address, 'token' => $token, 'role' => $user->groups[0]->name),
                'code' => $this->response_codes['SUCCESS']
                    ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => TRUE,
                'response' => 'Wrong Credentials',
                'code' => $this->response_codes['SUCCESS']
                    ], REST_Controller::HTTP_OK);
        }
    }

    public function sign_up_post() {

        $request = json_decode($this->input->raw_input_stream);

        try {
            $is_user = User::find_by_email($request->email);
        } catch (ActiveRecord\ActiveRecordException $ex) {
            $is_user = NULL;
        }
        if (!$is_user) {
            if (isset($request->email) && $request->password != '') {
                $user = User::create(array(
                    'first_name' => (isset($request->first_name)) ? $request->first_name : '',
                    'last_name' => (isset($request->last_name)) ? $request->last_name : '',
                    'phone' => (isset($request->phone)) ? $request->phone : '',
                    'email' => $request->email,
                    'active' => 1
                ));
                UserProfile::create(array(
                    'user_id'   => $user->id,
                    'address'   => (isset($request->address)) ? $request->address : '',
                    'city'      => (isset($request->city)) ? $request->city : '',
                    'country'   => (isset($request->country)) ? $request->country : '',
                    'state'     => (isset($request->state)) ? $request->state : '',
                    'zip'       => (isset($request->zip)) ? $request->zip : ''
                ));
                UsersGroup::create(array(
                    'user_id' => $user->id,
                    'group_id' => 2
                ));
                if (isset($request->password)) {
                    $this->ion_auth->reset_password($user->email, $request->password);
                }
                $this->response([
                    'status' => TRUE,
                    'response' => 'Successfully Registered',
                    'code' => $this->response_codes['SUCCESS']
                        ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'response' => 'Please enter email ID and Password',
                    'code' => $this->response_codes['AUTH_FAIL']
                        ], REST_Controller::HTTP_FORBIDDEN);
            }
        } else {
            $this->response([
                'status' => FALSE,
                'response' => 'Email Id already registered',
                'code' => $this->response_codes['AUTH_FAIL']
                    ], REST_Controller::HTTP_FORBIDDEN);
        }
    }

    public function logout_get() {
        if ($this->destroy_token()) {
            $this->response([
                'status' => TRUE,
                'response' => 'Logged Out Successfully',
                'code' => $this->response_codes['SUCCESS']
                    ], REST_Controller::HTTP_OK);
        }
        $this->response([
            'status' => FALSE,
            'response' => 'Invalid Session',
            'code' => $this->response_codes['FAILED']
                ], REST_Controller::HTTP_BAD_REQUEST);
    }

    public function forget_password_post() {
        $request = json_decode($this->input->raw_input_stream);
        try {
            $user = User::find(array('conditions' => array("active = '1' AND email = '".$request->email."'")));
        } catch (ActiveRecord\ActiveRecordException $e) {
            $user = NULL;
        }
        if ($user) {
            $pin = rand();
            $user->forgotten_password_code = $pin;
            if ($user->save()) {
                $subject = "Password reset code at InfoVilla";
                $message = "Your password reset PIN : ".$pin;
                $this->load->library('Custom_email');
                $sent = $this->custom_email->send($user->email , "InfoVilla" , $subject, $message);
                $this->response([
                    'status' => TRUE,
                    'response' => 'Reset Code Sent',
                    'code' => $this->response_codes['SUCCESS']
                        ], REST_Controller::HTTP_OK);
            };
                
        } else {

         $this->response([
            'status' => TRUE,
            'response' => 'Mail id not Registered',
            'code' => $this->response_codes['SUCCESS']
                ], REST_Controller::HTTP_OK);
        }
    }

    public function set_forget_password_post() {
        $request = json_decode($this->input->raw_input_stream);
        try {
            $user = User::find(array('conditions' => array("active = '1' AND email = '".$request->email."'")));
        } catch (ActiveRecord\ActiveRecordException $e) {
            $user = NULL;
        }

        if ($user->forgotten_password_code == $request->pin) {
            $this->ion_auth->reset_password($user->email, $request->password);
            $this->response([
                'status' => TRUE,
                'response' => 'Password Changed',
                'code' => $this->response_codes['SUCCESS']
                    ], REST_Controller::HTTP_OK);
            
            /*$user->forgotten_password_code = '';
            $user->save();*/
        } else {
            $this->response([
                'status' => TRUE,
                'response' => 'PIN is not correct',
                'code' => $this->response_codes['SUCCESS']
                    ], REST_Controller::HTTP_OK);
            
        }
    }
}