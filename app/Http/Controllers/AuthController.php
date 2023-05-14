<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\Apputil;
use App\OpenApi\Parameters\TokenParameters;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

use App\Repositories\UserRepository;

/**
 * Auth controller for api endpoints
 */
#[OpenApi\PathItem]
class AuthController extends Controller
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
     * Login to get bearer token
     * 
     * This endpoint is used to get a token for a user to gain access to 
     * Restricted endpoints such as favorites
     * 
     * @param string $email
     * @param string $password
     * @param string $device_name (optional)
     * 
     * @return string $token
     */ 
    #[OpenApi\Operation(tags: ['user', 'admin'])]
    #[OpenApi\Parameters(factory: TokenParameters::class)]
    public function getToken(Request $request) {
        $json = $request->json()->all();
        if ($json) {
            $request->request->replace($json);
        }
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'optional',
        ]);
        
        $user = $this->userRepository->getUserByEmail($request->email);    
    
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return Apputil::createJsonResponseError(__('Invalid credentials'), 401);
        }
        
        /**
         * Grants either:
         * User access or Admin access
         */
        $abilities = ['user_access'];
        if ($user->role === 'admin') {
            $abilities[] = 'admin_access';
        }
    
        $device_name = $request->device_name ?? 'access_token';
    
        return Apputil::createJsonResponseSuccess($user->createToken($device_name, $abilities)->plainTextToken, 200);
    }

}
