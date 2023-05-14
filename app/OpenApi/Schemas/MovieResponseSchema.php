<?php

namespace App\OpenApi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AllOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Not;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class MovieResponseSchema extends SchemaFactory implements Reusable
{
    /**
     * Response schema for movie search
     * 
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('MovieResponseScheme')
            ->properties(
                Schema::array('data')->items(MovieSchema::ref()),
                Schema::integer('current_page')->default(1),
                Schema::integer('total')->default(10),
                Schema::integer('per_page')->default(20),
            );
    }
}
