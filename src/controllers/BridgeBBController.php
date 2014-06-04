<?php

namespace Webcode\Bridgebb;

use Controller;
use Illuminate\Support\Facades\Auth;

class BridgeBBController extends Controller {

    public function getLogin($apikey, $username, $password) {
        if ($apikey === Config::get('webcode\bridgebb::api.bridgebb-apikey')) {
            if (Auth::validate(array(
                        Config::get('webcode\bridgebb::auth.username-column') => $username,
                        Config::get('webcode\bridgebb::auth.password-column') => $password
                    ))) {
                return array('response' => 'success');
            } else {
                return array('response' => 'error');
            }
        } else {
            return array('response' => 'error');
        }
    }

}
