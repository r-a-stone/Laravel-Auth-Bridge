<?php

namespace Webcode\BridgeBB;

class Topic extends \Eloquent {

    protected $connection = 'phpbbDB';
    protected $table = 'topics';
    protected $primaryKey = 'topic_id';
    public $timestamps = false;

    public function getUser() {
        return $this->belongsTo('\Webcode\BridgeBB\User', 'topic_poster');
    }

    public function updatePosterUsername($userID, $username) {
        $this->topic_first_poster_name = $username;
        if ($this->topic_last_poster_id == $userID) {
            $this->topic_last_poster_name = $username;
        }
        $this->save();
    }
}
