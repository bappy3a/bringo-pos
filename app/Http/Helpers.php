<?php

use App\Models\Business;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

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
//highlights the selected navigation on admin panel
if (!function_exists('areActiveRoutes')) {
    function areActiveRoutes(array $routes, $output = "active")
    {
        if (in_array(Route::currentRouteName(), $routes)) {
            return $output;
        }
        return null;
    }
}
//highlights the selected navigation on admin panel
if (!function_exists('areActiveRoutesRequest')) {
    function areActiveRoutesRequest(array $routes, $output = "subdrop active")
    {
        foreach ($routes as $route) {
            if (Request::is($route) == $route)  return $output;
        }
        return null;
    }
}

if (!function_exists('get_business')) {
    function get_business($key, $default = null)
    {
        $business = Cache::remember('settings', 86400, function () {
            $business_id = auth()->user()->business_id;
            return Business::find($business_id);
        });

        $value = $business ? $business->{$key} : null;

        return $value ?? $default;
    }
}
