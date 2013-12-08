<?php

namespace Webcode\PhpBBBridge\Models;

use Webcode\PhpBBBridge\Libraries\WebcodeException;

class Group extends \Eloquent {

    protected $connection = 'phpbbDB';
    protected $table;
    protected $primaryKey = 'group_id';
    protected $userGroupPivotTable;
    public $timestamps = false;

    public function __construct() {
        $this->table = \Config::get('phpbbbridge::database.phpbbtables.group_table');
        $this->userGroupPivotTable = \Config::get('phpbbbridge::database.phpbbtables.user_group_pivot_table');
        parent::__construct();
    }

    public function getUsers() {
        return $this->belongsToMany('Webcode\PhpBBBridge\Models\User', $this->userGroupPivotTable);
    }

}
