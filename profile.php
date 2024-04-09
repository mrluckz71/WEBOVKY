<?php
    /**
    *   Profile page
    *   FOR ADMIN: delete all users and articles
    *   @param string $email, $name, $surname file $photo
    *   @return string $email, $name, $surname file $photo
    *   @throws none
    */
    session_start();
    if(isset($_SESSION['user_id'])){
        $email = $_SESSION['user_email'];
        $name = $_SESSION['user_name'];
        $surname = $_SESSION['user_surname'];
        $photo = $_SESSION['user_photo'];
    } else {
        header('Location: main.php');
    }
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>is.facr</title>
    <link rel="stylesheet" type="text/css" href="styles/styles.css" media="all">
    <link rel="stylesheet"  href="styles/print.css" media="print">
    <link rel="icon" type="image/png" href="img/logo.png">
</head>
    <body>
        <h1>Profil</h1>
        <p>Profilovka: </p><img src="<?php echo $photo; ?>" alt="Profilovka" width="100" height="120">
        <p>Jmeno: <?php echo $name; ?></p>
        <p>Prijmeni: <?php echo $surname; ?></p>
        <p>Email: <?php echo $email; ?></p>
        <a class="odkaz-login" href="main.php">Zpet na hlavni stranku</a>
        <a class="odkaz-login" href="logout.php">Odhlásit se</a>
        <?php
            if($_SESSION['user_id'] ==  '65984a8258e3e' ) {
                echo '<a class="odkaz-login" href="delete_all.php">Smazat všechny uživatele</a>';
                echo '<a class="odkaz-login" href="delete_all_articles.php">Smazat všechny články</a>';
            }
        ?>
    </body>
</html>