<?php

Route::get('/bridgebb-api/auth/{apikey}/{username}/{password}', function($apikey, $username, $password) {
    global $app;
    $bridgeBBApiKey = $app['config']->get('bridgebb::bridgebb-api.apikey');
    $usernameColumn = $app['config']->get('bridgebb::database.user-model.username-column');
    $passwordColumn = $app['config']->get('bridgebb::database.user-model.password-column');
    if ($apikey == $app['config']->get('bridgebb::bridgebb-api.apikey')) {
        $oUser = $UserModel::where($username_col, $username)
                ->where($password_col, $password)
                ->first();
        return json_encode(array(
            'response' => 'success',
            'data' => $oUser
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
    $oUser = $UserModel::find($userID);
    $oUser->$phpBBIDColumn = $phpBBID;
});
