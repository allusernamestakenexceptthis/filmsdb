<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class UnauthorizedResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::unauthorized()->description(__('You are not authorized to access this resource.'));
    }
}
