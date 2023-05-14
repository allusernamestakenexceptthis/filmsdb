<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

use App\Helpers\Apputil;
use App\OpenApi\Parameters\MovieSearchParameters;
use App\OpenApi\Responses\MovieResponse;
use App\OpenApi\Responses\SingleMovieResponse;
use App\Repositories\MovieRepository;

/**
 * Movie controller for api endpoints
 */
#[OpenApi\PathItem]
class MovieController extends Controller
{

    protected MovieRepository $movieRepository;

    public function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }
    
    /**
     * Get movies
     * 
     * Get list of movies filtered by search query
     * 
     * @param Request $request the http request
     * 
     * @return JsonResponse Movies
     */
     #[OpenApi\Operation]
     #[OpenApi\Parameters(factory: MovieSearchParameters::class)]
     #[OpenApi\Response(factory: MovieResponse::class)]
    public function getMovies(Request $request) : JsonResponse
    {

        $searchQueryArray = $this->setMoviesFilters($this->movieRepository, $request);

        try {
            $movies = $this->movieRepository->findBy(
                $searchQueryArray
            ) ?? null;

            if (!$movies) {
                return Apputil::createJsonResponseError(__('Movie not found'), 404);
            }

            $movies = Apputil::getFilteredPagination($movies);

        } catch (\Exception $e) {
            return Apputil::createJsonResponseError($e->getMessage(), 400);
        }
        return response()->json($movies);
    }

        
    /**
     * Get movie details by id
     * 
     * @param integer $id
     * 
     * @return JsonResponse Movie Or 404
     */
    #[OpenApi\Operation]
    #[OpenApi\Response(SingleMovieResponse::class, statusCode: 200, description: 'Movie details')]
    public function getMovie(int $id) : JsonResponse
    {

        $this->movieRepository->setColumns($this->movieRepository->getFillable());
        $movie = $this->movieRepository->find($id);

        if (!$movie) {
            return Apputil::createJsonResponseError(__('Movie not found'), 404);
        }
        return response()->json($movie);
    }
}
