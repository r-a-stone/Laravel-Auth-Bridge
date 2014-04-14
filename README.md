BridgeBB
===========

Allows the laravel 4 developer to edit/create phpbb3 forum accounts and their group memberships.

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
####Add to app.php
```
'providers' => array(
    'Webcode\BridgeBB\BridgeBBServiceProvider'
);
```
####Publish BridgeBB config
```
php artisan config:publish webcode/bridgebb
```

###Usage:

####Registration:
```
try {
    $user = new Webcode\BridgeBB\User();
    $user->register("testuser", "testpassword", "testuser@example.com");
    $phpBBUserID = $user->user_id;
}
catch(Webcode\BridgeBB\BridgeBBException $ex) {
    //Handle exceptions
}
```

####Update User:
```
try {
    $user = Webcode\BridgeBB\User::find(1);
    $user->updateUsername("newtestusername");
    $user->setGroups(array(1,7,9,11));
    $user->setPrimaryGroup(7);
    $user->updatePassword("mynewpassword");
}
catch(Webcode\BridgeBB\BridgeBBException $ex) {
    //Handle exceptions
}
```
