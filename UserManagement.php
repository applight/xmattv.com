<?php

class MyDB extends SQLite3 {
    
    public function __construct() {
        $this->open('users.db');
    }

    public function attempt($q, $succ="Success!") {
        $ret = $this->exec($q);
        if(!$ret) {
            return $this->lastErrorMsg();
        } else {
            return $succ;
        }
    }
}



class UserManagement {

    static function createDatabase() {
        
        // opens or creates sqllite database
        $db = new MyDB();
        if(!$db) {
            echo $db->lastErrorMsg();
        } else {
            echo "Opened database successfully\n";
        }

        echo $db->attempt(
            <<<EOF
            CREATE TABLE USERS
            (ID INT PRIMARY KEY     NOT NULL,
            FIRST_NAME      TEXT    NOT NULL,
            LAST_NAME       TEXT    NOT NULL,
            EMAIL           TEXT    NOT NULL,
            EMAIL_VERIFIED  INT     NOT NULL,
            PHONE           INT     NOT NULL,
            PHONE_VERIFIED  INT     NOT NULL);
            EOF,
            "User table successfully created!\n"    
        );

        echo $db->attempt(
            <<<EOF
            CREATE TABLE NOTIFICATIONS
            (PHONE INT PRIMARY KEY     NOT NULL,
            NOTIFICATIONS      INT     NOT NULL);
            EOF,
            "Notifications table successfully created!\n"
        );


        $db->close();

    }

    static function incNotifications( $phone ) {

    }

    static function seeNotifications( $phone ) {
        
    }

    static function registerUser( $first, $last, $email, $phone ) {

    }

    static function verifyEmail( $id ) {

    }
    
    static function verifyPhone( $id ) {

    }

    static
}

?>