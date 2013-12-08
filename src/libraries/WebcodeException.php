<?php

namespace Webcode\PhpBBBridge\Libraries;

class WebcodeException extends \Exception {

    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
        if(\Config::get("phpbbbridge:reportDataToDeveloper")) {
            //TODO
        }
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}
