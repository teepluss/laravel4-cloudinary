<?php namespace Teepluss\Cloudinary\Facades;

use Illuminate\Support\Facades\Facade;

class Cloudy extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'cloudinary'; }

}