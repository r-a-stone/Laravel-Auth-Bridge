<?php

include(__DIR__ . '/includes/auth/bridgebb/BridgebbSQL.php');

class bridgebb {

    private $username;
    private $password;

    public function response() {
        $this->_input($_REQUEST);
        return $this->_validate();
    }

    private function _input(array $rawData) {
        $this->username = (string) trim($rawData['username']);
        $this->password = (string) trim($rawData['password']);
    }

    private function _validate() {
        
    }

}

$oBridgeBB = new BridgeBB();
echo $oBridgeBB->response();
