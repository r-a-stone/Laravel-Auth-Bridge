<?php

namespace Webcode\BridgePhpBB\Models;

use Webcode\BridgePhpBB\Libraries\WebcodeException;

class Topic extends \Eloquent {

    protected $connection = 'phpbbDB';
    protected $table;
    protected $primaryKey = 'topic_id';
    public $timestamps = false;

    public function __construct() {
        $this->table = \Config::get('phpbb-bridge::database.phpbbtables.topics_table');
        parent::__construct();
    }

    public function getUser() {
        return $this->belongsTo('Webcode\BridgePhpBB\Models\User', 'topic_poster');
    }

}
