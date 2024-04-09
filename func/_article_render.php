<?php
    // Path: func/_article_render.php
    /**
     *   Render the list of articles in a table
     *   Render the pagination
     *   Render the status message
     *   Render the detail of an article
     *   
     *   @param none
     *   @return none
     */
    // constants
    /**
    *   Number of items per page
    */
    define('ITEMS_PER_PAGE', 5);
    /**
    *   Path to the database file 
    */
    $DB_FILE = 'data/article_database.json';
    $file = file_get_contents($DB_FILE);

    if(!$file) {
        header('error.php');
        exit();
    }

    $db = json_decode($file, true);

    if(!$db) {
        header('error.php');
        
    }
    /**
    *   Get the articles from the database
    *   @param none
    *   @return array
    */
    // list users
    function listArticle() {
        global $db;
        return $db;
    }
    /**
    *   Slice the array of articles to get the articles for the current page
    *   @param int $offset, $limit
    *   @return array
    */
    function listArticlesPaginated($offset, $limit) {
        global $db;
        // calculate the end index to prevent showing more users than the array contains
        $end = min($limit, count($db));
        $articles = array_slice($db, $offset, $end);
        return $articles;
    }
    /**
    *   Sort the array of articles by date in descending order
    *   @param array $a, $b
    *   @return int
    */
    // Sort data by date in ascending order
    function date_sort($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    }
    /**
    *   Render the list of articles in a table
    *   @param none
    *   @return none
    */
    // functions
    function renderArticles(){
        global $db;
        // sort the array by date
        usort($db, 'date_sort');
        // simple list of articles no pagination
        // get the page number from the query string and validate it
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, [
            'options' => [
                'default' => 1,
                'min_range' => 1,
                'max_range' => ceil(count($db) / ITEMS_PER_PAGE)
            ]
        ]);

        // calculate the offset for the slice
        $offset = ($page - 1) * ITEMS_PER_PAGE;
        // slice the array of articles
        $articles = listArticlesPaginated($offset, ITEMS_PER_PAGE);


        // render the list of articles
        if (!$articles) {
            // render the message if there are no articles
            echo '<p class="message">Žádné články k zobrazení.</p>';
            return;
        } else {
            // render the list of articles
            foreach($articles as $article){
                $id = $article['id'];
                $title = htmlspecialchars($article['title'], ENT_QUOTES);
                $email = htmlspecialchars($article['email'], ENT_QUOTES);
                $date = date('d.m H:i', strtotime($article['date']));

                echo '<tr>';
                echo '<td>' . $title . '</td>';
                echo '<td>' . $email . '</td>';
                echo '<td>' . $date . '</td>';
                if(isset($_SESSION['user_id'])){    
                    if ($_SESSION['user_id'] == '65984a8258e3e') {
                        echo '<td><a class="odkaz-login" href="edit_article.php?id=' . $id . '">Upravit</a></td>';
                        echo '<td><a class="odkaz-login" href="delete.php?id=' . $id . '">Smazat</a></td>';
                }} else {
                    echo '<td></td>';
                    echo '<td></td>';
                }
                echo '<td><a class="odkaz-login" href="article_detail.php?id=' . $id . '">Detail</a></td>';
                echo '</tr>';
            }
        }
        }

   /**
 * Render articles for the logged-in user
 * @param none
 * @return none
 */
