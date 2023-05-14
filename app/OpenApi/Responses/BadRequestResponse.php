<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class BadRequestResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::badRequest()->description(__('Malformed input. Please check the paramters you are sending.'));
    }
}
