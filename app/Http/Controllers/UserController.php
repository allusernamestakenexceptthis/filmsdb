<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

use App\Repositories\UserRepository;
use App\Helpers\Apputil;
use App\Models\Movie;
use App\OpenApi\Parameters\MovieSearchParameters;
use App\OpenApi\Responses\BadRequestResponse;
use App\OpenApi\Responses\MovieResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\SuccessResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use Illuminate\Http\Request;

/**
 * User controller for api endpoints
 */
#[OpenApi\PathItem]
class UserController extends Controller
{
    protected UserRepository $userRepository;

    /**
     * Dependency injection of UserRepository
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Called when user unauthorized or not logged in
     *
     * @return JsonResponse
     */
    public function userUnauthenticated() : JsonResponse
    {
        return Apputil::createJsonResponseError(__('You are not authorized to access this resource'), 401);
    }


    /**
     * Get favorite movies
     *
     * Get list of favorite movies for logged in user
     *
     */
    #[OpenApi\Operation(tags: ['user'], security: "BearerTokenSecurityScheme")]
    #[OpenApi\Parameters(factory: MovieSearchParameters::class)]
    #[OpenApi\Response(MovieResponse::class, statusCode: 200, description: 'List of favorite movies')]
    #[OpenApi\Response(UnauthorizedResponse::class, statusCode: 401, description: 'Unauthorized')]
    public function getFavoriteMovies(Request $request) : JsonResponse
    {
        $user =  auth('sanctum')->user();
        if (!$user) {
            return $this->userUnauthenticated();
        }

        $searchQueryArray = $this->setMoviesFilters($this->userRepository, $request);

        try {
            $favorites = $this->userRepository->getFavoriteMovies($user->id, $searchQueryArray) ?? null;

            if (!$favorites) {
                return Apputil::createJsonResponseError(__('Movie not found'), 404);
            }

            $favorites = Apputil::getFilteredPagination($favorites);

        } catch (\Exception $e) {
            return Apputil::createJsonResponseError($e->getMessage(), 400);
        }

        return response()->json($favorites);
    }

    /**
     * Add movie to favorites
     *
     * Add movie to favorites for logged in user
     * 
     * @param int $movieId the movie id
     *
     */
    #[OpenApi\Operation(tags: ['user'], security: "BearerTokenSecurityScheme")]
    #[OpenApi\Response(SuccessResponse::class, statusCode: 200, description: 'Movie added to favorites')]
    #[OpenApi\Response(BadRequestResponse::class, statusCode: 400, description: 'Bad request, Movie id is missing')]
    #[OpenApi\Response(NotFoundResponse::class, statusCode: 404, description: 'Movie not found')]
    #[OpenApi\Response(UnauthorizedResponse::class, statusCode: 401, description: 'Unauthorized')]
    public function addFavoriteMovie(int $movieId) : JsonResponse
    {
        $user =  auth('sanctum')->user();
        if (!$user) {
            return $this->userUnauthenticated();
        }

        if (!$movieId) {
            return Apputil::createJsonResponseError(__('Bad reqest'), 400);
        }

        try {
            $this->userRepository->addFavoriteMovie($user->id, $movieId);
        } catch (\Exception $e) {
            return Apputil::createJsonResponseError(__("Already in your favorite"), 400);
        }
        return Apputil::createJsonResponseSuccess(__('Movie added to favorites'));
    }

    /**
     * Remove movie from favorites
     *
     * Remove movie from favorites for logged in user
     * 
     * @param int $movieId the movie id
     *
     */
    #[OpenApi\Operation(tags: ['user'], security: "BearerTokenSecurityScheme")]
    #[OpenApi\Response(SuccessResponse::class, statusCode: 200, description: 'Movie removed from favorites')]
    #[OpenApi\Response(BadRequestResponse::class, statusCode: 400, description: 'Bad request, Movie id is missing')]
    #[OpenApi\Response(NotFoundResponse::class, statusCode: 404, description: 'Movie not in your favorite')]
    #[OpenApi\Response(UnauthorizedResponse::class, statusCode: 401, description: 'Unauthorized')]
    public function removeFavoriteMovie(int $movieId) : JsonResponse
    {
        $user =  auth('sanctum')->user();
        if (!$user) {
            return $this->userUnauthenticated();
        }

        if (!$movieId) {
            return Apputil::createJsonResponseError(__('Bad reqest'), 400);
        }
        
        $res = $this->userRepository->removeFavoriteMovie($user->id, $movieId);
        if (!$res) {
            return Apputil::createJsonResponseError(__("Movie not in your favorite"), 404);
        }
        return Apputil::createJsonResponseSuccess( __('Movie removed from favorites'));
    }
}
