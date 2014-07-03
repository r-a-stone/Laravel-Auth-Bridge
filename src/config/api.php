<?php

return array(
    'bridgebb-apikey' => 'secretkey',
    'interal-api' => array(
        'enabled' => TRUE,
        'user-model' => array(
            'username-column' => 'username',
            'password-column' => 'password'
        )
    ),
    'external-api' => array(
        'enabled' => TRUE,
        'provider-url' => '',
        'form-inputs' => array(
            'username-input' => 'username',
            'password-input' => 'password'
        )
    )
);
