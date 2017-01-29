<?php
class Survey_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    
    // Get all surveys for criteria
    function getSurveys($where=null){
        
        $this->db->select('survey_id,user_id,status,survey.*');
        $this->db->from('user_survey');
        $this->db->join('survey','survey.id=user_survey.survey_id');
        $this->db->where($where);
        $surveys = $this->db->get();
        
        return $surveys->result();
        
    }
    
    // Assign surveys to first time logged in user
    function assignAllToNewUser($user_id){
        
        $surveys = $this->db->get('survey');
        
        if($surveys->num_rows()>0){
            
            foreach($surveys->result() as $survey){
                $this->db->insert('user_survey',array(
                'user_id'=>$user_id,
                'survey_id'=>$survey->id,
                'status'=>'PENDING',
                'created_on'=>date("Y-m-d H:i:s")
                ));
                
            }
            
        }
        
    }
    
    // Load a single survey to be filled in
    function loadSurvey($survey_id, $user_id){
        
        $this->db->select('survey.name,survey_field.*');
        $this->db->from('survey');
        $this->db->join('survey_field','survey_field.survey_id=survey.id');
        $this->db->where(array('survey_id'=>$survey_id));
        $survey_fields = $this->db->get();
        
        if($survey_fields->num_rows()>0){
            
            if($survey_fields->num_rows>0){
                
                $survey_fields = $survey_fields->result();
                
                foreach($survey_fields as $field){
                    $this->db->select('*');
                    $this->db->from('survey_field_meta');
                    $this->db->where(array('field_id'=>$field->id));
                    $survey_fields_meta = $this->db->get();
                    $field->meta = $survey_fields_meta->result();
                    
                    $response = $this->db->get_where('user_survey_response',array(
                    'user_id'=>$user_id,
                    'user_survey_id'=>$survey_id,
                    'survey_field_id'=>$field->id,
                    ));
                    
                    if($response->num_rows>0){
                        $field->response = $response->result();
                    }else{
                        $field->response = null;
                    }
                    
                }
                
            }
            
            return $survey_fields;
            
        }
        
        return FALSE;
        
    }
    
    // Save user's response
    function saveSurveyResponse($survey,$user_id){
        
        foreach($survey as $survey_id=>$fields){
            
            if(!empty($fields)){
                
                foreach($fields as $field_key=>$field_value){
                    
                    foreach($field_value as $field_type=>$value){
                        
                        $responseToSave = array();
                        
                        if(!empty($value) && $value!=''){
                            
                            if($field_type=='TEXT_FIELD' || $field_type=='TEXT_AREA'){
                                
                                $responseToSave = array(array(
                                'user_id'=>$user_id,
                                'survey_field_id'=>$field_key,
                                'user_survey_id'=>$survey_id,
                                'response'=>$value,
                                'created_on'=>date("Y-m-d H:i:s")
                                ));
                                
                            }elseif($field_type=='RADIO_BUTTON' || $field_type=='DROPDOWN'){
                                $responseToSave = array(array(
                                'user_id'=>$user_id,
                                'survey_field_id'=>$field_key,
                                'user_survey_id'=>$survey_id,
                                'survey_field_meta_id'=>$value,
                                'response'=>$value,
                                'created_on'=>date("Y-m-d H:i:s")
                                ));
                            }elseif($field_type=='CHECKBOX'){
                                foreach($value as $val){
                                    array_push($responseToSave,array(
                                    'user_id'=>$user_id,
                                    'survey_field_id'=>$field_key,
                                    'user_survey_id'=>$survey_id,
                                    'survey_field_meta_id'=>$val,
                                    'response'=>$val,
                                    'created_on'=>date("Y-m-d H:i:s")
                                    )
                                    );
                                }
                            }
                            
                        }
                        
                        if(!empty($responseToSave)){
                            
                            $exists = $this->db->get_where('user_survey_response',array(
                            'user_id'=>$user_id,
                            'survey_field_id'=>$field_key,
                            'user_survey_id'=>$survey_id
                            ));
                            
                            if($exists->num_rows()>0){
                                $delete_existing = $this->db->delete('user_survey_response',array(
                                'user_id'=>$user_id,
                                'survey_field_id'=>$field_key,
                                'user_survey_id'=>$survey_id
                                ));
                            }
                            
                            foreach($responseToSave as $res){
                                
                                $save_new = $this->db->insert('user_survey_response',$res);
                                
                            }
                        }
                        
                    }
                    
                }
                
            }
            
        }
        
    }
    
    // Set survey status for a user
    function setStatus($survey_id,$user_id,$status){
        
        return $this->db->update('user_survey',array(
        'status'=>$status,
        'created_on'=>date("Y-m-d H:i:s")
        ),
        array(
        'survey_id'=>$survey_id,
        'user_id'=>$user_id
        ));
        
    }
    
    // Get user's survey status
    function getStatus($survey_id,$user_id){
        
        $status = $this->db->get_where('user_survey',array(
        'survey_id'=>$survey_id,
        'user_id'=>$user_id
        ));
        
        return $status->row()->status;
        
    }

    // Get user's survey completion date
    function getCompletiongDate($survey_id,$user_id){
        
        $status = $this->db->get_where('user_survey',array(
        'survey_id'=>$survey_id,
        'user_id'=>$user_id
        ));
        
        return $status->row()->created_on;
        
    }
    
}