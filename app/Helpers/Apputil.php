<?php

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Apputil class
 * 
 * serves as utility class for the application
 * 
 */
class Apputil {
    /**
     * Convert query string to array
     * Format: key:value|key:value
     *
     * @param [type] $query
     * @return array query array
     */
    public static function queryStringToArray(string $query) : array {

        $query = trim($query);

        if (empty($query)) {
            return [];
        }

        $queryArray = explode("|", $query);
        $queryArray = array_map(function ($item) {
            return trim($item);
        }, $queryArray);

        //remove empty items
        $queryArray = array_filter($queryArray, function ($item) {
            return $item !== "";
        });
        
        $queryArray = array_map(function ($item) {
            $args = explode(":", $item);
            return $args;
        }, $queryArray);

        return $queryArray;
    }
    
    /**
     * Create json error response
     *
     * @param string $message
     * @param integer $code
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public static function createJsonResponseError($message, $code = 400) : \Illuminate\Http\JsonResponse {
        return self::createJsonResponseMessage($message, $code);
    }

    /**
     * Create json success response
     *
     * @param string $message
     * @param integer $code
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public static function createJsonResponseSuccess($message, $code = 200) : \Illuminate\Http\JsonResponse {
        return self::createJsonResponseMessage($message, $code);
    }

    /**
     * Central method for creating json response
     *
     * @param [type] $message
     * @param integer $code
     * @return \Illuminate\Http\JsonResponse
     */
    public static function createJsonResponseMessage($message, $code = 200) : \Illuminate\Http\JsonResponse {
        return response()->json([
            'message' => $message,
        ], $code);
    }

    /**
     * Filter out pagination results
     * to remove unnecessary fields for api response     * 
     */    
    public static function getFilteredPagination(LengthAwarePaginator $movies) : array {
        $movies = $movies->toArray();

        $movies = array(
            'data'=>$movies['data'],
            'current_page'=>$movies['current_page'],
            'total'=>$movies['total'],
            'per_page'=>$movies['per_page'],
        );

        return $movies;
    }
}