<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Collection::macro('transpose', function () {
            $items = array_map(function (...$items) {
                return $items;
            }, ...$this->values());
            return new static($items);
        });
        Validator::extend('properties_filled', function ($attribute, $value, $parameters, $validator) {
        $validatedProperty = $parameters[0];
        $minimumOccurrence = $parameters[1];

        if (is_array($value)) {
            $validElementCount = 0;
            $valueCount = count($value);
            for ($i = 0; $i < $valueCount; ++$i) {
                if ($value[$i][$validatedProperty] !== '') {
                    ++$validElementCount;
                }
            }
        } else {
            return false;
        }

        return $validElementCount >= $minimumOccurrence;
    });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
