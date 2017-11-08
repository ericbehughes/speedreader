<?php

include "User.php";

/**
 * Description of Database
 *
 * @author ehugh
 */
class Database {

    protected $pdo;

//put your code here
    function __construct() {

        $dsn = 'pgsql:dbname=homestead;host=localhost';
        $user = 'homestead';
        $password = 'secret';
        $users = [];

        try {
            $this->pdo = new PDO($dsn, $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // load csv file
            $users = $this->loadUserDateFromCSV("./user_data.csv");
            $this->createItemsDb();
            foreach ($users as $value) {
                $this->insertIntoDB($value);
            }
        } catch (PDOException $e) {
            
        }
    }

    function getPDO() {
        return $this->pdo;
    }

    function fetchAllUser($offset, $limit) {
        $stmt = $this->pdo->prepare("SELECT id, symbol, company AS companyName FROM STOCKS OFFSET ? LIMIT ?;");

        $this->pdo->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');

        if ($users = $stmt->execute([$offset, $limit])) {
            while ($row = $stmt->fetch()) {
                $array[] = $row;
            }
            return $array;
        }

        return null;
    }

    function fetchCountOfUsers() {
        $stmt = $this->pdo->prepare("SELECT count(id) FROM STOCKS;");
        if ($users = $stmt->execute()) {
            $array = $stmt->fetch();
            return $array[0];
        }

        return null;
    }

    function createItemsDb() {
        $stmt = $this->pdo->prepare("DROP TABLE if exists users;");
        $stmt->execute();

        // create table
        $stmt = $this->pdo->prepare('CREATE TABLE IF NOT EXISTS users (
                id SERIAL PRIMARY KEY,
                symbol varchar(10) NOT NULL UNIQUE,
                company varchar(255) NOT NULL UNIQUE);');
        $stmt->execute();
    }

    function insertIntoDB($user) {

        $stmt = $this->pdo->prepare("INSERT INTO users(symbol, company) VALUES (?, ?);");
        if ($stmt->execute([$user->getSymbol(), $user->getCompanyName()])) {
            syslog(1, 'added record');
        } else {
            syslog(1, 'did not add record');
        }
    }

    function loadUserDateFromCSV($path) {

        $file = fopen($path, "r");
        $users = [];
        while ($user = fgets($file)) {
            trim($user);
            $array = explode(",", $user);
            $s = new User($array[0], $array[1]);
            $users[] = $s;
        }
        fclose($file);

        return $users;
    }

}
