<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Excel Storage
    |--------------------------------------------------------------------------
    |
    | In here you can specify the storage disk for your excel exports.
    | By default we'll use the local disk.
    |
    */

    'storage' => [
        'disk' => 'local',
    ],

    /*
    |--------------------------------------------------------------------------
    | Excel Temporary Path
    |--------------------------------------------------------------------------
    |
    | Here you may configure the temporary path for storing intermediate files
    | generated during the export process. This path is used by the
    | `store` and `storeAs` methods of the `Excel` class.
    |
    */

    'temporary_path' => storage_path('app/excel'),

];
