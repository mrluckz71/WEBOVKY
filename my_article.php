<?php
    /**
    *   My articles page for displaying articles of the logged in user
    * 
    *  @param $artcles array|$page int
    *  @return list of articles
    */
    include 'func/_article_database_func.php';
    include 'func/_article_render.php';
    session_start();
    
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>FACR.IS</title>
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
    <div class="sect-field-my-cla">
            <h2>Moje Články</h2>
            <table>
            <thead>
                <tr>
                    <th>Nazev</th>
                    <th>Autor</th>
                    <th>Datum</th>
                <?php
                if(isset($_SESSION['user_id'])){
                    if ($_SESSION['user_id']) {
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
                    renderMyArticles();
                ?>
            </tbody>
        </table>
        </div>
        <?php
            renderMyPagination();
        ?>

</body>
</html>