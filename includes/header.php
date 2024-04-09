<?php
    // Header of the page
    /**
    *  Header of the page
    *   @param none
    */
?>
<div class="obrazek-odkaz">
    <span>
            <a href="main.php" id="odkaz">
                <img src="img/logo.png" alt="Toto je logo.">
            </a>
    </span>
    <?php
            if (isset($_SESSION['user_id'])) {
                echo '<div>';
                echo '<h3>You are logged in as ' . $_SESSION['user_name'] . '</h3>';
                echo '<a href="logout.php" class="odkaz-login">Odhlásit se</a>';
                echo '</div>';
            }
        ?>
</div>
