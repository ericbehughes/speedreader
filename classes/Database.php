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

        $dsn = 'pgsql:dbname=homestead;host=localhost';
        $user = 'homestead';
        $password = 'secret';
        $users = [];

        try {
            $this->pdo = new PDO($dsn, $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //$this->loadLinesIntoBookTable("");

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
                $email = $row;
            }
            return $email;
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
        $stmt = $this->pdo->prepare('CREATE TABLE IF NOT EXISTS users (
                id SERIAL PRIMARY KEY,
                email varchar(64) NOT NULL UNIQUE,
                password varchar(255) NOT NULL);');
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


    function insertUserIntoUserTable($user) {

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

    function loadLinesIntoBookTable($path) {


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

}
