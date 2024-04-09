<?php
    /**
    *   Logout page
    *   @param session
    *   @return none
    */
    session_start();
    session_unset();
    session_destroy();
    header("Location: main.php");
    exit;
?>