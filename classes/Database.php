<?php

include "User.php";

/**
 * Description of Database
 *
 * @author ehugh
 */
class Database {

    protected $pdo;

    function __construct() {

        $dbName = "deguuhfndfrfhc";
        $port = "5432";
        $dsn = "pgsql:dbname= . $dbName . host=ec2-54-221-212-208.compute-1.amazonaws.com;port=.$port .;sslmode=require";
        $user="jctaqifyqumjpu";
        $password ="2bb4210353be6af9d5b30dd6c4b7558e85ed933c74de91b79d57c1be1c5f5804";




//        DATABASE_DSN = 'pgsql:dbname=dfndkk4du1mbjm;host=ec2-54-163-253-94.compute-1.amazonaws.com;port=5432;sslmode=require';
//        DATABASE_USER = 'qhsllrrdxlaldt';
//        DATABASE_PASSWORD = '7e109239a1a0d360611e4b93e26ccf482e27764c6e2038195ec793d85eda4735';


        try {
            $this->pdo = new PDO($dsn, $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        } catch (PDOException $e) {
            
        }
    }

    function getPDO() {
        return $this->pdo;
    }

    function fetchAllUser($offset, $limit) {
        $stmt = $this->pdo->prepare("SELECT id, email FROM USERS;");

        $this->pdo->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');

        if ($users = $stmt->execute([])) {
            while ($row = $stmt->fetch()) {
                $array[] = $row;
            }
            return $array;
        }

        return null;
    }

    function getLineById($id){
        $stmt = $this->pdo->prepare("SELECT * FROM BOOK where id = ?;");
        $this->pdo->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);

        if ($result = $stmt->execute([$id])) {
            if($row = $stmt->fetch()) {
                return $row;
            }

        }
        return null;
    }

    function getMaxLineFromBookTable(){
        $stmt = $this->pdo->prepare("SELECT MAX(id) FROM BOOK");

        $this->pdo->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        //$stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');

        if ($users = $stmt->execute()) {
            if($row = $stmt->fetch()) {
                $rowNum = $row;
            }
            return $rowNum;
        }

        return null;
    }

    
    function isUserAlreadyRegistered($email){
        $stmt = $this->pdo->prepare("SELECT email FROM USERS WHERE email = ?");
        if ($stmt->execute([$email])) {
            if ($row = $stmt->fetch()){
                return true;
            }
        }
        return false;

    }
    
    function createUserFromEmail($user_email){
         $stmt = $this->pdo->prepare("select * from users where email = ?");

        $this->pdo->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');

        if ($stmt->execute([$user_email])) {

            if ($row = $stmt->fetch()) {
                $user = $row;
            }
            return $user;
        }

        return null;
    }

    function updateBadLoginAttemptFromEmail($user_email){
        $stmt = $this->pdo->prepare("UPDATE USERS set login_attempts = loginttempts +1 WHERE email = ?;");
        if ($users = $stmt->execute([$user_email])) {
            $result = $stmt->fetch();
            return $result;
        }

        return null;
    }

    function fetchCountOfUsers() {
        $stmt = $this->pdo->prepare("SELECT count(id) FROM USERS;");
        if ($users = $stmt->execute()) {
            $array = $stmt->fetch();
            return $array[0];
        }

        return null;
    }

    function createUsersTable() {
        $stmt = $this->pdo->prepare("DROP TABLE if exists USERS;");
        $stmt->execute();

        // create table
        $stmt = $this->pdo->prepare(
            'CREATE TABLE IF NOT EXISTS users (
                id SERIAL PRIMARY KEY,
                email varchar(64) NOT NULL UNIQUE,
                password varchar(255) NOT NULL,
                book_line_id int references book (id),
                read_speed int default 50,
                login_attempts int DEFAULT  0);');
        $stmt->execute();
    }

    function createBookTable() {
        $stmt = $this->pdo->prepare("DROP TABLE if exists BOOK;");
        $stmt->execute();

        // create table
        $stmt = $this->pdo->prepare('CREATE TABLE IF NOT EXISTS BOOK(
                id SERIAL PRIMARY KEY,
                line unlimited varchar NOT NULL);');
        $stmt->execute();
    }


    function insertIntoUserTable($user) {

        $stmt = $this->pdo->prepare("INSERT INTO users(email, password) VALUES (?, ?);");
        if ($stmt->execute([$user->getEmail(), $user->getPassword()])) {
            syslog(1, 'added record');
        } else {
            syslog(1, 'did not add record');
        }
    }


    function insertLineIntoTable($line) {

        $stmt = $this->pdo->prepare("INSERT INTO BOOK(line) VALUES (?);");
        if ($stmt->execute([$line])) {
            syslog(1, 'added record');
        } else {
            syslog(1, 'did not add record');
        }
    }

    function loadLinesIntoBookTable() {
        $path = 'http://www.textfiles.com/etext/FICTION/aesop11.txt';
        $file = fopen($path, "r");
        //$lines = [];
        $blankLineCount = 0;
        while ($line = fgets($file)) {
            $line = trim($line);
            if (strlen($line) === 0 && $blankLineCount < 1){
                $this->insertLineIntoTable($line);
                $blankLineCount++;
            }
            elseif (strlen($line) > 0){
                $this->insertLineIntoTable($line);
                $blankLineCount = 0;

            }

        }
        fclose($file);
    }

    function updateUserOnLogout($user_email, $book_line_id, $read_speed){
        $book_line_id = (int)$book_line_id;
        $read_speed = (int)$read_speed;

        $stmt = $this->pdo->prepare("UPDATE USERS set book_line_id = ?, read_speed = ? WHERE email = ?;");
        if ($users = $stmt->execute([$book_line_id, $read_speed, $user_email])) {
            $result = $stmt->fetch();
            return $result;
        }

        return null;
    }

    function updateUserReadSpeed($user_email, $read_speed){
        $stmt = $this->pdo->prepare("UPDATE USERS set read_speed = ? WHERE email = ?;");
        if ($users = $stmt->execute([$read_speed, $user_email])) {
            $result = $stmt->fetch();
            return $result;
        }

        return null;
    }

}
