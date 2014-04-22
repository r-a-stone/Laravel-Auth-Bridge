<?php

return array(
    'connections' => array(
        'phpbbDB' => array(
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => '',
            'username' => '',
            'password' => '',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => 'phpbb_',
        ),
    ),
    'user-model' => array(
        'model-name' => 'User',
        'username-column' => 'username',
        'password-column' => 'password'
    )
);
