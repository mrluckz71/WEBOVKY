<?php
    /**
    *  Error page
    * @param none
    * @return none
    */
?>
<!DOCTYPE html> 
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>FACR.IS</title>
    <link rel="stylesheet" href="styles/styles.css" media="all">
    <link rel="stylesheet"  href="styles/print.css" media="print">
    <link rel="icon" type="image/png" href="img/logo.png">
</head>
<body>
<?php
    include 'includes/header.php';
    echo '<h1>Něco se nepovedlo</h1>';
    echo '<p>Chyba</p>';
    echo '<a class="odkaz-login" href="main.php">Zpět na hlavní stránku</a>';
?>
</body>
</html>

