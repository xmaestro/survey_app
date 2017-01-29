<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Checking if the user is logged in
if ( ! function_exists('is_logged_in'))
{
    function is_logged_in(){
        $CI = get_instance();
        $user = $CI->session->userdata("user");
        if(empty($user)){
            return false;
        }
        return true;
    }
}

// Redirect if not logged in
if ( ! function_exists('login_redirect'))
{
    function login_redirect(){
        $CI = get_instance();
        $user = $CI->session->userdata("user");
        if(empty($user)){
            redirect('auth/login');
        }
    }
}

//Get user info
if ( ! function_exists('user_info'))
{
    function user_info(){
        $CI = get_instance();
        $user = $CI->session->userdata("user");
        if(!empty($user)){
            return $user;
        }
        return false;
    }
}

// Show fields on survey page
if ( ! function_exists('render_field'))
{
    function render_field($field, $status){
        switch($field->field_type){
            case 'TEXT_FIELD':
                $text_field = '<div class="form-group">';
                $text_field .= '<label>'.$field->field_name.'</label>';
                if($status!='COMPLETED'){
                    $text_field .= '<input value="'.(isset($field->response[0]->response)?$field->response[0]->response:'').'" type="text" class="form-control" name="survey_fields['.$field->survey_id.']['.$field->id.']['.$field->field_type.']"></input>';
            }else{
                $text_field .= '<br/>'.$field->response[0]->response;
            }
            $text_field .= '</div>';
            return $text_field;
            break;
        
        case 'TEXT_AREA':
            $text_area = '<div class="form-group">';
            $text_area .= '<label>'.$field->field_name.'</label>';
            if($status!='COMPLETED'){
                $text_area .= '<textarea class="form-control" name="survey_fields['.$field->survey_id.']['.$field->id.']['.$field->field_type.']">'.(isset($field->response[0]->response)?$field->response[0]->response:'').'</textarea>';
        }else{
            $text_area .= '<br/>'.$field->response[0]->response;
        }
        $text_area .= '</div>';
        return $text_area;
        break;
    
    case 'DROPDOWN':
        $dropdown = '<div class="form-group">';
        $dropdown .= '<label>'.$field->field_name.'</label>';
        
        if($status!='COMPLETED'){
            $dropdown .= '<select class="form-control" name="survey_fields['.$field->survey_id.']['.$field->id.']['.$field->field_type.']">';
            $dropdown .= '<option class="form-control" value="">Select value</option>';
            foreach($field->meta as $field_item){
                $dropdown .= '<option '.(isset($field->response[0]->response)?(($field->response[0]->response==$field_item->id?'selected':'')):'').' class="form-control" value="'.$field_item->id.'">'.$field_item->value.'</option>';
        }
        $dropdown .= '</select>';
    }else{
        foreach($field->meta as $field_item){
            if(isset($field->response[0]->response)){
                if($field->response[0]->response==$field_item->id){
                    $dropdown .= '<br/>'.$field_item->label;
                }
            }
        }
    }
    $dropdown .= '</div>';
    return $dropdown;
    break;

case 'CHECKBOX':
    $checkboxes = '<div class="form-group">';
    $checkboxes .= '<label>'.$field->field_name.'</label>';
    $checkboxes .= '<div class="checkbox">';
    if(!empty($field->meta)){
        foreach($field->meta as $field_item){
            $checked = '';
            if(isset($field->response) && count($field->response)>0){
                foreach($field->response as $res){
                    if($res->response==$field_item->id){
                        $checked = 'checked';
                }
            }
        }
        if($status!='COMPLETED'){
            $checkboxes .= '<label>';
            $checkboxes .= '<input '.$checked.' type="checkbox" name="survey_fields['.$field->survey_id.']['.$field->id.']['.$field->field_type.'][]" value="'.$field_item->id.'"/>'.$field_item->label;
            $checkboxes .= '</label>&nbsp;&nbsp;';
        }else{
            if($checked=='checked'){
                $checkboxes .= '<span class="clearfix">'.$field_item->label."</span>";
            }
        }
        
    }
}
$checkboxes .= '</div></div>';
return $checkboxes;
break;

case 'RADIO_BUTTON':
    $radios = '<div class="form-group">';
    $radios .= '<label>'.$field->field_name.'</label>';
    $radios .= '<div class="radio">';
    if(!empty($field->meta)){
        foreach($field->meta as $field_item){
            if($status!='COMPLETED'){
                $radios .= '<label>';
                $radios .= '<input '.(isset($field->response[0]->response)?(($field->response[0]->response==$field_item->id?'checked':'')):'').' type="radio" name="survey_fields['.$field->survey_id.']['.$field->id.']['.$field->field_type.']" value="'.$field_item->id.'"/>'.$field_item->label;
                $radios .= '</label>&nbsp;&nbsp;';
        }else{
            if(isset($field->response[0]->response)){
                if($field->response[0]->response==$field_item->id){
                    $radios .= $field_item->label;
                }
            }
        }
    }
}
$radios .= '</div></div>';
return $radios;
break;
}
}

// Check if the survey is empty
if ( ! function_exists('has_empty'))
{
    function has_empty($survey){
        foreach($survey as $fields){
            
            if(!empty($fields)){
                
                foreach($fields as $field_key=>$field_value){
                    
                    foreach($field_value as $field_type=>$value){
                        
                        if(empty($value) || $value==''){
                            
                            return true;
                            
                        }
                        
                    }
                    
                }
                
            }
            
        }
        return false;
    }
}

// Check if the user is not empty
if ( ! function_exists('not_empty'))
{
    function not_empty($survey){
        foreach($survey as $fields){
            
            if(!empty($fields)){
                
                foreach($fields as $field_key=>$field_value){
                    
                    foreach($field_value as $field_type=>$value){
                        
                        if(!empty($value) && $value!=''){
                            
                            return true;
                            
                        }
                        
                    }
                    
                }
                
            }
            
        }
        return false;
    }
}

}