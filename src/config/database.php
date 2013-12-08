<?php

return array(
    'phpbbtables' => array(
        'user_table' => "users",
        'group_table' => "groups",
        'user_group_pivot_table' => "user_group",
        'topics_table' => 'topics'
    ),
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
    )
);
