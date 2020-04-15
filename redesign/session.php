<?php

// Used https://www.tutorialspoint.com/php/php_mysql_login.htm for PHP sessions help

    session_start();

    if (!isset($_SESSION["username"])) {

        header("Location: login.php?message=error");
        die;

    } else {

        $current_user = $_SESSION["username"];

    }