function renderMyArticles() {
    global $db;

    // Filter articles that belong to the logged-in user
    $userArticles = array_filter($db, function ($article) {
        return $article['user_id'] == $_SESSION['user_id'];
    });

    // Sort user articles by date in descending order
    usort($userArticles, 'date_sort');

    // get the page number from the query string and validate it
    $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, [
        'options' => [
            'default' => 1,
            'min_range' => 1,
            'max_range' => ceil(count($userArticles) / ITEMS_PER_PAGE)
        ]
    ]);

    // calculate the offset for the slice
    $offset = ($page - 1) * ITEMS_PER_PAGE;

    // slice the array of user articles
    $articles = array_slice($userArticles, $offset, ITEMS_PER_PAGE);

    // render the list of articles
    if (!$articles) {
        // render the message if there are no articles
        echo '<p class="message">Žádné články k zobrazení.</p>';
        return;
    } else {
        // render the list of articles
        foreach($articles as $article){
            if ($article['user_id'] == $_SESSION['user_id']){
                // render the list of articles if the user is logged in and the article belongs to the user
                $id = $article['id'];
                $title = htmlspecialchars($article['title']);
                $email = htmlspecialchars($article['email']);
                $date = date('d.m.Y H:i', strtotime($article['date']));

                echo '<tr>';
                echo '<td>' . $title . '</td>';
                echo '<td>' . $email . '</td>';
                echo '<td>' . $date . '</td>';
                if(isset($_SESSION['user_id'])){    
                    if ($_SESSION['user_id'] == $article['user_id']) {
                        echo '<td><a class="odkaz-login" href="edit_article.php?id=' . $id . '">Upravit</a></td>';
                        echo '<td><a class="odkaz-login" href="delete.php?id=' . $id . '">Smazat</a></td>';
                }} else {
                    echo '<td></td>';
                    echo '<td></td>';
                }
                echo '<td><a class="odkaz-login" href="article_detail.php?id=' . $id . '">Detail</a></td>';
                echo '</tr>';
            }
        }
    }
}

        /**
 * Render the pagination with previous and next page links as well as page number links
 * @param string $pageQueryParam
 * @return none
 */
function renderPagination($pageQueryParam = 'page') {
    global $db;

    $currentPage = filter_input(INPUT_GET, $pageQueryParam, FILTER_VALIDATE_INT, [
        'options' => [
            'default' => 1,
            'min_range' => 1,
            'max_range' => ceil(count($db) / ITEMS_PER_PAGE)
        ]
    ]);

    // If there is only one page, don't render pagination
    if (count($db) <= ITEMS_PER_PAGE) {
        return;
    }

    echo '<div class="pagination">';

    // Render "Previous" link
    if ($currentPage > 1) {
        echo '<a href="' . generatePageUrl(1, $pageQueryParam) . '">&lt;&lt;</a>';
        echo '<a href="' . generatePageUrl($currentPage - 1, $pageQueryParam) . '">&lt;</a>';
    }

    // Render page number links
    for ($p = 1; $p <= ceil(count($db) / ITEMS_PER_PAGE); $p++) {
        $currentPageClass = ($p == $currentPage) ? 'active' : '';
        echo '<a class="' . $currentPageClass . '" href="' . generatePageUrl($p, $pageQueryParam) . '">' . $p . '</a>';
    }

    // Render "Next" link
    if ($currentPage < ceil(count($db) / ITEMS_PER_PAGE)) {
        echo '<a href="' . generatePageUrl($currentPage + 1, $pageQueryParam) . '">&gt;</a>';
    }
    // Render last page link
    if ($currentPage < ceil(count($db) / ITEMS_PER_PAGE)) {
        echo '<a href="' . generatePageUrl(ceil(count($db) / ITEMS_PER_PAGE), $pageQueryParam) . '">&gt;&gt;</a>';
    }

    echo '</div>';
}

/**
 * Render the pagination for user-specific articles
 * @param string $pageQueryParam
 * @return none
 */
