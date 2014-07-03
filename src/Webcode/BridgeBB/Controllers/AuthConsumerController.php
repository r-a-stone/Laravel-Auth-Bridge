<?php

namespace Webcode\Bridgebb\Controllers;

use Exception;
use Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;

class AuthConsumer extends Controller {

    public function __construct() {
        parent::__construct();
        $methodEnabled = Config::get('bridgebb::auth.external-api.enabled');
        if (!$methodEnabled) {
            
        }
    }

//Recieves login form data
    public function postValidate() {
        try {
            $methodEnabled = Config::get('bridgebb::auth.external-api.enabled');
            if ($methodEnabled) {
                $username = Input::get('username');
                $password = Input::get('password');
                $userdata = $this->_doExternalValidation($username, $password);
                
            } else {
                throw new Exception('BridgeBB External API Consumer is not enabled.');
            }
        } catch (Exception $ex) {
            return array('response' => 'error', 'data' => $ex->getMessage());
        }
    }

    private static function _doExternalValidation($username, $password) {
        $providerURL = Config::get('bridgebb::auth.external-api.provider-url');
        $queryString = http_build_query(array(
            'un' => $username,
            'pw' => $password
        ));
        $response = json_decode(file_get_contents($providerURL . '?' . $queryString));
        if ($response->response === 'success') {
            return $response->data;
        } else {
            throw new Exception($response->data);
        }
    }

    public function missingMethod($parameters = array()) {
        return array('response' => 'info', 'data' => 'Not Implemented');
    }

}
