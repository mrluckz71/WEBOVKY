<?php
    /**
    *   Delete all articles from the database
    *   @param none
    *   @return none
    */
    
    require_once 'func/_article_database_func.php';
    // delete all articles from the database
    deleteAllArticles();

    // redirect to the list page
    header('Location: profile.php?status=deleted');