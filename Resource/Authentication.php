<?php

namespace Resource;

use Resource\Sessions;

class Authentication
{
    public function guest()
    {
        # code...
        $session = new Sessions();
    }

    public static function isAuth()
    {
        # code...
        $session = new Sessions();
        if ($session->verifyInsideSessions()) {
            return true;
        } else {
            return false;
        }
    }

    public function logout()
    {
        # code...
        $session = new Sessions();
        $session->destructSessions();
        echo "<script>
            window.location.href='" . __URL__ . "';
        </script>";
    }

    public function isAdmin(array $permition )
    {
        # code...
        $session = new Sessions();
        $session->verifyAdminPermition($permition);
    }

    public static function permition(array $permition )
    {
        # code...
        $session = new Sessions();
        if ($session->verifyPermition($permition)) {
            return true;
        } else {
            return false;
        }
    }
}
