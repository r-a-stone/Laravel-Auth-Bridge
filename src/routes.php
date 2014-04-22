<?php

Route::get('/bridgebb-api/auth/{apikey}/{username}/{password}', function($apikey, $username, $password) {
    global $app;

    $bridgeBBApiKey = $app['config']->get('bridgebb::api.apikey');
    $clsUserModel = $app['config']->get('bridgebb::database.user-model.model-name');
    $usernameColumn = $app['config']->get('bridgebb::database.user-model.username-column');
    $passwordColumn = $app['config']->get('bridgebb::database.user-model.password-column');

    if ($apikey == $bridgeBBApiKey) {
        $oUser = $clsUserModel::where($usernameColumn, $username)
                ->where($passwordColumn, $password)
                ->first();
        return json_encode(array(
            'response' => 'success',
            'data' => array(
                'id' => $oUser->$primaryKey,
                'username' => $oUser->$usernameColumn,
                'email' => ''
            )
        ));
    } else {
        return json_encode(array(
            'response' => 'error',
            'message' => 'Invalid API Key'
        ));
    }
});
Route::post('/bridgebb-api/register/{apikey}/{userID}/{phpBBID}', function($apikey, $userID, $phpBBID) {
    global $app;

    $bridgeBBApiKey = $app['config']->get('bridgebb::api.apikey');
    $clsUserModel = $app['config']->get('bridgebb::database.user-model.model-name');
    $phpBBIDColumn = $app['config']->get('bridgebb::database.user-model.phpbb-id-column');

    if ($apikey == $bridgeBBApiKey) {
        $oUser = $clsUserModel::find($userID);
        $oUser->$phpBBIDColumn = $phpBBID;
        $oUser->save();
        return json_encode(array(
            'response' => 'success',
            'data' => array(
                'id' => $oUser->$primaryKey,
                'username' => $oUser->$usernameColumn,
                'email' => ''
            )
        ));
    } else {
        return json_encode(array(
            'response' => 'error',
            'message' => 'Invalid API Key'
        ));
    }
});
