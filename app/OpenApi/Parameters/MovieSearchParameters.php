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

            Parameter::query()
                ->name('sortby')
                ->description('Sort movies by popularity, title, genre ..etc')
                ->required(false)
                ->schema(Schema::string()->default("popularity")),
            Parameter::query()
                ->name('sortdir')
                ->description('Sort movies by asc or desc')
                ->required(false)
                ->schema(Schema::string()->default("asc when title,description. desc otherwise")),
        ];
    }
}
