<?php

namespace Webcode\BridgePhpBB\Models;

use Webcode\BridgePhpBB\Libraries\WebcodeException;

class Group extends \Eloquent {

    protected $connection = 'phpbbDB';
    protected $table;
    protected $primaryKey = 'group_id';
    protected $userGroupPivotTable;
    public $timestamps = false;

    public function __construct() {
        $this->table = \Config::get('phpbb-bridge::database.phpbbtables.group_table');
        $this->userGroupPivotTable = \Config::get('phpbb-bridge::database.phpbbtables.user_group_pivot_table');
        parent::__construct();
    }

    public function getUsers() {
        return $this->belongsToMany('Webcode\BridgePhpBB\Models\User', $this->userGroupPivotTable);
    }

}
