<?php

/**
 * Description of Login
 *
 * @author ehugh
 */
class Login {

    private $db_connection = null;

    public $errors = array();

    public $messages = array();


    public function __construct($connection)
    {
        
        // create/read session, absolutely necessary
        session_start();
        session_regenerate_id();

        $this->db_connection = $connection;
        // check the possible login actions:
        // if user tried to log out (happen when user clicks logout button)
        if (isset($_GET["logout"])) {
            $this->doLogout();
        }
        // login via post data (if user just submitted a login form)
        elseif (isset($_POST["login"])) {
            $this->dologinWithPostData();
        }
    }

    /**
     * log in with post data
     */
    private function dologinWithPostData()
    {
        // check login form contents
        if (empty($_POST['user_email'])) {
            $this->errors[] = "Username field was empty.";
        } elseif (empty($_POST['user_password'])) {
            $this->errors[] = "Password field was empty.";
        } elseif (!empty($_POST['user_email']) && !empty($_POST['user_password'])) {

            // create a database connection, using the constants from config/db.php (which we loaded in index.php)
            
            // if no connection errors (= working database connection)
            if (true) {

                // escape the POST stuff
                $user_email = $_POST['user_email'];

                // check if user is already registered
                $result_of_login_check = $this->db_connection->isUserAlreadyRegistered($user_email);

                // if this user exists
                if ($result_of_login_check  == true) {
                    //create user from pdo to get hash
                        $userTemp = $this->db_connection->createUserFromEmail($user_email);
                    if ($userTemp->getLoginAttempts() < 3) {

                        // using PHP 5.5's password_verify() function to check if the provided password fits
                        // the hash of that user's password
                        if (password_verify($_POST['user_password'], $userTemp->getPassword())) {

                            // write user data into PHP SESSION
                            $_SESSION['user_email'] = $userTemp->getEmail();
                            $_SESSION['user_login_status'] = 1;
                            $_SESSION['user_book_line_id'] = $userTemp->getBookLineId() == null ? 1 : $userTemp->getBookLineId();
                            $_SESSION['user_read_speed'] = $userTemp->getReadSpeed();

                        } else {
                            $this->db_connection->updateBadLoginAttemptFromEmail($user_email);
                            $this->errors[] = "Wrong password. Try again.";
                        }
                    }
                    else{
                        $this->errors[] = "Too many login attempts. No speed reader for you. biiiiiiii";
                    }
                } else {
                    $this->errors[] = "This user does not exist.";
                }
            } else {
                $this->errors[] = "Database connection problem.";
            }
        }
    }

    /**
     * perform the logout
     */
    public function doLogout()
    {
        // delete the session of the user
        //update users information from session
        $user_email = $_SESSION['user_email'];
        $user_book_line_id =$_COOKIE['user_book_line_id'];
        $user_read_speed =$_COOKIE['user_read_speed'];

        $userTemp = $this->db_connection->createUserFromEmail($user_email);

        if ($userTemp->getBookLineId() !== $user_book_line_id
            || $userTemp->getReadSpeed() !== $user_read_speed){
            $this->db_connection->updateUserOnLogout($user_email,$user_book_line_id, $user_read_speed);
        }

        $_SESSION = array();
        session_destroy();

        $this->messages[] = "You have been logged out.";

    }

    /**
     * simply return the current state of the user's login
     * @return boolean user's login status
     */
    public function isUserLoggedIn()
    {
        if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
            return true;
        }
        // default return
        return false;
    }
}