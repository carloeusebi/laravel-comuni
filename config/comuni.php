<?php

return [
    'provider' => 'comuni-ita',

    'cache' => [

        // the prefix for the cache key
        'prefix' => 'comuni-',

        // the number of days the responses should be cached for
        'ttl' => 60,

        // the number of days after which the cache becomes stale
        'stale' => 30,
    ],
];
