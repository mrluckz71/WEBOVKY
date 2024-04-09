<?php
    /**
    *  Article detail page
    *   @param str $id id of the article
    *   @return none

    */
    include 'func/_article_database_func.php';
    include 'func/_article_render.php';
    session_start();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Clanky</title>
    <link rel="stylesheet" type="text/css" href="styles/styles.css" media="all">
    <link rel="stylesheet"  href="styles/print.css" media="print">
    <link rel="icon" type="image/png" href="img/logo.png">
</head>
<body>
<?php 
    include 'includes/header.php';
    include 'includes/nav.php';
?>
<div class="content">

    <?php
        // render the article detail
        detailArticle($_GET['id'])
    ?>
</div>
</body>
</html>