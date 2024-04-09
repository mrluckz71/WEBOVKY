<?php
    /**
     * User registration page
     *
     * @param string $email user email, $name user name, $surname user surname, $password user password, $photo_destination user photo
     * @return none or error
     * @throws none
     */
    session_start();
    require_once 'func/user_database_func.php';
    // FORMULÁŘ JE ODESLÁN
        if(isset($_POST['submit'])) {
            // ZÍSKÁNÍ DAT Z FORMULÁŘE
            if(isset($_POST['email']) && !empty($_POST['email'])){
                $email = ($_POST['email']);
                // KONTROLA EMAILU
                if (filter_var($email, FILTER_VALIDATE_EMAIL)){
                    // ZÍSKÁNÍ UŽIVATELE Z DATABÁZE
                    $user = getUser($email);
        
                    // UŽIVATEL NEEXISTUJE
                    if(!$user) {
                        // ZÍSKÁNÍ HESLA Z FORMULÁŘE
                        if(isset($_POST['password']) && !empty($_POST['password'])){
                            $password = ($_POST['password']);
                            // KONTROLA DÉLKY HESLA
                            if(strlen($password) >= 8){
                                if(isset($_POST['password2']) && !empty($_POST['password2'])){
                                    // ZÍSKÁNÍ POTRVZENÍ HESLA Z FORMULÁŘE
                                    $password2 = ($_POST['password2']);
                                    // HESLA SE SHODUJÍ
                                    if($password == $password2) {
                                        if(isset($_POST['name']) && !empty($_POST['name']) && preg_match('/^[A-Za-zÁáČčĎďÉéĚěÍíŇňÓóŘřŠšŤťÚúŮůÝýŽž]+$/', $_POST['name'])){
                                            // ZÍSKÁNÍ JMÉNA Z FORMULÁŘE
                                            $name = ($_POST['name']);
                                            if(isset($_POST['surname']) && !empty($_POST['surname']) && preg_match('/^[A-Za-zÁáČčĎďÉéĚěÍíŇňÓóŘřŠšŤťÚúŮůÝýŽž]+$/', $_POST['surname'])){
                                                // ZÍSKÁNÍ PŘÍJMENÍ Z FORMULÁŘE
                                                $surname = ($_POST['surname']);
                                                if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                                                    // ZÍSKÁNÍ FOTKY Z FORMULÁŘE
                                                    $photo = $_FILES['photo'];
                                                    $photo_name = $photo['name'];
                                                    $photo_tmp_name = $photo['tmp_name'];
                                                    $photo_size = $photo['size'];
                                                    $photo_error = $photo['error'];
                                                    $photo_type = $photo['type'];
                                                    $photo_ext = pathinfo($photo_name, PATHINFO_EXTENSION);
                                                    $photo_ext = strtolower($photo_ext);
                                                    $photo_allowed = ['jpg', 'jpeg', 'png'];
                                                    // KONTROLA PŘÍPONY FOTKY
                                                    if (in_array($photo_ext, $photo_allowed)){
                                                        // KONTROLA VELIKOSTI FOTKY
                                                        if ($photo_size < 1000000) {
                                                            $photo_new_name = uniqid('', true) . '.' . $photo_ext;
                                                            $photo_destination = 'uploads/' . $photo_new_name;
                                                            // PŘESUNUTÍ FOTKY DO SLOŽKY
                                                            move_uploaded_file($photo_tmp_name, $photo_destination);
                                                            
                                                            // PŘIDÁNÍ UŽIVATELE DO DATABÁZE
                                                            if (isset($photo_destination)) {
                                                                addUser($email, $name, $surname, $password, $photo_destination);
                                                                // PŘESMĚROVÁNÍ NA HLAVNÍ STRÁNKU
                                                                header('Location: login.php');
                                                            } else {
                                                                $error = 'Soubor se nepodařilo nahrát!';
                                                                $wrong_mail = $_POST['email'];
                                                                $wrong_name = $_POST['name'];
                                                                $wrong_surname = $_POST['surname'];
                                                            }
                                                            
                
                                            
                                            } else {
                                                $error = 'Soubor je příliš veliký!';
                                                $wrong_mail = $_POST['email'];
                                                $wrong_name = $_POST['name'];
                                                $wrong_surname = $_POST['surname'];
                                            }} else {
                                                $error = 'Nelze nahrát soubory tohoto typu! Povolené jsou pouze soubory typu jpg, jpeg a png.';
                                                $wrong_mail = $_POST['email'];
                                                $wrong_name = $_POST['name'];
                                                $wrong_surname = $_POST['surname'];
                                            }
                                        } else {
                                            $error = 'Nebyl přidán soubor';
                                            $wrong_mail = $_POST['email'];
                                            $wrong_name = $_POST['name'];
                                            $wrong_surname = $_POST['surname'];
                                        }
                                    } else {
                                        $error = 'Nebylo zadáno příjmení nebo bylo zadáno ve špatném formátu';
                                        $wrong_mail = $_POST['email'];
                                        $wrong_name = $_POST['name'];
                                        $wrong_surname = $_POST['surname'];
                                    }
                                } else {
                                    $error = 'Nebylo zadáno jméno nebo bylo zadáno ve špatném formátu';
                                    $wrong_mail = $_POST['email'];
                                    $wrong_name = $_POST['name'];
                                    $wrong_surname = $_POST['surname'];
                                }
                            } else {
                                $error = 'Hesla se neshoduji';
                                $wrong_mail = $_POST['email'];
                                $wrong_name = $_POST['name'];
                                $wrong_surname = $_POST['surname'];
                            }       
            } else {
                $error = 'Nebylo zadáno heslo';
                $wrong_mail = $_POST['email'];
                $wrong_name = $_POST['name'];
                $wrong_surname = $_POST['surname'];
            }} else {
                $error = 'Heslo musí mít alespoň 8 znaků';
                $wrong_mail = $_POST['email'];
                $wrong_name = $_POST['name'];
                $wrong_surname = $_POST['surname'];
            }} else {
                $error = 'Nebylo zadáno heslo';
                $wrong_mail = $_POST['email'];
                $wrong_name = $_POST['name'];
                $wrong_surname = $_POST['surname'];
            }
        } else {
            $error = 'Uživatel již existuje';
        }} else {
            $error = 'Email není ve správném formátu';
        }} else {
            $error = 'Nebyl zadán email';
        }
    }
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>is.facr.registrace</title>
    <link rel="stylesheet" type="text/css" href="styles/styles.css" media="all">
    <link rel="stylesheet"  href="styles/print.css" media="print">
    <link rel="icon" type="image/png" href="img/logo.png">
    <script defer src="js/script.js"></script>
