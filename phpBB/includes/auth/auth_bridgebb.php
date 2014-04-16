<?php

if (!defined('IN_PHPBB')) {
    exit;
}
define(LARAVEL_URL, 'http://www.example.com/');

function init_bridgebb() {
    //TODO: Setup this auth service
}

/*
  function autologin_bridgebb() {
  //TODO
  }
 */

function login_bridgebb($username, $password) {
    global $db;
    if (!$password) {
        return array(
            'status' => LOGIN_ERROR_PASSWORD,
            'error_msg' => 'NO_PASSWORD_SUPPLIED',
            'user_row' => array('user_id' => ANONYMOUS),
        );
    }

    if (!$username) {
        return array(
            'status' => LOGIN_ERROR_USERNAME,
            'error_msg' => 'LOGIN_ERROR_USERNAME',
            'user_row' => array('user_id' => ANONYMOUS),
        );
    }

    $result = fopen(LARAVEL_URL . 'bridgebb-auth-api/' . $username . '/' . $password);

    if ($result <> false) {
        //TODO: Check bridgebb response
        if (1 == 1) {
            return array(
                'status' => LOGIN_ERROR_USERNAME,
                'error_msg' => 'LOGIN_ERROR_USERNAME',
                'user_row' => array('user_id' => ANONYMOUS),
            );
        } else {
            $sql = 'SELECT user_id, username, user_password, user_passchg, user_email, user_type
            FROM ' . USERS_TABLE . "
            WHERE username = '" . $db->sql_escape($username) . "'";
            $result = $db->sql_query($sql);
            $row = $db->sql_fetchrow($result);
            $db->sql_freeresult($result);

            if ($row) {
                // User inactive
                if ($row['user_type'] == USER_INACTIVE || $row['user_type'] == USER_IGNORE) {
                    return array(
                        'status' => LOGIN_ERROR_ACTIVE,
                        'error_msg' => 'ACTIVE_ERROR',
                        'user_row' => $row,
                    );
                } else {
                    // Successful login
                    return array(
                        'status' => LOGIN_SUCCESS,
                        'error_msg' => false,
                        'user_row' => $row,
                    );
                }
            } else {
                // this is the user's first login so create an empty profile
                return array(
                    'status' => LOGIN_SUCCESS_CREATE_PROFILE,
                    'error_msg' => false,
                    'user_row' => user_row_bridgebb($username, sha1($password)),
                );
            }
        }
    } else {
        return array(
            'status' => LOGIN_ERROR_EXTERNAL_AUTH,
            'error_msg' => 'LOGIN_ERROR_EXTERNAL_AUTH',
            'user_row' => array('user_id' => ANONYMOUS),
        );
    }
}

function user_row_bridgebb($username, $password) {
    global $db, $config, $user;
    // first retrieve default group id
    $sql = 'SELECT group_id
        FROM ' . GROUPS_TABLE . "
        WHERE group_name = '" . $db->sql_escape('REGISTERED') . "'
            AND group_type = " . GROUP_SPECIAL;
    $result = $db->sql_query($sql);
    $row = $db->sql_fetchrow($result);
    $db->sql_freeresult($result);

    if (!$row) {
        trigger_error('NO_GROUP');
    }

    // generate user account data
    return array(
        'username' => $username,
        'user_password' => phpbb_hash($password),
        'user_email' => '', //TODO: Set this from the laravel users later
        'group_id' => (int) $row['group_id'],
        'user_type' => USER_NORMAL,
        'user_ip' => $user->ip,
    );
}

/*
function logout_bridgebb() {
    //TODO
}

function validate_session_bridgebb() {
    //TODO
}
 * 
 */
