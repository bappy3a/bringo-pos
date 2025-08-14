<?php

if (!function_exists('json_file_to_collect')) {
    function json_file_to_collect($timezonePath)    
    {
        $timezonesArray = json_decode(file_get_contents($timezonePath), true);
        return collect($timezonesArray);
    }
}
// return auth full name
if (!function_exists('auth_username')) {
    function auth_username()    
    {
        $auth = auth()->user();
        return $auth->first_name .' '.$auth->last_name;
    }
}