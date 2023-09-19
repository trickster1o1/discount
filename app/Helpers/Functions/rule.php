<?php

// Auth
if(!function_exists('password_rules')){
    function password_rules(){
        return 'required|min:8|confirmed';
    }
}

if(!function_exists('password_confirmation_rules')){
    function password_confirmation_rules(){
        return 'required|min:8';
    }
}
// End of Auth

if(!function_exists('status_rules')){
    function status_rules(){
        return 'in:active,inactive,deleted';
    }
}
