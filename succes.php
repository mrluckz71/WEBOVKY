<?php
    /*
    *   Success page
    */
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>V pořádku</title>
    <link rel="stylesheet" type="text/css" href="styles/styles.css" media="all">
    <link rel="stylesheet"  href="styles/print.css" media="print">
    <link rel="icon" type="image/png" href="img/logo.png"></head>
</head>
<body>
    <div class="page" id="list">
        <?php include 'includes/header.php'; ?>
        
        <section>
            
            <?php
                echo '<h2>Vse probehlo v poradku</h2>';
                echo '<button><a href="main.php">Zpet na hlavni stranku</a></button>';
            ?>

        </section>
        <?php include 'includes/footer.php'; ?>
    </div>