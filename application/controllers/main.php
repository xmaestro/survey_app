<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
    
    function __construct(){
        
        parent::__construct();
        
        // Auth check. Needs to be better handled through ACL layer which is nonexistant in CI
        login_redirect();
        $this->load->model('Survey_model','',TRUE);
        
    }
    
    // Default action for listing
    public function index(){
        
        $data = $this->Survey_model->getSurveys(array(
        'user_id'=>user_info()->id
        ));
        
        $this->load->view('common/header');
        $this->load->view('common/nav');
        $this->load->view('main/index', array('surveys'=>$data));
        $this->load->view('common/footer');
        
    }
    
    // Loading the survey
    public function survey($survey_id){
        
        $data = $this->Survey_model->loadSurvey($survey_id,user_info()->id);
        $status = $this->Survey_model->getStatus($survey_id,user_info()->id);
        $completed = $this->Survey_model->getCompletiongDate($survey_id,user_info()->id);
        // If the user is editign the survey
        if($this->input->post('submit') || $this->input->post('save')){
            
            $survey = $this->input->post('survey_fields');
            
            $save_or_submit = $this->input->post('submit')?'submit':'save';
            
            // Check if he has submit or save option clicked
            if($save_or_submit=='submit'){
                
                if(has_empty($survey)===true){
                    $this->load->view('common/header');
                    $this->load->view('common/nav');
                    $this->load->view('main/survey', array(
                    'survey'=>$data,
                    'survey_error'=>'Please fill in all the fields to Submit this survey!'
                    ));
                    $this->load->view('common/footer');
                }else{
                    $this->Survey_model->saveSurveyResponse($survey,user_info()->id);
                    $this->Survey_model->setStatus($survey_id,user_info()->id,'COMPLETED');
                    $this->session->set_flashdata('survey_success', 'Operation successful!');
                    redirect('/');
                }
                
            }else{
                
                if(not_empty($survey)===true){
                    $this->Survey_model->saveSurveyResponse($survey,user_info()->id);
                    $this->session->set_flashdata('survey_success', 'Operation successful!');
                    $this->Survey_model->setStatus($survey_id,user_info()->id,'PARTIALLY_COMPLETED');
                    redirect('/');
                }else{
                    $this->load->view('common/header');
                    $this->load->view('common/nav');
                    $this->load->view('main/survey', array(
                    'survey'=>$data,
                    'survey_error'=>'You need to fill in atleast one field to save your work!',
                    'status'=>$status
                    ));
                    $this->load->view('common/footer');
                }
                
            }
            
        }else{
            
            $this->load->view('common/header');
            $this->load->view('common/nav');
            $this->load->view('main/survey', array('survey'=>$data, 'status'=>$status, 'completed'=>$completed));
            $this->load->view('common/footer');
            
        }
        
    }
    
}