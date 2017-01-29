<?php
class Auth_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Survey_model','',TRUE);
        $this->load->library('bcrypt');
    }
    
    // Create new user
    function create_user($data){
        
        $res = $this->db->insert('user',$data);
        
        if($res){
            
            return TRUE;
            
        }else{
            
            return FALSE;
            
        }
        
    }
    
    // Login user
    function login_user($email,$password){
        
        $res = $this->db->get_where('user',array('email'=>$email));
        
        if($res->num_rows()>0){
            
            $user = $res->row();
            
            if ($this->bcrypt->check_password($password, $user->password))
            {
                unset($user->password);
                
                if($user->last_login==NULL){
                    
                    $this->Survey_model->assignAllToNewUser($user->id);
                    
                }
                
                $this->db->update('user', array(
                'last_login'=>date("Y-m-d H:i:s")
                ));
                
                $this->session->set_userdata(array(
                'user'=>$user
                ));
                
                return TRUE;
                
            }
            else
            {
                return FALSE;
            }
            
        }else{
            
            return FALSE;
            
        }
        
    }
    
    // Logout user
    function logout_user(){
        
        $this->session->sess_destroy();
        
    }
    
}