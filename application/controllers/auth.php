<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Authentication controller
class Auth extends CI_Controller {
    
    function __construct(){
        
        parent::__construct();
        
        // Load libraries
        $this->load->model('Auth_model','',TRUE);
        $this->load->library('bcrypt');
        $this->load->library('form_validation');

    }
    
    // Login action
    public function login(){
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
        
        if ($this->form_validation->run() == FALSE){
            // Validation fails
            $this->load->view('common/header');
            $this->load->view('common/nav');
            $this->load->view('auth/login');
            $this->load->view('common/footer');
            
            
        }else{
            // Validation passes
            $email = $this->input->post('email', TRUE);
            $password = $this->input->post('password', TRUE);
            
            $res = $this->Auth_model->login_user($email,$password);
            
            if($res===TRUE){
                redirect('/');
            }else{
                $this->session->set_flashdata('auth_error', 'Invalid email or password provided!');
                redirect('auth/login');
            }
            
        }
        
    }
    
    // Register action
    public function register(){
        
        $this->form_validation->set_rules('user_fname', 'First Name', 'required');
        $this->form_validation->set_rules('user_lname', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        
        if ($this->form_validation->run() == FALSE){
            // Validation fails
            $this->load->view('common/header');
            $this->load->view('common/nav');
            $this->load->view('auth/register');
            $this->load->view('common/footer');
            
        }else{
            // Validation passes
            $user_fname = $this->input->post('user_fname', TRUE);
            $user_lname = $this->input->post('user_lname', TRUE);
            $email = $this->input->post('email', TRUE);
            $password = $this->input->post('password', TRUE);
            
            $this->load->library('encrypt');
            $password_hash = $this->bcrypt->hash_password($password);
            
            $data = array(
            'user_fname'=>$user_fname,
            'user_lname'=>$user_lname,
            'email'=>$email,
            'password'=>$password_hash,
            'created_on'=>date("Y-m-d H:i:s")
            );
            
            // Call model save for user 
            $res = $this->Auth_model->create_user($data);
            
            if($res===TRUE){
                
                redirect('/auth/login');
                
            }else{
                $this->session->set_flashdata('auth_error', 'Unable to create user. Please try again.');
                redirect('auth/register');
            }
            
        }
        
    }
    
    // Logout action
    function logout(){
        
        $this->Auth_model->logout_user();
        redirect('auth/login');
        
    }
    
}