function renderMyPagination($pageQueryParam = 'page') {
    global $db;

    $currentPage = filter_input(INPUT_GET, $pageQueryParam, FILTER_VALIDATE_INT, [
        'options' => [
            'default' => 1,
            'min_range' => 1,
            'max_range' => ceil(countUserArticles() / ITEMS_PER_PAGE)
        ]
    ]);

    // If there is only one page, don't render pagination
    if (countUserArticles() <= ITEMS_PER_PAGE) {
        return;
    }

    echo '<div class="pagination">';

    // Render "Previous" link
    if ($currentPage > 1) {
        echo '<a href="' . generateMyPageUrl(1, $pageQueryParam) . '">&lt;&lt;</a>';
        echo '<a href="' . generateMyPageUrl($currentPage - 1, $pageQueryParam) . '">&lt;</a>';
    }

    // Render page number links
    for ($p = max(1, $currentPage - 2); $p <= min(ceil(countUserArticles() / ITEMS_PER_PAGE), $currentPage + 2); $p++) {
        $currentPageClass = ($p == $currentPage) ? 'active' : '';
        echo '<a class="' . $currentPageClass . '" href="' . generateMyPageUrl($p, $pageQueryParam) . '">' . $p . '</a>';
    }

    // Render "Next" link
    if ($currentPage < ceil(countUserArticles() / ITEMS_PER_PAGE)) {
        echo '<a href="' . generateMyPageUrl($currentPage + 1, $pageQueryParam) . '">&gt;</a>';
    }

    // Render last page link
    if ($currentPage < ceil(countUserArticles() / ITEMS_PER_PAGE)) {
        echo '<a href="' . generateMyPageUrl(ceil(countUserArticles() / ITEMS_PER_PAGE), $pageQueryParam) . '">&gt;&gt;</a>';
    }

    echo '</div>';
}


/**
 * Generate the URL for the specified page number
 * @param int $pageNumber
 * @param string $pageQueryParam
 * @return string
 */
// Generate the URL for the specified page number
function generatePageUrl($pageNumber, $pageQueryParam = 'page') {
    $currentSort = isset($_GET['sort']) ? '&sort=' . $_GET['sort'] : '';
    return 'main.php?' . $pageQueryParam . '=' . $pageNumber . $currentSort;
}

/**
 * Generate the URL for the specified page number for user-specific articles
 * @param int $pageNumber
 * @param string $pageQueryParam
 * @return string
 */
function generateMyPageUrl($pageNumber, $pageQueryParam = 'page') {
    $currentSort = isset($_GET['sort']) ? '&sort=' . $_GET['sort'] : '';
    return 'my_article.php?' . $pageQueryParam . '=' . $pageNumber . $currentSort;
}

/**
 * Count articles for the logged-in user
 * @param none
 * @return int
 */
function countUserArticles() {
    global $db;

    // Filter articles that belong to the logged-in user
    $userArticles = array_filter($db, function ($article) {
        return $article['user_id'] == $_SESSION['user_id'];
    });

    return count($userArticles);
}

        /**
         *  Render the detail of an article
         * @param string $id
         * @return none
         * 
         */
        // detail of an article
        function detailArticle($id) {
            global $db;
        
            foreach ($db as $article) {
                if ($article['id'] == $id) {
                    // render the detail of the article
                    $title = htmlspecialchars($article['title']);
                    $content = htmlspecialchars($article['content']);
                    $date = date("d.m.Y H:i", strtotime($article['date']));
                    $author = htmlspecialchars($article['email']);
        
                    echo '<article class="article-details">';
                    echo '<h1>' . $title .'</h1>';
                    echo '<h4>' . $author . '</h4>';
                    echo '<h6>' . $date . '</h6>';
                    echo '<p>' . $content . '</p>';
        
                    if (isset($_SESSION['user_id']) &&
                        ($_SESSION['user_id'] == $article['user_id'] || $_SESSION['user_id'] == '65984a8258e3e')) {
                        echo '<div class="article-actions">';
                        echo '<a class="odkaz-login" href="edit_article.php?id=' . $id . '">Upravit</a>';
                        echo '<a class="odkaz-login" href="delete.php?id=' . $id . '">Smazat</a>';
                        echo '</div>';
                    }
        
                    echo '</article>';
                    return; // return after rendering the article details
                }
            }
        
            // render the message if the article was not found
            echo '<p class="message">Článek nebyl nalezen.</p>';
        }
?>