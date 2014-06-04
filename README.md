BridgeBB
===========

Allows phpBB3 to use the Laravel Auth driver to create/authenticate accounts.

###Installation:

####Add to your composer.json
```
"require": {
    "webcode/phpbb-bridge": "dev-master"
}
```

####Run composer update
```
$ composer update
```

####Register the BridgeBB Service Provider by adding it to your project's providers array in app.php
```
'providers' => array(
    'Webcode\BridgeBB\BridgeBBServiceProvider'
);
```

####Create a secret api key in config/webcode/bridgebb/api.php
```
'bridgebb-apikey' => 'secretkey'
```

####Update the column names used for the Laravel Auth driver config/webcode/bridgebb/auth.php
```
'username-column' => 'username',
'password-column' => 'password'
```

####Copy all files in the phpbb_root directory to your phpBB install
####Login to the phpBB admin panel and set bridgebb as the authentication module

Now all logins will be checked against the Laravel Auth driver and duplicated in the phpBB database.