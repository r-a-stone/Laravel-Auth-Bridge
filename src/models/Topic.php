<?php

namespace Webcode\PhpBBBridge\Models;

use Webcode\PhpBBBridge\Libraries\WebcodeException;

class Topic extends \Eloquent {

    protected $connection = 'phpbbDB';
    protected $table;
    protected $primaryKey = 'topic_id';
    public $timestamps = false;

    public function __construct() {
        $this->table = \Config::get('phpbbbridge::database.phpbbtables.topics_table');
        parent::__construct();
    }

    public function getUser() {
        return $this->belongsTo('Webcode\PhpBBBridge\Models\User', 'topic_poster');
    }

}
