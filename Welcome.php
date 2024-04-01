<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$this->load->view('home');
	}

	public function registerNow()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->form_validation->set_rules('username','User name', 'required');
			$this->form_validation->set_rules('email','Email', 'required');
			$this->form_validation->set_rules('password','Password', 'required');
			
			if ($this->form_validation->run() == TRUE) {
				$username = $this->input->post('username');
				$email = $this->input->post('email');
				$password = $this->input->post('password');

				$data = array(
					'username' => $username,
					'email' => $email,
					'password' => sha1($password),
					'status' => '1'
				);

				$this->load->model('user_model');
				$this->user_model->insertuser($data);
				$this->session->set_flashdata('success','Successfully user created');
				redirect(base_url('welcome/index'));
			}
		}
	}

	function login()
	{
		$this->load->view('login');
	}

	function loginnow()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->form_validation->set_rules('email','	Email','required');
			$this->form_validation->set_rules('password', 'Password','required');
			
			if ($this->form_validation->run() == TRUE) {
				$email = $this->input->post('email');
				$password = $this->input->post('password');
				$password = sha1($password);
				# code...

				$this->load->model('user_model');
				$status = $this->user_model->checkPassword($password,$email);
				if ($status!=false) {
				 	
					$username = $status->username;
					$email = $status->email;

					$session_data = array(
						'username' => $username,
						'password' => $email,
					);

					$this->session->set_userdata('userLoginsession', $session_data);

					redirect(base_url('Welcome/dashboard'));

				 } 

				 else{	
				 	$this->session->set_flashdata('error','Email or Password is wrong');
				 	redirect(base_url('Welcome/login'));
				 }
			}

			else{

				$this->session->set_flashdata('error', 'Fill all the required fileds');
				redirect(base_url('Welcome/login'));
			}

		}
	}

	function dashboard() {
		$this->load->view('dashboard');
	}

	function logout() {
		session_destroy();
		redirect(base_url('welcome/login'));
	}

}
