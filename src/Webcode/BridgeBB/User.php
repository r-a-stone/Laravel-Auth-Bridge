<?php

namespace Webcode\BridgeBB;

use Webcode\BridgeBB\BridgeBBException;

class User extends \Eloquent {

    const PHPBB_USER_TYPE_NORMAL = 0;
    const PHPBB_USER_TYPE_INACTIVE = 1;
    const PHPBB_USER_TYPE_IGNORE = 2;
    const PHPBB_USER_TYPE_FOUNDER = 3;

    protected $connection = 'phpbbDB';
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $hidden = array('user_password');
    public $timestamps = false;

    /**
     * Creates phpbb user.
     *
     * @param string $username, string $password, string $email
     * @return void
     */
    public function register($username, $password, $email, $type = self::PHPBB_USER_TYPE_NORMAL, $primaryGroupID = 2, $color = "000") {
        if (!isset($username))
            throw new BridgeBBException("username was expected but none was provided.");

        if (!isset($password))
            throw new BridgeBBException("password was expected but none was provided.");

        if (!isset($email))
            throw new BridgeBBException("email was expected but none was provided.");

        $this->username = trim($username);
        $this->user_password = $password;
        $this->user_email = trim(strtolower($email));
        $this->user_type = $type;
        $this->group_id = $primaryGroupID;
        $this->user_colour = $color;
        $this->user_permissions = NULL;
        $this->_createUser();
    }

    /**
     * Sets phpbb groups user belongs to.
     *
     * @param int[] $groupIDs
     * @return void
     */
    public function setGroups($groupIDs = array()) {
        $phpBBGroupIDs = array();
        foreach ($groupIDs as $groupID) {
            $phpBBGroupIDs[$groupID] = array(
                'group_leader' => false,
                'user_pending' => false
            );
        }
        $this->getGroups()->sync($phpBBGroupIDs);
        $this->_flushPermissions();
    }

    /**
     * Gets all phpbb groups user is a member of.
     *
     * @return \Webcode\BridgeBB\Models\Group
     */
    public function getGroups() {
        return $this->belongsToMany('\Webcode\BridgeBB\Group', 'user_group');
    }

    /**
     * Gets all phpbb topics by user.
     *
     * @return \Webcode\BridgeBB\Models\Topic
     */
    public function getTopics() {
        return $this->hasMany('\Webcode\BridgeBB\Topic', 'topic_poster');
    }

    /**
     * Changes phpbb user username.
     *
     * @param int $username
     * @return void
     */
    public function updateUsername($username) {
        if (!isset($username))
            throw new BridgeBBException("username was expected but none was provided.");

        $this->username = $username;
        $this->username_clean = self::_cleanUsername($this->username);
        foreach ($this->getTopics()->get() as $oTopic) {
            $oTopic->updatePosterUsername($this->user_id, $this->username);
        }
        $this->save();
    }

    /**
     * Changes phpbb user password.
     *
     * @param string $password
     * @return void
     */
    public function updatePassword($password) {
        $this->user_password = hash('md5', $password);
        $this->save();
    }

    /**
     * Removes user from all user groups then places user into "registered users" group
     *
     * @return void
     */
    public function removeAllGroups() {
        $this->setGroups(array(2));
        $this->setPrimaryGroup(2);
    }

    /**
     * Changes phpbb user primary group and flushes permissions.
     *
     * @param int $groupID
     * @return void
     */
    public function setPrimaryGroup($groupID) {
        $isInGroup = $this->getGroups()->where(DB::getTablePrefix() . 'groups.group_id', $groupID)->count();
        if ($isInGroup) {
            //If user is already in group just set primary
            $oGroup = $this->getGroups()->where(DB::getTablePrefix() . 'groups.group_id', $groupID)->first();
            $this->group_id = $groupID;
            $this->user_colour = $oGroup->group_colour;
        } else {
            //Add user to group THEN set primary
            $groupIDs = $this->getGroups()->get(array(DB::getTablePrefix() . 'groups.group_id'))->toArray();
            $groupIDs[] = $groupID;
            $this->setGroups($groupIDs);
            $oGroup = $this->getGroups()->where(DB::getTablePrefix() . 'groups.group_id', $groupID)->first();
            $this->group_id = $groupID;
            $this->user_colour = $oGroup->group_colour;
        }
        $this->save();
        $this->_flushPermissions();
    }

    /**
     * Saves phpbb user to database
     *
     * @return void
     */
    private function _createUser() {
        $this->username_clean = trim(strtolower($this->username));
        $this->user_ip = $_SERVER['REMOTE_ADDR'];
        $this->user_password = hash('md5', $this->user_password);
        $this->user_regdate = time();
        $this->user_lastvisit = time();
        $this->save();
        $this->setPrimaryGroup($this->group_id);
    }

    private static function _cleanUsername($username) {
        return trim(strtolower($username));
    }

    /**
     * Refresh phpbb permissions
     *
     * @return void
     */
    private function _flushPermissions() {
        $this->user_permissions = NULL;
        $this->save();
    }

}
