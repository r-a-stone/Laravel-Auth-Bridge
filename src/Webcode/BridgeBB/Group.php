<?php

namespace Webcode\BridgeBB;

class Group extends \Eloquent {

    protected $connection = 'phpbbDB';
    protected $table = 'groups';
    protected $primaryKey = 'group_id';
    public $timestamps = false;

    public function getUsers() {
        return $this->belongsToMany('\Webcode\BridgeBB\User', 'user_group');
    }

}
