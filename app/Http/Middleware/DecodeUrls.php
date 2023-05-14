<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TransformsRequest;

class DecodeUrls extends TransformsRequest
{
    
    protected function transform($key, $value)
    {
        return filter_var($value, FILTER_VALIDATE_URL) ? urldecode($value) : $value;
    }
}
