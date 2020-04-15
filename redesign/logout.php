<?php

    // Logout code from https://www.php.net/session_destroy with slight alterations

    require("db_connection.php");
    require("session.php");

    //Start the session in order to logout
    session_start();

    //Unset all session variables
    $_SESSION = array();

    //Delete session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    //Destroy the session
    session_destroy();

    //Redirect
    header("Location: index.php");