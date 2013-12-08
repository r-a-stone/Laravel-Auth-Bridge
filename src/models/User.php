<?php

namespace Webcode\PhpBBBridge\Models;

use Webcode\PhpBBBridge\Libraries\WebcodeException;

class User extends \Eloquent {

    protected $connection = 'phpbbDB';
    protected $table;
    protected $primaryKey = 'user_id';
    protected $hidden = array('user_password');
    protected $groupTable;
    protected $userGroupPivotTable;
    
    public $timestamps = false;

    public function __construct() {
        $this->table = \Config::get('phpbbbridge::database.phpbbtables.user_table');
        $this->groupTable = \Config::get('phpbbbridge::database.phpbbtables.group_table');
        $this->userGroupPivotTable = \Config::get('phpbbbridge::database.phpbbtables.user_group_pivot_table');
        parent::__construct();
    }

    public function getGroups() {
        return $this->belongsToMany('Webcode\PhpBBBridge\Models\Group', $this->userGroupPivotTable);
    }

    public function getTopics() {
        return $this->hasMany('Webcode\PhpBBBridge\Models\Topic', 'topic_poster');
    }

//PhpBB Specific functions
    public function register() {
        if (!isset($this->username)) {
            throw new WebcodeException("Username required.");
        } else {
            $this->username_clean = strtolower($this->username);
            if (empty($this->username_clean)) {
                throw new WebcodeException("Invalid username.");
            }
        }
        if (!isset($this->user_password)) {
            throw new WebcodeException();
        }
        if (!isset($this->user_email)) {
            throw new WebcodeException();
        } else {
            $this->user_email = strtolower($this->user_email);
        }
        if (!isset($this->user_type)) {
            $this->user_type = 3;
        }
        if (!isset($this->group_id)) {
            $this->group_id = 2;
        }
        if (!isset($this->user_colour)) {
            $this->user_colour = "000";
        }
        if (!isset($this->user_ip)) {
            $this->user_ip = $_SERVER['REMOTE_ADDR'];
        }
        $this->user_password = hash('md5', $this->user_password);
        $this->user_regdate = time();
        $this->user_lastvisit = time();
        $this->save();
    }

    public function setGroups($groupIDs = array()) {
        $phpBBGroupIDs = array();
        foreach ($groupIDs as $groupID) {
            $phpBBGroupIDs[$groupID] = array(
                'group_leader' => false,
                'user_pending' => false
            );
        }
        $this->getGroups()->sync($phpBBGroupIDs);
    }

    public function setUsername($username) {
        if (!isset($username)) {
            throw new WebcodeException("Username required.");
        } else {
            $this->username = $username;
            $this->username_clean = strtolower($this->username);
            if (empty($this->username_clean)) {
                throw new WebcodeException("Invalid username.");
            }
            foreach($this->getTopics()->get() as $oTopic) {
                $oTopic->topic_first_poster_name = $this->username;
                if($oTopic->topic_last_poster_id == $this->user_id) {
                    $oTopic->topic_last_poster_name = $this->username;
                }
                $oTopic->save();
            }
        }
        $this->save();
    }

    public function updatePassword($password) {
        $this->user_password = hash('md5', $password);
        $this->save();
    }

    public function removeAllGroups() {
        $this->setGroups(array(2));
        $this->setPrimaryGroup(2);
    }

    public function setPrimaryGroup($groupID) {
        $isInGroup = $this->getGroups()->where($this->groupTable . '.group_id', $groupID)->count();
        if ($isInGroup) {
            //If user is already in group just set primary
            $oGroup = $this->getGroups()->where($this->groupTable . '.group_id', $groupID)->first();
            $this->group_id = $groupID;
            $this->user_colour = $oGroup->group_colour;
        } else {
            //Add user to group THEN set primary
            $groupIDs = $this->getGroups()->get(array($this->groupTable . '.group_id'))->toArray();
            $groupIDs[] = $groupID;
            $this->setGroups($groupIDs);
            $oGroup = $this->getGroups()->where($this->groupTable . '.group_id', $groupID)->first();
            $this->group_id = $groupID;
            $this->user_colour = $oGroup->group_colour;
        }
        $this->user_permissions = "";
        $this->save();
    }

}