</head>
<body>
<?php 
    include 'includes/header.php';
?>
<section class="sect-reg">
    <div class="form-box-reg">
        <form action="register.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?php uniqid(); ?>">
        <h2>Registrace</h2>
            <div>
                <?php if(isset($error))
                    echo '<p class="error">'.$error.'</p>';
                ?>
                <span class="error">
                    
                </span>
            </div>
            <div>
                <fieldset class="sect-field-reg">
                    <legend>
                        Profil
                    </legend>
                    <div>
                        <a class="login-reg" href="login.php">Už máte účet? </a>
                    </div>
                    <div>
                        <input class="login-reg" type="reset" id="reset" value="Vymazat zadané údaje">
                    </div>
                    <div class="inputbox-reg">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Email*" value="<?php global $wrong_mail; if(isset($wrong_mail)) {echo htmlspecialchars($wrong_mail);} else {echo '';}?>" >
                    </div>
                    <div class="inputbox-reg">
                        <label for="password">Heslo</label>
                        <input type="password" id='password' name="password" placeholder="Heslo*" >
                    </div>
                    <div class="inputbox-reg">
                        <label for="password2">Potvrzení hesla</label>
                        <input type="password" id='password2' name="password2" placeholder="Potvrzení hesla*" >
                    </div>
                    <div>
                        <p id="length"></p>
                        <p id="same"></p>
                    </div>
                    <div class="inputbox-reg">
                    <label>Sem přidejte svůj profilový obrázek: *</label>
                        <input type="file" name="photo" id="photo">
                    </div>

                </fieldset>
                <fieldset class="sect-field-reg">
                    <legend>
                        Osobní údaje
                    </legend>
                    <div class="inputbox-reg">
                        <label for="name">
                            Jméno
                            <input type="text"  placeholder="Jméno*" name="name" id="name" value="<?php global $wrong_name; if(isset($wrong_name)) {echo htmlspecialchars($wrong_name);} else {echo '';}?>" >
                        </label>
                        <p id="tagname"></p>
                        <br>
                        <label for="surname">
                            Přijmení
                            <input type="text" placeholder="Přijmení*" name="surname"  id="surname" value="<?php global $wrong_surname; if(isset($wrong_surname)) {echo htmlspecialchars($wrong_surname);} else {echo '';}?>" >
                        </label>
                        <p id="tagsurname"></p>
                        <br>
                    </div>
                </fieldset>
                <h4>* tyto položky jsou povinné a musí být zelená</h4>
            </div>
            <button class="login-reg" id="submit" name="submit">Register</button>
        </form>
    </div>
</section>
<?php 
    include 'includes/footer.php';
?>

</body>
</html>