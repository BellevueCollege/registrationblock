<?php
return [

    'path' => env('SIMPLESAMLPHP_PATH', '/var/www/nonpub/simplesaml/lib/_autoload.php'),
    'sp' => env('SIMPLESAML_SP', 'bc-adfs-sp'),
    'username' => env('SIMPLESAML_ATTR_USERNAME', 'uid'),

];