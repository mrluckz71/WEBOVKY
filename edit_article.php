<?php
    /**
    *   Edit article page
    *   @param str $id
    *   @return none
    */
    require_once 'func/_article_database_func.php';
    require_once 'func/_article_render.php';
    
    // get the id from the url
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        
        $user = getArticle($id);
        $id = $user['id'];
        
        $title = htmlspecialchars($user['title']);
        $content = htmlspecialchars($user['content']);
    } else {
        // redirect to the list page
        header('Location: main.php');
    }
    
    // process the form if the submit button was clicked
    if (isset($_POST['edit'])) {
        // check if the user is logged in
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
        } else {
            header('Location: login.php');
        }
        // get the data from the form
        if(isset($_POST['id']) && !empty($_POST['id'])){
            $id = $_POST['id'];
            if(isset($_POST['title']) && !empty($_POST['title'])){
                $title = $_POST['title'];
                if(isset($_POST['content']) && !empty($_POST['content'])){
                    $content = $_POST['content'];

                    // update the aticle in the database
                    editArticle($id, $title, $content);
                    //redirect to the list page
                    header('Location: main.php?status=edited');
                } else {
                    $error = 'Nevložil jste text!';
                    $wrong_title = $_POST['title'];
                }
            } else {
                $error = 'Nevložil jste nadpis!';
                $wrong_content = $_POST['content'];
            }
        } else {
            die('CSRF attack detected!');
        }
    }


?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>is.facr.edit</title>
    <link rel="stylesheet" type="text/css" href="styles/styles.css" media="all">
    <link rel="stylesheet"  href="styles/print.css" media="print">
    <link rel="icon" type="image/png" href="img/logo.png"></head>
</head>
<body>
        <?php include 'includes/header.php'; ?>
        <?php include 'includes/nav.php'; ?>
        <section class="sect-reg">
            <br>
            <div class="edit"> 
            <h2>Upravit</h2>
            <br>
            <form action="" method="post">
                  
                    <label for="id"><input type="hidden" name="id" id="id" value="<?php echo $id; ?>"></label>
                    <div>
                        <p>
                            <?php
                                if(isset($error)){
                                    echo '<p class="error">' . $error . '</p>';
                                }
                            ?>
                        </p>
                    <div>
                    <br>
                        <label for="title">Název</label>
                        <input type="text" id="title" name="title" value="<?php echo $title; ?>">
                    </div>
                    <br>
                    <div>
                        <label for="content">Obsah</label>
                        <br>
                        <textarea id="content" cols="40" rows="10" name="content"><?php echo $content; ?></textarea>
                    </div>
                    <br>
                    <div>
                        <button type="submit" name="edit">Upravit</button>
                    </div>
                </div>
            </form>
        </section>
        <?php include 'includes/footer.php'; ?>
    </div>
</body>
</html>