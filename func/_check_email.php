<?php
/**
 * Check if email is taken with help of AJAX
 * @param string $email
 * @return array|null
 * @throws none
 */
$DB_FILE = '/home/panchluk/www/data/database.json';
$file = file_get_contents($DB_FILE);
$db = json_decode($file, true);

    function getLopatum($email) {
        global $db;
        // loop through all users
        foreach($db as $user) {
            // check if the user's email matches the given email
            if($user['email'] == $email) {
                // return the user
                return $user;
            }
        }
        // return null if no user was found
        return null;
    }
if (isset($_GET['email']) && !empty($_GET['email'])) {
        $emailToCheck = $_GET['email'];
        $emailTaken = getLopatum($emailToCheck);

        if ($emailTaken) {
            echo '{"error" : "Email is already taken"}';
        } else {
            echo '{"error" : ""}';
        }
    }
    else {
        echo '{"error" : "Email is not set"}';
    }
?>