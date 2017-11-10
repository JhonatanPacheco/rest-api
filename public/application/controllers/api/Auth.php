<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Auth extends REST_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('authmodel');
        $this->load->library('encryption');
        $this->load->helper('key');


    }

	public function login_post()
	{

		$method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {

			$check_auth_client = true;// $this->authmodel->check_auth_client();
			
			if($check_auth_client == true){
				$params  = json_decode(file_get_contents('php://input'), TRUE);//$_REQUEST;
		        
		        $username = $params['user'];
		        $password = $params['password'];
		        // print_r($this->input->get_request_header('tsec',TRUE));
		        // echo $this->input->user_agent();

		       	//print_r($username);
		        //$ciphertext = $this->encryption->encrypt($password);	
		        //echo $ciphertext;
		        // echo "\n".$this->encryption->decrypt($ciphertext);
		        $response = $this->authmodel->login($username,$password);
				
				$this->response($response, $response['status']);

				//json_output($response['status'],array('data' =>'data'  ),$response);
			}
		}
	}

	public function logout_post()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->authmodel->check_auth_client();
			if($check_auth_client == true){
		        $response = $this->authmodel->logout();
				$this->response($response, REST_Controller::HTTP_OK);
			}
		}
	}
	public function add_post(){

  		$method = $_SERVER['REQUEST_METHOD'];
  		
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else if($this->authmodel->validateToken()) {

			$check_auth_client = true;// $this->authmodel->check_auth_client();
			
			if($check_auth_client == true){
				$params  = json_decode(file_get_contents('php://input'), TRUE);//$_REQUEST;
		        
		        $username = $params['username'];
		        $password = $params['password'];
		        $name	  = $params['name'];
		      
		        $response = $this->authmodel->create($username,$password,$name);
				
				$this->response($response, REST_Controller::HTTP_OK);

				
			}
		}
	}
	
}
