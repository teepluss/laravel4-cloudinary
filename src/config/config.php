<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Cloudinary API configuration
    |--------------------------------------------------------------------------
    |
    | Before using Cloudinary you need to register and get some detail
    | to fill in below, please visit cloudinary.com.
    |
    */

    'cloudName'  => 'jquerytips',
    'baseUrl'    => 'http://res.cloudinary.com/jquerytips',
    'secureUrl'  => 'https://cloudinary-a.akamaihd.net/jquerytips',
    'apiBaseUrl' => 'http://api.cloudinary.com/v1_1/jquerytips',
    'apiKey'     => '599564323378641',
    'apiSecret'  => 'lq4EVzvmROZM8baAx6j2nggyZjY',

    /*
    |--------------------------------------------------------------------------
    | Default image scaling to show.
    |--------------------------------------------------------------------------
    |
    | If you not pass options parameter to Cloudy::show the default
    | will be replaced.
    |
    */

    'scaling'    => array(
        'format' => 'png',
        'with'   => 150,
        'height' => 150,
        'crop'   => 'fit',
        'effect' => null
    )

);