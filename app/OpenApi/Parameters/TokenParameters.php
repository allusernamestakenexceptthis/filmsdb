<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class TokenParameters extends ParametersFactory
{
    /**
     * Token parameters for login and getting bearer token
     * 
     * @return Parameter[]
     */
    public function build(): array
    {
        return [
            Parameter::query()
                ->name('email')
                ->description('Email address used for login')
                ->required(true)
                ->schema(Schema::string()),

            Parameter::query()
                ->name('password')
                ->description('Password used for login')
                ->required(true)
                ->schema(Schema::string()),
        ];
    }
}
