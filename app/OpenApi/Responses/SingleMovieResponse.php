<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\MovieSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class SingleMovieResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()->description(__('Successful response'))
                ->content(
                    MediaType::json()->schema(
                        MovieSchema::ref()
                    )
                );
    }
}
