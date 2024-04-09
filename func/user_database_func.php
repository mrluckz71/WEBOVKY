<?php
    // Path: func/user_database_func.php
    /**
    * This file contains functions for managing the user database.
    * @param string $email, $name, $surname, $password file $photo_destination
    * @return none
    * @throws none
    */

    // get the database file
    $DB_FILE = '/home/panchluk/www/data/database.json';
    $file = file_get_contents($DB_FILE);
    $db = json_decode($file, true);
    if (!$db) {
        header('Location: /home/panchluk/www/error.php');
    }
    
    /**
    *   Save the database to the file
    *   @param array $db
    *   @return none
    */
    // store to file
    function saveDatabase() {
        global $db;
        global $DB_FILE;
        // encode the database array into a JSON string
        $json = @json_encode($db);
        
        
        // check if the JSON string was created successfully
        if (!$json) {
            header('Location: /home/panchluk/www/error.php');
        }

        // save the JSON string to the database file
        $result = @file_put_contents($DB_FILE, $json);

        // check if the file was saved successfully
        if (!$result) {
            header('Location: /home/panchluk/www/error.php');
        }

    }

    /** 
    *   Add a new user to the database
    *   @param string $email, $name, $surname, $password, $photo_destination
    *   @return none
    *   @throws none
    */
    // ADD USER
    function addUser($email, $name, $surname, $password, $photo_destination) {
        global $db;
        // create a new user
        $user = [
            // generate a unique id for the user
            'id' => uniqid(),
            'name' => $name,
            'surname' => $surname,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'photo' => $photo_destination
        ];
        // add the new user to the database
        $db[] = $user;
        // save the database
        saveDatabase();
    }
    /**
    *   Get a user from the database
    *   @param string $email
    *   @return array|null
    *   @throws none
    */
    // GET USER
    function getUser($email) {
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
    /**
    *   Get all users from the database
    *   @param none
    *   @return array
    *   
    */
    // GET ALL USERS
    function getAllUsers() {
        global $db;
        return $db;
    }
    /**
    *   Delete a user from the database
    *   @param string $id
    *   @return bool
    *   @throws none
    */
    // DELETE USER
    function deleteUser($id) {
        global $db;
        // loop through all users
        foreach($db as $index => $user) {
            // check if the user's id matches the given id
            if($user['id'] == $id) {
                // remove the user from the database
                unset($db[$index]);
                // save the database
                saveDatabase();
                // return true if the user was deleted
                return true;
            }
        }
        // return false if no user was deleted
        return false;
    }
    /**
    *   Delete all users from the database
    *   @param string $user
    *   @return none
    *   @throws none
    */
    // DELETE ALL USERS
    function deleteAllUsers($user) {
        global $db;
        // set the database to an empty array
        $db = [$user];
        // save the database
        saveDatabase();
    }
    /**
     * Puts back the wrong inputs
     * @param string $wrong_email, $wrong_name, $wrong_surname
     * @return string
     * @throws none
     */
    // PUTING BACK THE WRONG INPUTS, NOT USED
    function putBack ($wrong_email, $wrong_name, $wrong_surname) {
        if(isset($_POST['email']) && !empty($_POST['email'])){
            $wrong_email = htmlspecialchars($_POST['email']);
            return $wrong_email;
        }
        if(isset($_POST['name']) && !empty($_POST['name'])){
            $wrong_name = htmlspecialchars($_POST['name']);
            return $wrong_name;
        }
        if(isset($_POST['surname']) && !empty($_POST['surname'])){
            $wrong_surname = htmlspecialchars($_POST['surname']);
            return $wrong_surname;
        }
    }
?>