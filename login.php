<?php
    /**
    *   Přihlašovací stránka
    *   @param none
    *   @return none
    *  @error none
    */
    session_start();
    require_once 'func/user_database_func.php';
    if(isset($_POST['submit'])) {
        if(isset($_POST['email']) && !empty($_POST['email'])){
            $email = ($_POST['email']);
            $user = getUser($email);
            if($user) {
                if(isset($_POST['password']) && !empty($_POST['password'])){
                    $password = ($_POST['password']);
                    if(password_verify($password, $user['password'])) {
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['user_name'] = htmlspecialchars($user['name']);
                        $_SESSION['user_email'] = htmlspecialchars($user['email']);
                        $_SESSION['user_surname'] = htmlspecialchars($user['surname']);
                        $_SESSION['user_photo'] = $user['photo'];
                        if($_SESSION['user_id']) {
                            header('Location: main.php');
                        } else {
                            header('Location: error.php');
                        }
                    } else {
                        $error = 'Neplatné heslo!';
                        $wrong_mail = $email;    
                    }} else { 
                        $error = 'Heslo nebylo zadáno!';
                        $wrong_mail = $email;
                }} else {
                    $error = 'Email neexistuje!';
            }} else {
                $error = 'Email nebyl zadán!';
            }
        }
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>is.facr.login</title>
    <link rel="stylesheet" type="text/css" href="styles/styles.css" media="all">
    <link rel="stylesheet"  href="styles/print.css" media="print">
    <link rel="icon" type="image/png" href="img/logo.png">
</head>
<body>
<?php 
    include 'includes/header.php';
?>
<section class="sect-log">
    <div class="form-box-log">
            <form action="login.php" method="POST">
                <h2>Přihlášení</h2>
                <div class="inputbox-log">
                    <label for="email">Email: </label>
                    <input type="email" id='email' value="<?php global $wrong_mail; if(isset($wrong_mail)) {echo htmlspecialchars($wrong_mail);} else {echo '';}?>" name="email" placeholder="Email*">
                </div>
                <div class="inputbox-log">
                    <label for="password">Heslo: </label>
                    <input type="password" id='password' name="password" placeholder="Heslo*">
                </div>
                <div>
                    <?php if(isset($error))
                        echo '<p class="error">'.$error.'</p>';
                    ?>
                </div>
                <button class="login-log" name="submit" id="submit">Přihlásit se</button>
                <div class="register-log">
                    <div><p>Ještě nemáte účet?</p><a class="login-reg" href="register.php">Zaregistrovat se</a></div>
                </div>
            </form>
    </div>
</section>
</body>
</html>