<?php
    /**
    *   Delete an article from the database
    *   @param str $id
    *   @return none
    */
    include 'func/_article_database_func.php';
    include 'func/_article_render.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $article = getArticle($id);

        // no article was found with the given id
        if (!$article) {
            header('Location: error.php');
        }

        // delete the article from the database
        deleteArticle($id);

        // redirect to the list page
        header('Location: main.php?status=deleted');
    } else {
        header('Location: error.php');
    }
?>