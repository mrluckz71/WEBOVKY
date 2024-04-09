<?php
    /**
    *   Add article page
    *   @param titulek, obsah
    *   @return none
    *   @throws none
    */
    require_once 'func/_article_database_func.php';
    session_start();
    if(!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    // process the form if the submit button was clicked
    if (isset($_SESSION['user_id'])) {
        // get the data from the form
        if(isset($_POST['submit'])){
            // check if the title is set
                if(isset($_POST['title']) && !empty($_POST['title'])){
                    // check if the content is set
                    if(isset($_POST['content']) && !empty($_POST['content'])){
                        // get the data from the form
                        $title = ($_POST['title']);
                        $content = ($_POST['content']);
                        $user_id = ($_SESSION['user_id']);
                        $email = ($_SESSION['user_email']);
                        $date = date('d.m.Y H:i:s', time() + 3600);

                        // add the article to the database
                        addArticle($user_id, $title, $email, $content, $date);
                        //redirect to the list page
                        header('Location: main.php?status=added');
                    
                    } else{
                        $error = 'Nevložil jste text!';
                        $wrong_title = $_POST['title'];
            }} else {
                $error = 'Nevložil jste nadpis!';
                $wrong_content = $_POST['content'];
            }}}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Přidání článku</title>
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
        <div>
            <form action="add_article.php" method="post">
                <fieldset class="sect-field-reg">
                    <legend>Clanek</legend>
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                    <br>
                    <?php
                        if(isset($error)){
                            echo '<p class="error">' . $error . '</p>';
                        }
                    ?>
                    <label for="nadpis">Nadpis</label>
                    <input class="inputbox-log" type="text" id="nadpis" name="title" placeholder="Nadpis" value="<?php global $wrong_title; if (isset($wrong_title)) {echo htmlspecialchars($wrong_title);} else echo ''?>">
                    <br>
                    <label for="content">Sem vlozte text</label>
                    <textarea class="box-clanek" id="content" name="content" placeholder="Sem vložte svůj text"><?php global $wrong_content; if (isset($wrong_content)) {echo htmlspecialchars($wrong_content);} else echo ''?></textarea>
                    <br>
                    <input class="button" type="submit" name="submit" value="Odeslat">
                </fieldset>
            </form>
        </div>
</body>
</html>