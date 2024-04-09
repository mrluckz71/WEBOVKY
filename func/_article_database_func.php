<?php
    /**
    *   Database function for articles
    *  @param arr $db Database of articles
    *  @return list of articles
    *
    */
    
    // DATABASE FILE
    $DB_FILE = 'data/article_database.json';
    $file = file_get_contents($DB_FILE);

    if(!$file) {
        header('error.php');
    }

    $db = json_decode($file, true);

    if(!$db) {
        header('error.php');
    }
    /**
    *   List all articles
    *   @param none
    *   @return array
    */
    // LIST ARTICLES
    function listArticles(){
        global $db;
        foreach($db as $article){
            echo '<div class="article">';
            echo '<h2>' . $article['nadpis'] . '</h2>';
            echo '<p>' . $article['clanek'] . '</p>';
            echo '<p>' . $article['email'] . '</p>';
            echo '</div>';
        }
        return $db;
    }

    /**
    *   Save an article to the database
    *   @param none
    *   @return none
    *   @throws none
    */
    // SAVE DATABASE
    function saveDatabase(){
        global $db;
        global $DB_FILE;
        
        $json = json_encode($db);
        if (!$json) {
            header('Location: error.php');
        }

        $put = @file_put_contents($DB_FILE, $json);
        if (!$put) {
            header('Location: error.php');
        } 
    }
    /**
    *   Add a new article to the database
    *   @param str $user_id, $title, $email, $content, $date
    *   @return none
    *   @throws none
    */
    // ADD ARTICLE
    function addArticle($user_id, $title, $email, $content, $date) {
        global $db;
        // create a new article
        $article = [
            'id' => uniqid(),
            'user_id' => $user_id,
            'title' => $title,
            'email' => $email,
            'content' => $content,
            'date' => $date
            
        ];
        $db[] = $article;
        saveDatabase();
        header('Location: main.php?status=added');
        }
        /**
        *   Get an article from the database
        *   @param str $id
        *   @return arr|boo
        */
        // GET ARTICLE
        function getArticle($id){
            global $db;
            foreach($db as $article) {
                if ($article['id'] == $id) {
                    return $article;
                }
            }
            return false;
        }
        /**
        *   Get all articles from the database
        *   @param none
        *   @return arr
        */
        // GET ARTICLES
        function getArticles(){
            global $db;
            return $db;
        }
        /**
        *   Edit an article in the database
        *   @param str $id, $title, $content
        *   @return boo
        */
        // EDIT ARTICLE
        function editArticle($id, $title, $content){
            global $db;
            foreach($db as &$article) {
                if ($article['id'] == $id) {
                    $article['title'] = $title;
                    $article['content'] = $content;
                    saveDatabase();
                    return true;
                }
            }
            return false;
        }
        /**
        *   Delete an article from the database
        *   @param str $id
        *   @return boo
        */
        // delete article
        function deleteArticle($id){
            global $db;
            foreach($db as $index => $article) {
                if ($article['id'] == $id) {
                    unset($db[$index]);
                    saveDatabase();
                    return true;
                    header('Location: success.php?status=deleted');
                }
            }
            return false;
        }
        /**
        *   Delete all articles from the database
        *   @param none
        *   @return none
        */
        // DELETE ALL ARTICLES
        function deleteAllArticles(){
            global $db;
            $db = [];
            saveDatabase();
        }
        /**
        *   List all users articles
        *   @param none
        *   @return arr
        */
        // LIST MY ARTICLES
        function listMyArticles(){
            global $db;
            global $article;
            foreach($db as $article){
                if ($article['user_id'] == $_SESSION['user_id']) {
                    echo '<div class="article">';
                    echo '<h2>' . $article['title'] . '</h2>';
                    echo '<p>' . $article['content'] . '</p>';
                    echo '<p>' . $article['email'] . '</p>';
                    echo '<a href="edit_article.php?id=' . $article['id'] . '">Upravit</a>';
                    echo '<a href="delete.php?id=' . $article['id'] . '">Smazat</a>';
                    echo '</div>';
                }
            }
        }
?>