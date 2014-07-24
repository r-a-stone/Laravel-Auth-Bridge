<?php

namespace Webcode\BridgeBB\Controllers;

use Exception;
use Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class BridgeBBController extends Controller {

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
        if (Config::get('bridgebb::api.internal-api.enabled')) {
            if (Auth::validate(array(
                        Config::get('bridgebb::api.internal-api.user-model.username-column') => $username,
                        Config::get('bridgebb::api.internal-api.user-model.password-column') => $password
                    ))) {
                //TODO: Return user account information like email
                return array('response' => 'success');
            } else {
                throw new Exception('Invalid username or password');
            }
        } else {
            throw new Exception('BridgeBB Internal auth API is disabled');
        }
    }

    public function missingMethod($parameters = array()) {
        return array(
            'response' => 'info',
            'data' => 'Not Implemented',
            'parameters' => $parameters);
    }

}
