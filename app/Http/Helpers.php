<?php

use App\Models\Business;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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
//highlights the selected navigation on admin panel
if (!function_exists('areActiveRoutesUrl')) {
    function areActiveRoutesUrl(array $urls, $output = "subdrop active")
    {
        foreach ($urls as $url) {
            if (Request::is($url) == $url)  return $output;
        }
        return null;
    }
}

//highlights the selected navigation on admin panel - excludes specific patterns
if (!function_exists('areActiveRoutesUrlExclude')) {
    function areActiveRoutesUrlExclude(array $urls, array $excludePatterns = [], $output = "subdrop active")
    {
        $currentPath = Request::path();
        
        // Check if current path matches any exclude patterns
        foreach ($excludePatterns as $excludePattern) {
            if (Request::is($excludePattern)) {
                return null;
            }
        }
        
        // Check if current path matches any include patterns
        foreach ($urls as $url) {
            if (Request::is($url)) {
                return $output;
            }
        }
        
        return null;
    }
}
//highlights the selected navigation on admin panel
if (! function_exists('isActiveUrl')) {
    function isActiveUrl(string $path, array $query = [], string $activeClass = 'subdrop active'): string
    {
        $request = request();
        if ($request->is(ltrim($path, '/'))) {
            foreach ($query as $key => $value) {
                if ($request->query($key) !== $value) {
                    return '';
                }
            }
            return $activeClass;
        }
        return '';
    }
}
//get business  data value
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

//product name to slug ganarate
if (!function_exists('slug_generator')) {
    function slug_generator($slug,$type=null)
    {
        $new_slug = Str::slug($slug);
        $originalSlug = $new_slug;
        $i = 1;
        while (Product::where('slug', $new_slug)->exists()) {
            $new_slug = $originalSlug . '-' . $i++;
        }
        return $new_slug;
    }
}

if (!function_exists('sku_generator')) {
    function sku_generator()
    {
        $sku = 'SKU-' . strtoupper(Str::random(8));
        
        while (Product::where('sku', $sku)->exists()) {
            $sku = 'SKU-' . strtoupper(Str::random(8));
        }
        
        return $sku;
    }
}