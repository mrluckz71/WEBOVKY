<?php
    /**
    *   Main page
    *  This page is the main page of the website. It shows all the articles.
    * If the user is logged in, he can add an article or see his articles.
    * If the user is not logged in, he can only see the articles.
    *
    *   @param arr $db Database of articles
    *   @return list of articles
    */
    require_once 'func/_article_database_func.php';
    require_once 'func/_article_render.php';

    session_start();

    
       
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <title>FACR.IS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles/styles.css" media="all">
    <link rel="stylesheet"  href="styles/print.css" media="print">
    <link rel="icon" type="image/png" href="img/logo.png">
</head>
<body>
    <?php 
        include 'includes/header.php';
    ?>
    <?php 
        include 'includes/nav.php';
    ?>
    <div class="sect-field-cla">
        <?php
            if(isset($_SESSION['user_id'])) {
                echo '<div class="my_art_button">';
                    echo '<a class="odkaz-login" href="add_article.php">Přidat článek</a>';
                    echo '<a class="odkaz-login" href="my_article.php">Moje články</a>';
                echo '</div>';
                }
        ?>
        
                <h2>Články</h2>
        <div>
        <table>
            <thead>
                <tr>
                    <th>Název</th>
                    <th>Autor</th>
                    <th>Datum</th>
                <?php
                if(isset($_SESSION['user_id'])){
                    if ($_SESSION['user_id'] == '65984a8258e3e') {
                        echo '<th>Upravit</th>';
                        echo '<th>Smazat</th>';
                }} else {
                    echo '<th></th>';
                    echo '<th></th>';
                }
                ?>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    renderArticles();
                ?>
            </tbody>
        </table>
        </div>
        <?php
            renderPagination();
        ?>


        
    </div>
        <?php 
            include 'includes/footer.php';
        ?>
</body>
</html>