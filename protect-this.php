<?php
    /* Your password */
    $password = 'PHPA';

    if (empty($_COOKIE['password']) || $_COOKIE['password'] !== $password) {
        // Password not set or incorrect. Send to login.php.
        header('Location: index.php');
        exit;
    }
?>