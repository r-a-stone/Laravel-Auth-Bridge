BridgeBB
===========

Allows phpBB3 to use the Laravel Auth driver to create/authenticate accounts.

###Installation:

####Add to your composer.json
```
"require": {
    "webcode/phpbb-bridge": "1.0.*@dev"
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
'bridgebb-apikey' => 'yoursecretapikey'
```

####Update the column names used for the Laravel Auth driver config/webcode/bridgebb/api.php
```
'username-column' => 'user_login',
'password-column' => 'user_password'
```

####Copy all files in the phpbb_root directory to your phpBB install

####Edit the file located at {PHPBB-ROOT}/includes/auth/auth_bridgebb.php
```
define('LARAVEL_URL', 'http://www.example.com/'); //your laravel application's url
define('BRIDGEBB_API_KEY', "yoursecretapikey"); //the same key you created earlier
```

####Login to the phpBB admin panel and set bridgebb as the authentication module

Now all logins will be checked against the Laravel Auth driver.
If the user is validated against the Laravel Auth driver phpBB will check if the 
account exists in its own database. If the user is validated but the account does 
not exist in the phpBB database the login information will be duplicated in the database.

This should leave you in a better situation than bridgeBB has left people in the past.

If bridgeBB breaks and I am too busy to fix it in a timely manner you have the option 
to switch to the default phpBB auth driver as all the logins will already exist.

I welcome any and all pull requests!
