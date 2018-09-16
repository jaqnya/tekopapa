<?php
class SessionControl {

    public static function start_session($user_id, $user_name, $token, $company_id, $company_name) {
        if (session_id() == '') {
            session_start();
        }

        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $user_name;
        $_SESSION['token'] = $token;
        $_SESSION['company_id'] = $company_id;
        $_SESSION['company_name'] = $company_name;
    }

    public static function close_session() {
        if (session_id() == '') {
            session_start();
        }

        if (isset($_SESSION['user_id'])) {
            unset($_SESSION['user_id']);
        }

        if (isset($_SESSION['user_name'])) {
            unset($_SESSION['user_name']);
        }

        if (isset($_SESSION['token'])) {
            unset($_SESSION['token']);
        }

        if (isset($_SESSION['company_id'])) {
            unset($_SESSION['company_id']);
        }

        if (isset($_SESSION['company_name'])) {
            unset($_SESSION['company_name']);
        }

        session_destroy();
    }

    public static function session_started() {
        if (session_id() == '') {
            session_start();
        }

        if (isset($_SESSION['user_id']) && isset($_SESSION['user_name']) && isset($_SESSION['token'])) {
            return true;
        } else {
            return false;
        }
    }

}
?>