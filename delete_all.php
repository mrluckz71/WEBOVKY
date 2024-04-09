<?php
    /**
    *   Delete all users from the database
    *   @param none
    *   @return none
    */
    session_start();
    require_once 'func/user_database_func.php';
    // delete all articles from the database
    deleteAllUsers($_SESSION['user_id']);

    // redirect to the list page
    header('Location: profile.php?status=deleted');