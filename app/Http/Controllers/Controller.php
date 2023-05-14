<?php

namespace App\Http\Controllers;

use App\Helpers\Apputil;
use App\Models\Movie;
use App\Repositories\BaseRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Central method to process movie filters from request
     *
     * @param BaseRepository $repository
     * @param Request $request
     * 
     * @return array search query array
     */
    public function setMoviesFilters(BaseRepository &$repository, Request $request) : array
    {
        $limit = $request->input('limit') ?? 20;
        $limit = (int) $limit;
        $sortby = $request->input('sortby') ?? 'popularity';
        $sortdir = $request->input('sortdir') ?? (($sortby == 'title') ? 'asc' : "desc");

        $repository->setOrders([$sortby, $sortdir]);
        $repository->setPerPage($limit);
        $repository->setColumns((new Movie)->getFillable());

        // get search query from request normalize it to array
        $searchQueryArray = Apputil::queryStringToArray($request->input('search', ''));        

        return $searchQueryArray;
    }
}
