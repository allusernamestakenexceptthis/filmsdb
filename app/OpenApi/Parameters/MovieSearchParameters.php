<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class MovieSearchParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [
            Parameter::query()
                ->name('search')
                ->description('The search query in this format genres:action,adventure,comedy|title:matrix')
                ->required(false)
                ->schema(Schema::string()),

            Parameter::query()
                ->name('limit')
                ->description('The number of items per page')
                ->required(false)
                ->schema(Schema::integer()->default(20)),

            Parameter::query()
                ->name('page')
                ->description('The page number')
                ->required(false)
                ->schema(Schema::integer()->default(1)),
        ];
    }
}
