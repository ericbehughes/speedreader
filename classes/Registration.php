<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Registration
 *
 * @author ehugh
 */
class Registration
{

    private $db_connection = null;

    public $errors = array();

    public $messages = array();


    public function __construct($connection)
    {   
        // assign db connection
        $this->db_connection = $connection;
        //check if post is from the register form
        session_regenerate_id();
        if (isset($_POST["register"])) {
            $this->registerNewUser();

        }
    }

    /**
     * handles the entire registration process. checks all error possibilities
     * and creates a new user in the database if everything is fine
     */
    private function registerNewUser()
    {
        //check empty email
        if (empty($_POST['user_email'])) {
            $this->errors[] = "Email cannot be empty";
            //check length of email
        } elseif (strlen($_POST['user_email']) > 64) {
            $this->errors[] = "Email cannot be longer than 64 characters";
        } elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Your email address is not in a valid email format";
        } elseif (empty($_POST['user_password_new']) || empty($_POST['user_password_repeat'])) {
            $this->errors[] = "Empty Password";
        } elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
            $this->errors[] = "Password and password repeat are not the same";
        } elseif (strlen($_POST['user_password_new']) < 6) {
            $this->errors[] = "Password has a minimum length of 6 characters";
        }
        // valid data
            elseif (!empty($_POST['user_email'])
            && strlen($_POST['user_email']) <= 64
            && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)
            && !empty($_POST['user_password_new'])
            && !empty($_POST['user_password_repeat'])
            && ($_POST['user_password_new'] === $_POST['user_password_repeat'])) {

            //sanitize the post data then begin
            if (true) {
                $user_email = $_POST['user_email'];
                $user_password = $_POST['user_password_new'];
                $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);

                // check if user or email address already exists
                if ($this->db_connection->isUserAlreadyRegistered($user_email)) {
                    $this->errors[] = "Sorry, that username / email address is already taken.";
                } else {
                    // write new user's data into database
                    $user = new User($user_email, $user_password_hash);
                    $this->db_connection->insertIntoUserTable($user);
                    $_SESSION['user_login_status'] = 1;
                    $_SESSION['user_email'] = $user->getEmail();
                    $_SESSION['user_read_speed'] = $user->getReadSpeed();
                    $_SESSION['user_book_line_id'] = $user->getBookLineId();

                    header("Location: index.php");

                    // check return of insertIntoDB
                }
            } else {
                $this->errors[] = "Sorry, no database connection.";
            }
        } else {
            $this->errors[] = "An unknown error occurred.";
        }
    }
}