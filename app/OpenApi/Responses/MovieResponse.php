<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\MovieResponseSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class MovieResponse extends ResponseFactory implements Reusable
{
    public function build(): Response
    {
        return Response::ok()->description(__('Successful response'))
                ->content(
                    MediaType::json()->schema(
                        MovieResponseSchema::ref()
                    )
                );
    }
}
