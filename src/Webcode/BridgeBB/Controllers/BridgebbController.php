<?php

namespace Webcode\Bridgebb\Controllers;

use Exception;
use Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class BridgebbController extends Controller {

    public function getLogin($apikey, $username, $password) {
        try {
            if ($apikey === Config::get('bridgebb::api.bridgebb-apikey')) {
                return $this->_validateCredentials($username, $password);
            } else {
                throw new Exception('Invalid API Key');
            }
        } catch (Exception $ex) {
            return array('response' => 'error', 'data' => $ex->getMessage());
        }
    }

    private function _validateCredentials($username, $password) {
        if (Auth::validate(array(
                    Config::get('bridgebb::auth.username-column') => $username,
                    Config::get('bridgebb::auth.password-column') => $password
                ))) {
            return array('response' => 'success');
        } else {
            throw new Exception('Invalid username or password');
        }
    }

    public function missingMethod($parameters = array()) {
        return array('response' => 'info', 'data' => 'Not Implemented');
    }

}
